<template>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>Alexander Pierce</p>
          <!-- Status -->
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <!-- search form (Optional) -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
        </div>
      </form>
      <!-- /.search form -->

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">HEADER</li>
        <!-- Optionally, you can add icons to the links -->
        <li class="active"><a href="#"><i class="fa fa-link"></i> <span>Link</span></a></li>
        <li><a href="#"><i class="fa fa-link"></i> <span>Another Link</span></a></li>
        <li class="treeview">
          <a href="#"><i class="fa fa-link"></i> <span>Multilevel</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#">Link in level 2</a></li>
            <li><a href="#">Link in level 2</a></li>
          </ul>
        </li>
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>
</template>
<script>
export default {
  data() {
    return {
      active_module: "",
      modules: {
        home: {
          name: "home",
          title: "Início",
          route: "home",
          icon: "dashboard",
          active: false,
        },
        appointments: {
          name: "appointments",
          title: "Atendimentos",
          route: "appointments",
          icon: "assignment",
          active: false,
        },
        calendar: {
          name: "calendar",
          title: "Calendário",
          route: "calendar",
          icon: "date_range",
          active: false,
        },
        departments: {
          name: "departments",
          title: "Departamentos",
          route: "departments",
          icon: "workspaces",
          active: false,
        },
        patients: {
          name: "patients",
          title: "Pacientes",
          route: "patients",
          icon: "accessible",
          active: false,
        },
        users: {
          name: "users",
          title: "Usuários",
          route: "users",
          icon: "groups",
          active: false,
        },
      },
    };
  },
  created() {
    //this.active_module = this.$route.name;
    //this.modules[this.$route.name].active = true;
  },
  methods: {
    setActiveModule(name) {
      if (this.active_module !== name) {
        this.$loading(true);
        this.modules[this.active_module].active = false;
        this.active_module = name;
        this.modules[name].active = true;
        
        setTimeout(() => {
          this.$loading(false);
        }, 1000);
      }
    },
    logout() {
      this.$loading(true);
      localStorage.clear();
      setTimeout(() => {
        this.$loading(false);
        this.$router.push("/login");
      }, 1000);
    },
  },
};
</script>