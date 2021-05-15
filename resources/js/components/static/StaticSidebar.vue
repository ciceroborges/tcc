<template>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
          <img
            src="dist/img/user2-160x160.jpg"
            class="img-circle"
            alt="User Image"
          />
        </div>
        <div class="pull-left info">
          <p>{{ $user.name }}</p>
          <!-- Status -->
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <!-- search form (Optional)
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input
            type="text"
            name="q"
            class="form-control"
            placeholder="Search..."
          />
          <span class="input-group-btn">
            <button
              type="submit"
              name="search"
              id="search-btn"
              class="btn btn-flat"
            >
              <i class="fa fa-search"></i>
            </button>
          </span>
        </div>
      </form>
       /.search form -->

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu" data-widget="tree">
        <!-- Optionally, you can add icons to the links -->
        <template v-for="(row, index) in link">
          <li
            :key="index"
            :class="!row.separator ? { active: row.active } : 'header'"
            @click="setActiveModule(row.name)"
          >
            <template v-if="!row.separator">
              <a href="#"
                ><i :class="`fa ${row.icon}`"></i>
                <span>{{ row.title }}</span>
              </a>
            </template>
            <template v-else>
              {{ row.title }}
            </template>
          </li>
        </template>
        <!--
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
        -->
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
      active_link: "",
      link: {
        begin: {
          name: 'begin',
          title: "INÍCIO",
          separator: true,
        },
        home: {
          name: "home",
          title: "Home",
          route: "home",
          icon: "fa-home",
          active: false,
        },
        modules: {
          name: 'modules',
          title: "MÓDULOS",
          separator: true,
        },
        /*
        calendar: {
          name: "calendar",
          title: "Calendário",
          route: "calendar",
          icon: "fa-calendar",
          active: false,
        },
        */
        appointments: {
          name: "appointments",
          title: "Atendimentos",
          route: "appointments",
          icon: "fa-bars",
          active: false,
        },
        patients: {
          name: "patients",
          title: "Pacientes",
          route: "patients",
          icon: "fa-venus-mars",
          active: false,
        },
        /*
        inventory: {
          name: "inventory",
          title: "Estoque",
          route: "inventory",
          icon: "fa-cubes",
          active: false,
        },
        invoices: {
          name: "invoices",
          title: "Faturas",
          route: "invoices",
          icon: "fa-money",
          active: false,
        },
        */
        reports: {
          name: "reports",
          title: "Relatórios",
          route: "reports",
          icon: "fa-file-text",
          active: false,
        },
        others: {
          name: 'others',
          title: "OUTROS",
          separator: true,
        },
        settings: {
          name: "settings",
          title: "Configurações",
          route: "settings",
          icon: "fa-cogs",
          active: false,
        },
        logout: {
          name: "logout",
          title: "Logout",
          route: "#",
          icon: "fa-sign-out",
          active: false,
        },
      },
    };
  },
  created() {
    this.active_link = this.$route.name;
    this.link[this.$route.name].active = true;
  },
  methods: {
    setActiveModule(name) {
      if(name === 'logout') {
        this.logout();
      } else if(this.active_link !== name && (name !== 'modules' && name !== 'others')) {
        this.$loading(true);
        this.link[this.active_link].active = false;
        this.active_link = name;
        this.link[this.active_link].active = true;
        this.$router.push(name);
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