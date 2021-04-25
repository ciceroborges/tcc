<template>
  <!-- Content Wrapper. Contains page content -->
  <div>
    <!-- list table -->
    <list
      :departments="departments"
      :count="count"
      :index="index"
      :edit="edit"
      ref="DepartmentList"
    />
    <!-- search aside -->
    <!--<search /> -->
    <!-- This div must be placed immediately after the control sidebar -->
    <!--<div class="control-sidebar-bg"></div>-->
    <!-- edit modal -->
    <edit :target="target" :store="store" :update="update" :destroy="destroy" />
  </div>
  <!-- /.content-wrapper -->
</template>
<script>
// componentes importados
import Edit from "../departments/Edit.vue";
import List from "../departments/List.vue";
//import Search from "../users/Search.vue";

export default {
  name: "Departments",
  components: {
    Edit,
    List,
    //Search,
  },
  props: {
    searched_department: String,
  },
  data() {
    return {
      //general
      departments: [],
      //edit
      target: {},
      //search
      filter: this.searched_department,
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
      const api = `${this.$urlAPI}department/index`;
      /* request */
      this.$axios
        .get(api, {
          params: {
            filter: this.searched_department,
            skip: this.skip,
            take: this.take,
          },
        })
        .then(({ data }) => {
          if (data.departments.length) {
            this.skip = data.skip;
            this.count = this.departments.length + data.departments.length;
            this.departments.push(...data.departments);

            if (data.departments.length === this.take) {
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
    store($target) {
      /* begin loading spinner*/
      this.$loading(true);
      /* close edit modal */
      $("#edit-department").modal("hide");
      /* api */
      const api = `${this.$urlAPI}department/store`;
      /* request */
      this.$axios
        .post(api, {
          name: $target.name,
        })
        .then(({ data }) => {
          if (data.status) {
            this.departments.push(data.department);
            alert(data.message);
          } else {
            alert(data.message);
            $("#edit-department").modal("show");
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
    /** @update */
    /*----------*/
    update($target) {
      /* begin loading spinner*/
      this.$loading(true);
      /* close edit modal */
      $("#edit-department").modal("hide");
      /* api */
      const api = `${this.$urlAPI}department/update`;
      /* request */
      this.$axios
        .put(api, {
          id: $target.id,
          name: $target.name,
        })
        .then(({ data }) => {
          if (data.status) {
            let index = this.departments.findIndex(
              (item) => item.id === data.department.id
            );
            if (index !== -1) {
              this.departments[index].name = data.department.name;
            }
            alert(data.message);
          } else {
            alert(data.message);
            $("#edit-department").modal("show");
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
        `Você tem certeza? O departamento ${$target.name} será excluído e os atendimentos vinculados a ele não estarão mais disponíveis. Está ação não poderá ser desfeita.`
      );
      if ($confirm) {
        /* begin loading spinner*/
        this.$loading(true);
        /* close edit modal */
        $("#edit-department").modal("hide");
        /* api */
        const api = `${this.$urlAPI}department/destroy`;
        /* request */
        this.$axios
          .delete(api, {
            params: {
              id: $target.id,
            },
          })
          .then(({ data }) => {
            if (data.status) {
              console.log("status");
              let index = this.departments.findIndex(
                (item) => item.id === data.department.id
              );
              if (index !== -1) {
                console.log("status");
                this.departments.splice(index, 1);
                if (this.count > 0) {
                  this.count--;
                }
              }
              alert(data.message);
            } else {
              alert(data.message);
              $("#edit-department").modal("hide");
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

      if ($id === 0) {
        this.target.id = null;
        this.target.name = null;
        this.target.new_record = true;
        // show edit modal
        $("#edit-department").modal("show");
        // stop loading spinner
        this.$loading(false);
      } else {
        /* api */
        const api = `${this.$urlAPI}department/find`;
        /* request */
        this.$axios
          .get(api, {
            params: {
              id: $id,
            },
          })
          .then(({ data }) => {
            // get target data
            this.target = data.department;
            this.target.new_record = false;
            // show edit modal
            $("#edit-department").modal("show");
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
      }
    },
  },
  watch: {
    searched_department() {
      this.filter = this.searched_department;
      this.departments = [];
      this.skip = 0;
      this.count = 0;
      this.$refs.DepartmentList.$refs.infiniteDepartmentsTable.stateChanger.reset();
    },
  },
};
</script>
