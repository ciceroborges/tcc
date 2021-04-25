<template>
  <!-- Content Wrapper. Contains page content -->
  <div>
    <!-- list table -->
    <list :users="users" :count="count" :index="index" :edit="edit" ref="UserList" />
    <!-- search aside -->
    <!--<search /> -->
    <!-- This div must be placed immediately after the control sidebar -->
    <!--<div class="control-sidebar-bg"></div>-->
    <!-- edit modal -->
    <edit
      :target="target"
      :target_group="target_group"
      :target_departments="target_departments"
      :groups="groups"
      :departments="departments"
      :update="update"
      :destroy="destroy"
    />
  </div>
  <!-- /.content-wrapper -->
</template>
<script>
// componentes importados
import Edit from "../users/Edit.vue";
import List from "../users/List.vue";
//import Search from "../users/Search.vue";

export default {
  name: "Users",
  components: {
    Edit,
    List,
    //Search,
  },
  props: {
    searched_user: String,
  },
  data() {
    return {
      //general
      users: [],
      departments: [],
      groups: [],
      //edit
      target: {},
      target_group: [],
      target_departments: [],
      //search
      filter: this.searched_user,
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
      const api = `${this.$urlAPI}user/index`;
      /* request */
      this.$axios
        .get(api, {
          params: {
            filter: this.searched_user,
            skip: this.skip,
            take: this.take,
          },
        })
        .then(({ data }) => {
          if (data.users.length) {
            this.skip = data.skip;
            this.count = this.users.length + data.users.length;
            this.users.push(...data.users);

            if (data.users.length === this.take) {
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
      $("#edit-user").modal("hide");
      /* api */
      const api = `${this.$urlAPI}user/update`;
      /* request */
      this.$axios
        .put(api, {
          uuid: $target.uuid,
          name: $target.name,
          email: $target.email,
          group: $target.group,
          departments: $target.departments,
        })
        .then(({ data }) => {
          if (data.status) {
            let index = this.users.findIndex(
              (item) => item.uuid === data.user.uuid
            );
            if (index !== -1) {
              this.users[index].name = data.user.name;
              this.users[index].email = data.user.email;
              this.users[index].group_name = data.user.group_name;
              this.users[index].departments_names = data.user.departments_names;
            }
            alert(data.message);
          } else {
            alert(data.message);
            $("#edit-user").modal("show");
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
        `Você tem certeza? O usuário ${$target.name} será excluído. Está ação não poderá ser desfeita.`
      );
      if ($confirm) {
        /* begin loading spinner*/
        this.$loading(true);
        /* close edit modal */
        $("#edit-user").modal("hide");
        /* api */
        const api = `${this.$urlAPI}user/destroy`;
        /* request */
        this.$axios
          .delete(api, {
            params: {
              uuid: $target.uuid,
            },
          })
          .then(({ data }) => {
            if (data.status) {
              let index = this.users.findIndex(
                (item) => item.uuid === data.user.uuid
              );
              if (index !== -1) {
                this.users.splice(index, 1);
                if(this.count > 0) {
                  this.count --;
                }
              }
              alert(data.message);
            } else {
              alert(data.message);
              $("#edit-user").modal("hide");
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
    getDepartments() {
      /* begin loading spinner*/
      this.$loading(true);
      /* api */
      const api = `${this.$urlAPI}department/index`;
      /* request */
      this.$axios
        .get(api, {})
        .then(({ data }) => {
          this.departments = data.departments;
          this.$loading(false);
        })
        .catch((e) => {
          console.log(e.response.data.message);
          this.$loading(false);
        });
    },
    getGroups() {
      /* begin loading spinner*/
      this.$loading(true);
      /* api */
      const api = `${this.$urlAPI}group/index`;
      /* request */
      this.$axios
        .get(api, {})
        .then(({ data }) => {
          this.groups = data.groups;
          this.$loading(false);
        })
        .catch((e) => {
          console.log(e.response.data.message);
          this.$loading(false);
        });
    },
    /*--------*/
    /** @post */
    /*--------*/

    /*----------*/
    /** @others */
    /*----------*/
    edit($uuid) {
      // start loading spinner
      this.$loading(true);
      this.target = {};
      this.target_group = [];
      this.target_departments = [];

      this.getDepartments();
      this.getGroups();
      /* api */
      const api = `${this.$urlAPI}user/find`;
      /* request */
      this.$axios
        .get(api, {
          params: {
            uuid: $uuid,
          },
        })
        .then(({ data }) => {
          // get target data
          this.target = data.user;
          // get target departments
          if (data.user.departments_ids) {
            let departments = data.user.departments_ids.split(",");
            departments.forEach((element) => {
              let index = this.departments.findIndex(
                (item) => item.id === parseInt(element)
              );
              if (index !== -1) {
                this.target_departments.push(this.departments[index]);
              }
            });
          }
          if (data.user.group_id) {
            // get target group
            let index = this.groups.findIndex(
              (item) => item.id === data.user.group_id
            );
            if (index !== -1) {
              this.target_group.push(this.groups[index]);
            }
          }
          // show edit modal
          $("#edit-user").modal("show");
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
    searched_user(){
      this.filter = this.searched_user;
      this.users = [];
      this.skip = 0;
      this.count = 0;
      this.$refs.UserList.$refs.infiniteUsersTable.stateChanger.reset();
    }
  }
};
</script>
