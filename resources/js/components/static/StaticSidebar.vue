<template>
  <div class="sidebar" data-color="azure" data-background-color="black" >
    <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

        Tip 2: you can also add an image using data-image tag data-image="/img/sidebar-11.jpg"
    -->
    <div class="logo">
      <router-link to="/" class="simple-text logo-normal">
        <img width="250" src="/img/logo-xl.png"/>
      </router-link>
    </div>
    <div class="sidebar-wrapper">
      <ul class="nav">
        <template>
          <li
            v-for="(item, index) in modules"
            :key="index"
            class="nav-item"
            :class="{ active: item.active }"
            @click="setActiveModule(item.name)"
          >
            <router-link class="nav-link" :to="item.route">
              <i class="material-icons">{{ item.icon }}</i>
              <p>{{ item.title }}</p>
            </router-link>
          </li>
        </template>
        <li class="nav-item active-pro">
          <a class="nav-link" href="#" @click.prevent="logout()">
            <i class="material-icons">exit_to_app</i>
            <p>SAIR</p>
          </a>
        </li>
      </ul>
    </div>
  </div>
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
    this.active_module = this.$route.name;
    this.modules[this.$route.name].active = true;
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