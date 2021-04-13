<template>
  <!-- Content Wrapper. Contains page content -->
  <div>
    <!-- list table -->
    <list :users="users" :count="count" :index="index" :edit="edit" />
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
    />
  </div>
  <!-- /.content-wrapper -->
</template>
<script>
// componentes importados
import Edit from "../users/Edit.vue";
import List from "../users/List.vue";
import Search from "../users/Search.vue";

export default {
  name: "Users",
  components: {
    Edit,
    List,
    Search,
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
      searched_name: null,
      searched_email: null,
      searched_department: null,
      searched_group: null,
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
              skip: this.skip,
              take: this.take,
            },
          })
          .then(({ data }) => {
            if (data.users.length) {
              this.skip = data.skip;
              this.count = this.users.length + data.users.length;
              this.users.push(...data.users);

              if(data.users.length === this.take) {
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
          console.log(data);
          /* close edit modal */
          $("#edit-user").modal("hide");
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
    destroy() {},
    /*-------*/
    /** @get */
    /*-------*/
    getDepartments() {
      /* begin loading spinner*/
      this.$loading(true);
      /* api */
      const api = `${this.$urlAPI}department/all`;
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
      const api = `${this.$urlAPI}group/all`;
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
};
</script>
