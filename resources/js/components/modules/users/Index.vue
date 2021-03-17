<template>
  <!-- Content Wrapper. Contains page content -->
  <div>
    <!-- list table -->
    <list :users="users" :count="count" :edit="edit">
      <infinite-loading @infinite="index" spinner="spiral" ref="infinite">
        <div slot="no-more">
          <small>{{ `${count} registros encontrados` }}</small>
        </div>
        <div slot="no-results">Nenhum resultado encontrado</div>
      </infinite-loading>
    </list>
    <!-- search aside -->
    <!--<search /> -->
    <!-- This div must be placed immediately after the control sidebar -->
    <!--<div class="control-sidebar-bg"></div>-->
    <!-- edit modal -->
    <edit :target="target" :groups="groups" :departments="departments" :update="update"/>
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
      target: null,
      //search
      searched_name: null,
      searched_email: null,
      searched_department: null,
      searched_group: null,
      //infinite loading
      skip: 0,
      take: 5,
      //count
      count: 0,
    };
  },
  created() {
    this.getDepartments();
    this.getGroups();
  },
  methods: {
    /*--------*/
    /** @read */
    /*--------*/
    index($state) {
      setTimeout(() => {
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
              $state.loaded();
            } else {
              $state.complete();
            }
          })
          .catch((e) => {
            console.log(e.response.data.message);
          });
      }, 1000);
    },
    /*----------*/
    /** @create */
    /*----------*/
    store() {},
    /*----------*/
    /** @update */
    /*----------*/
    update($target) {
      console.log('update function');
      console.log($target);
      //this.user = $id;
      //$("#edit-modal").modal("show");
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
      /* api */
      const api = `${this.$urlAPI}user/find`;
      /* request */
      this.$axios
        .get(api, {
          params: {
            uuid: $uuid
          }  
        })
        .then(({ data }) => {
          this.target = data.user;
          $("#edit-modal").modal("show");
        })
        .catch((e) => {
          console.log(e.response.data.message);
        });
    },
  },
};
</script>
