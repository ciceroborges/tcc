<template>
  <div class="content-wrapper" style="min-height: 1136px">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Configurações | {{ title }}</h1>
      <ol class="breadcrumb">
        <li>
          <a href="#"><i class="fa fa-home"></i> Home</a>
        </li>
        <li>Configurações</li>
        <li class="active">{{ title }}</li>
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
                <users-index ref="users" v-if="users_tab" :searched_user="searched_user"/>
              </div>
              <div class="tab-pane" id="groups">
                <groups-index ref="groups" v-if="groups_tab" :searched_group="searched_group"/>
              </div>
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
    <users-search @search="searchUser($event)" />
    <div class="control-sidebar-bg"></div>
    <!-- /.content -->
  </div>
</template>
<script>
// componentes importados
import UsersIndex from "../users/Index.vue";
import UsersSearch from "../users/Search.vue";
import GroupsIndex from "../groups/Index.vue";
import GroupsSearch from "../groups/Search.vue";

export default {
  name: "Settings",
  components: {
    UsersIndex,
    UsersSearch,
    GroupsIndex,
    GroupsSearch,
  },
  data() {
    return {
      //general
      title: "Usuários",
      // tabs
      users_tab: true,
      groups_tab: false,
      departments_tab: false,
      //search
      searched_user: null,
      searched_group: null,
      searched_department: null,
    };
  },
  methods: {
    /*--------*/
    /** @read */
    /*--------*/
    /*----------*/
    /** @create */
    /*----------*/
    /*----------*/
    /** @update */
    /*----------*/
    /*----------*/
    /** @delete */
    /*----------*/
    /*-------*/
    /** @get */
    /*-------*/
    /*--------*/
    /** @post */
    /*--------*/
    /*----------*/
    /** @others */
    /*----------*/
    activeTab($tab) {
      switch ($tab) {
        case "users":
          if (!this.users_tab) {
            this.title = "Usuários";
            this.users_tab = true;
            this.departments_tab = false;
            this.groups_tab = false;
          }
          break;
        case "departments":
          if (!this.departments_tab) {
            this.title = "Departamentos";
            this.users_tab = false;
            this.departments_tab = true;
            this.groups_tab = false;
          }
          break;
        case "groups":
          if (!this.groups_tab) {
            this.title = "Grupos";
            this.users_tab = false;
            this.departments_tab = false;
            this.groups_tab = true;
          }
          break;
      }
    },
    searchUser(name) {
      this.searched_user = name;
    },
    searchGroup(name) {
      this.searched_group = name;
    },
    searchDepartment(name) {
      this.searched_department = name;
    },
  },
};
</script>