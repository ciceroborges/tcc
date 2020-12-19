<template>
  <div class="row parent">
    <div class="col l4 m4 s12"></div>
    <div class="col l4 m4 s12">
      <form action="" method="POST">
        <div class="card-panel z-depth-5">
          <img src="/img/logo-xl.png"/>
          <p class="center">Informe os seus dados:</p>
          <!--
          <div class="input-field">
            <i class="material-icons prefix">account_circle</i>
            <input id="username" type="text" name="username" />
            <label for="username">Enter username</label>
          </div>
          -->
          <div class="input-field">
            <i class="material-icons prefix">email</i>
            <input id="email" type="email" name="email" class="validate"/>
            <label for="email">E-mail</label>
          </div>
          <div class="input-field">
            <i class="material-icons prefix">lock</i>
            <input id="password" type="password" name="password" class="validate"/>
            <label for="password">Senha</label>
          </div>
          <!--
          <div class="input-field">
            <i class="material-icons prefix">vpn_key</i>
            <input id="username" type="text" name="username" />
            <label for="username">Enter username</label>
          </div>
          -->
          <br>
          <input
            type="submit"
            name="submit"
            value="Login"
            class="btn left col s12"
          />
          <p class="right">
            Already have an account?
            <a href="#login" class="modal-trigger">login</a>
          </p>
          <div class="clearfix"></div>
        </div>
      </form>
    </div>
    <div class="col l3 m3 s12"></div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      email: "",
      password: "",
    };
  },
  created() {
    this.removeBodyClass();
  },
  methods: {
    login() {
      if (this.email && this.password) {
        this.$axios
          .post(this.$urlAPI + `user/login`, {
            email: this.email,
            password: this.password,
          })
          .then((response) => {
            console.log(response);
          })
          .catch((e) => {
            console.log(e);
          });
      } else {
        console.log("erro");
      }
    },
    removeBodyClass() {
      let body = document.getElementById("body");
      body.classList.remove("has-fixed-sidenav");
    },
  },
};
</script>
<style scoped>
.parent {
  margin-top: 15%;
}
</style>