<template>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Page Header
        <small>Optional description</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
              
<!--
              <infinite-loading
                @infinite="getAll"
                spinner="spiral"
                ref="loadUsers"
              >
         
                <div slot="no-more">
                  <hr />
                  <small>Sem mais resultados</small>
                </div>
    
                <div slot="no-results">
                  <hr />
                  <small>Nenhum resultado encontrado</small>
                </div>
              </infinite-loading>
           -->
</template>
<script>
export default {
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
    getAll($state) {
      setTimeout(() => {
        /* api */
        const api = `${this.$urlAPI}user/all`;
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
    getDepartments() {
        /* api */
        const api = `${this.$urlAPI}department/all`;
        /* request */
        this.$axios
          .get(api, {}).then(({ data }) => {
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
          .get(api, {}).then(({ data }) => {
            this.groups = data.groups;
          })
          .catch((e) => {
            console.log(e.response.data.message);
          });
    },
  },
};
</script>