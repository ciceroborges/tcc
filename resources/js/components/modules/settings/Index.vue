<template>
  <div class="content-wrapper" style="min-height: 1136px">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Configurações</h1>
      <ol class="breadcrumb">
        <li>
          <a href="#"><i class="fa fa-home"></i> Home</a>
        </li>
        <li class="active">Configurações</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li @click="activeTab('users')" class="active">
                <a href="#users" data-toggle="tab" aria-expanded="true"
                  >Usuários</a
                >
              </li>
              <li @click="activeTab('groups')" class="">
                <a href="#groups" data-toggle="tab" aria-expanded="false"
                  >Grupos</a
                >
              </li>
              <li @click="activeTab('departments')" class="">
                <a href="#departments" data-toggle="tab" aria-expanded="false"
                  >Departamentos</a
                >
              </li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="users">
                <users-index ref="users" v-if="users_tab"/>
              </div>
              <div class="tab-pane" id="groups">groups</div>
              <div class="tab-pane" id="departments">departments</div>
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <users-search/>
    <div class="control-sidebar-bg"></div>
    <!-- /.content -->
  </div>
</template>
<script>
// componentes importados
import UsersIndex from "../users/Index.vue";
import UsersSearch from "../users/Search.vue";
//import List from "../users/List.vue";
//import Search from "../users/Search.vue";

export default {
  name: "Settings",
  components: {
    UsersIndex,
    UsersSearch
    //Edit,
    //List,
    //Search,
  },
  data() {
    return {
      //general
      // tabs
      users_tab: true,
      group_tab: true,
      department_tab: true,
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
    //this.getDepartments();
    //this.getGroups();
  },
  mounted() {
    //this.$refs.users.update(1);
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
    activeTab($tab) {
      switch ($tab) {
        case "users":
          if(!this.users_tab){
            this.users_tab = true;
            this.department_tab = false;
            this.group_tab = false;
          }
          break;
        case "departments":
          if(!this.department_tab){
            this.users_tab = false;
            this.department_tab = true;
            this.group_tab = false;
          }  
          break;
        case "groups":
          if(!this.groups_tab){
            this.users_tab = false;
            this.department_tab = false;
            this.group_tab = true;
          }
          break;
      }
    },
  },
};
</script>