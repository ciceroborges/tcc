<template>
  <div>
      <!-- header do sistema -->
      <static-header v-if="header"/>
      <!-- sidebar do sistema -->
      <static-sidebar v-if="sidebar"/>
      <!-- content do sistema -->
      <static-content />
      <!-- footer do sistema -->
      <static-footer v-if="footer"/>
  </div>
</template>
<script>
// componentes importados
import StaticContent from "./static/StaticContent.vue";
import StaticFooter from "./static/StaticFooter.vue";
import StaticHeader from "./static/StaticHeader";
import StaticSidebar from "./static/StaticSidebar.vue";

export default {
  name: "App",
  components: {
    StaticHeader,
    StaticSidebar,
    StaticContent,
    StaticFooter,
  },
  data() {
    return {
      /* navigation */
      header:  true,
      sidebar: true,
      footer:  true,
    };
  },
  created() {
    this.verifyNavigation();
  },
  mounted() {
    this.verifyClass();
  },
  methods: {
    verifyNavigation() {
      if (this.$route.name === "login" || this.$route.name === "register") {
        this.header  = false,
        this.sidebar = false;
        this.footer  = false;
      } else if (this.$route.name !== "login" && this.$route.name !== "register") {
        this.header  = true,
        this.sidebar = true;
        this.footer  = true;
      }
    },
     verifyClass() {
      if (this.$route.name === "login" || this.$route.name === "register") {
        $(`#body`).addClass("login-page");
        $(`#body`).removeClass("skin-blue sidebar-mini");
      } else if (this.$route.name !== "login" && this.$route.name !== "register") {
        $(`#body`).addClass("skin-blue sidebar-mini");
        $(`#body`).removeClass("login-page");
      }
    },
  },
  watch: {
    $route: function (to, from) {
      this.verifyNavigation();
      this.verifyClass();
    },
  },
};
</script>