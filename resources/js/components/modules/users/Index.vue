<template>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- list table -->
    <list :users="users">
      <infinite-loading @infinite="index" spinner="spiral" ref="infinite">
        <div slot="no-more">Sem mais resultados</div>
        <div slot="no-results">Nenhum resultado encontrado</div>
      </infinite-loading>
    </list>
    <!-- search aside -->
    <search />
    <!-- This div must be placed immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
    <!-- edit modal -->
    <edit />
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
      //search
      searched_name: null,
      searched_email: null,
      searched_department: null,
      searched_group: null,
      //infinite loading
      skip: 0,
      take: 5,
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
    update($id) {
      $("#edit-modal").modal("show");
    },
    /*----------*/
    /** @delete */
    /*----------*/
    destroy() {},
    /*-------*/
    /** @get */
    /*-------*/
    getDepartments() {
      /* api */
      const api = `${this.$urlAPI}department/all`;
      /* request */
      this.$axios
        .get(api, {})
        .then(({ data }) => {
          this.departments = data.departments;
        })
        .catch((e) => {
          console.log(e.response.data.message);
        });
    },
    getGroups() {
      /* api */
      const api = `${this.$urlAPI}group/all`;
      /* request */
      this.$axios
        .get(api, {})
        .then(({ data }) => {
          this.groups = data.groups;
        })
        .catch((e) => {
          console.log(e.response.data.message);
        });
    },
    /*--------*/
    /** @post */
    /*--------*/

    /*----------*/
    /** @others */
    /*----------*/
  },
};
</script>
