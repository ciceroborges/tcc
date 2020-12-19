<template>
  <!-- div pai -->
  <div>
    <!-- header do sistema -->
    <app-header v-show="header" />
     <!-- componente principal -->
    <app-main />
    <!-- footer do sistema -->
    <app-footer v-show="footer"/>
  </div>
</template>
<script>
// componentes importados
import AppHeader from "./static/AppHeader";
import AppMain from "./static/AppMain";
import AppFooter from "./static/AppFooter";

export default {
  name: "App",
  components: {
    AppHeader,
    AppMain,
    AppFooter,
  },
  data() {
    return {
      routes: ["login", "register"],
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