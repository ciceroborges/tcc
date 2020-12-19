<template>
  <!-- div pai -->
  <div>
    <!-- sidebar do sistema -->
    <app-sidebar />
    <div class="main-panel">
      <!-- navbar do sistema -->
      <app-navbar  />
      <!-- componente principal -->
      <app-content />
      <!-- footer do sistema -->
      <app-footer />
    </div>
  </div>
</template>
<script>
// componentes importados
import AppSidebar from "./static/AppSidebar";
import AppNavbar from "./static/AppNavbar";
import AppContent from "./static/AppContent";
import AppFooter from "./static/AppFooter";

export default {
  name: "App",
  components: {
    AppSidebar,
    AppNavbar,
    AppContent,
    AppFooter,
  },
  data() {
    return {
      routes: [],
      header: true,
      footer: true,
    };
  },
  created() {
    this.verifyNavigation();
  },
  methods: {
    verifyNavigation() {
      this.routes.forEach((route) => {
        if (this.$route.name === route) {
          this.header = false;
          this.footer = false;
        }
      });
    },
  },
  watch: {
    $route: function (to, from) {
      this.routes.forEach((route) => {
        if (this.$route.name === route) {
          this.header = false;
          this.footer = false;
        }
      });
    },
  },
};
</script>