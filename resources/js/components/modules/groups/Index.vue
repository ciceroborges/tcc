<template>
  <!-- Content Wrapper. Contains page content -->
  <div>
    <!-- list table -->
    <list :groups="groups" :count="count" :index="index" :edit="edit" ref="GroupList"/>
    <!-- search aside -->
    <!--<search /> -->
    <!-- This div must be placed immediately after the control sidebar -->
    <!--<div class="control-sidebar-bg"></div>-->
    <!-- edit modal -->
    <edit
      :target="target"
      :update="update"
      :destroy="destroy"
    />
  </div>
  <!-- /.content-wrapper -->
</template>
<script>
// componentes importados
import Edit from "../groups/Edit.vue";
import List from "../groups/List.vue";
//import Search from "../users/Search.vue";

export default {
  name: "Groups",
  components: {
    Edit,
    List,
    //Search,
  },
  props: {
    searched_group: String,
  },
  data() {
    return {
      //general
      groups: [],
      //edit
      target: {},
      //search
      filter: this.searched_group,
      //infinite loading
      skip: 0,
      take: 30,
      //count
      count: 0,
    };
  },
  created() {},
  methods: {
    /*--------*/
    /** @read */
    /*--------*/
    index($state) {
      /* api */
      const api = `${this.$urlAPI}group/index`;
      /* request */
      this.$axios
        .get(api, {
          params: {
            filter: this.searched_group,
            skip: this.skip,
            take: this.take,
          },
        })
        .then(({ data }) => {
          if (data.groups.length) {
            this.skip = data.skip;
            this.count = this.groups.length + data.groups.length;
            this.groups.push(...data.groups);

            if (data.groups.length === this.take) {
              $state.loaded();
            } else {
              $state.complete();
            }
          } else {
            $state.complete();
          }
        })
        .catch((e) => {
          console.log(e.response.data.message);
        });
    },
    /*----------*/
    /** @create */
    /*----------*/
    store() {},
    /*----------*/
    /** @update */
    /*----------*/
    update($target) {
      /* begin loading spinner*/
      this.$loading(true);
      /* close edit modal */
      $("#edit-group").modal("hide");
      /* api */
      const api = `${this.$urlAPI}group/update`;
      /* request */
      this.$axios
        .put(api, {
          id: $target.id,
          name: $target.name,
        })
        .then(({ data }) => {
          if (data.status) {
            let index = this.groups.findIndex(
              (item) => item.id === data.group.id
            );
            if (index !== -1) {
              this.groups[index].name = data.group.name;
            }
            alert(data.message);
          } else {
            alert(data.message);
            $("#edit-group").modal("show");
          }
          /* stop loading spinner */
          this.$loading(false);
        })
        .catch((e) => {
          if (e.response.data) {
            alert(e.response.data.message);
          } else {
            alert(
              `Ocorreu um problema durante a execução! Tente novamente. Caso o problema persista, reporte o erro ao administrador do sistema. Código de erro: ( ${e} ).`
            );
          }
          /* stop loading spinner */
          this.$loading(false);
        });
    },
    /*----------*/
    /** @delete */
    /*----------*/
    destroy($target) {
      let $confirm = confirm(
        `Você tem certeza? O grupo ${$target.name} será excluído. Está ação não poderá ser desfeita.`
      );
      if ($confirm) {
        /* begin loading spinner*/
        this.$loading(true);
        /* close edit modal */
        $("#edit-group").modal("hide");
        /* api */
        const api = `${this.$urlAPI}group/destroy`;
        /* request */
        this.$axios
          .delete(api, {
            params: {
              id: $target.id,
            },
          })
          .then(({ data }) => {
            if (data.status) {
              let index = this.groups.findIndex(
                (item) => item.id === data.group.uuid
              );
              if (index !== -1) {
                this.groups.splice(index, 1);
                if(this.count > 0) {
                  this.count --;
                }
              }
              alert(data.message);
            } else {
              alert(data.message);
              $("#edit-group").modal("hide");
            }
            /* stop loading spinner */
            this.$loading(false);
          })
          .catch((e) => {
            if (e.response.data) {
              alert(e.response.data.message);
            } else {
              alert(
                `Ocorreu um problema durante a execução! Tente novamente. Caso o problema persista, reporte o erro ao administrador do sistema. Código de erro: ( ${e} ).`
              );
            }
            /* stop loading spinner */
            this.$loading(false);
          });
      }
    },
    /*-------*/
    /** @get */
    /*-------*/
    /*--------*/
    /** @post */
    /*--------*/
    /*----------*/
    /** @others */
    /*----------*/
    edit($id) {
      // start loading spinner
      this.$loading(true);
      this.target = {};

      /* api */
      const api = `${this.$urlAPI}group/find`;
      /* request */
      this.$axios
        .get(api, {
          params: {
            id: $id,
          },
        })
        .then(({ data }) => {
          // get target data
          this.target = data.group;
          // show edit modal
          $("#edit-group").modal("show");
          // stop loading spinner
          this.$loading(false);
        })
        .catch((e) => {
          if (e.response.data) {
            alert(e.response.data.message);
          } else {
            alert(
              `Ocorreu um problema durante a execução! Tente novamente. Caso o problema persista, reporte o erro ao administrador do sistema. Código de erro: ( ${e} ).`
            );
          }
          // stop loading spinner
          this.$loading(false);
        });
    },
  },
  watch: {
    searched_group(){
      this.filter = this.searched_group;
      this.groups = [];
      this.skip = 0;
      this.count = 0;
      this.$refs.GroupList.$refs.infiniteGroupsTable.stateChanger.reset();
    }
  }
};
</script>
