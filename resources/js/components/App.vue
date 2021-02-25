<template>
  <!-- div pai -->
  <div>
    <!-- sidebar do sistema -->
    <static-sidebar v-if="sidebar" />
    <!-- div main -->
    <div id="main" class="main-panel">
      <!-- navbar do sistema -->
      <static-navbar v-if="navbar" />
      <!-- componente principal -->
      <static-content />
      <!-- footer do sistema -->
      <static-footer v-if="footer" />
    </div>
  </div>
</template>
<script>
// componentes importados
import StaticSidebar from "./static/StaticSidebar";
import StaticNavbar from "./static/StaticNavbar";
import StaticContent from "./static/StaticContent";
import StaticFooter from "./static/StaticFooter";

export default {
  name: "App",
  components: {
    StaticSidebar,
    StaticNavbar,
    StaticContent,
    StaticFooter,
  },
  data() {
    return {
      //routes: ["login", "register"],
      sidebar: true,
      navbar: true,
      footer: true,
    };
  },
  created() {
    this.verifyNavigation();
  },
  mounted() {
    this.verifyClass();
  },
  methods: {
    setNavbarBrand(){
      
    },
    verifyNavigation() {
      if (this.$route.name === "login" || this.$route.name === "register") {
        this.sidebar = false;
        this.navbar = false;
        this.footer = false;
      } else if (
        this.$route.name !== "login" &&
        this.$route.name !== "register"
      ) {
        this.sidebar = true;
        this.navbar = true;
        this.footer = true;
      }
      /*
      this.routes.forEach((route) => {
        if (this.$route.name === route) {
          this.sidebar = false;
          this.navbar = false;
          this.footer = false;
        } 
      });
      */
    },
    verifyClass() {
      if (this.$route.name === "login" || this.$route.name === "register") {
        this.handleClass("main", "remove", "main-panel");
      } else if (
        this.$route.name !== "login" &&
        this.$route.name !== "register"
      ) {
        this.handleClass("main", "add", "main-panel");
      }
    },
    handleClass(id, action, Class) {
      switch (action) {
        case "add":
          document.getElementById(id).classList.add(Class);
          break;
        case "remove":
          document.getElementById(id).classList.remove(Class);
          break;
        case "contains":
          document.getElementById(id).classList.contains(Class);
          break;
      }
    },
  },
  watch: {
    $route: function (to, from) {
      this.verifyNavigation();
      this.verifyClass();
      /*
      this.routes.forEach((route) => {
        this.verifyNavigation();
      });
      */
    },
  },
};
</script>