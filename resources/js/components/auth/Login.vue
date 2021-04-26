<template>
  <div class="login-box">
    <div class="login-logo">
      <a href="#"><b><i class="fa fa-heartbeat"/> TCC</b>LINIC</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
      <p class="login-box-msg">Faça login para continuar.</p>

      <form @submit.prevent="login">
        <div class="form-group has-feedback">
          <input
            type="email"
            class="form-control"
            required
            placeholder="E-mail"
            v-model="email"
          />
          <span
            class="glyphicon glyphicon-envelope form-control-feedback"
          ></span>
        </div>
        <div class="form-group has-feedback">
          <input
            type="password"
            class="form-control"
            required
            placeholder="Senha"
            v-model="password"
          />
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
          <!-- /.col -->
          <div class="col-xs-12">
            <button type="submit" class="btn btn-success btn-block btn-flat">
              Login
            </button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <div class="social-auth-links">
        <router-link to="register" class="text-center"
          >Deseja solicitar acesso?</router-link
        >
        <br />
        <router-link to="#" class="text-center"
          >Esqueceu sua senha?</router-link
        >
      </div>
    </div>
    <!-- /.login-box-body -->
  </div>
  <!-- /.login-box -->
</template>
<script>
export default {
  data() {
    return {
      user: "",
      email: "",
      password: "",
    };
  },
  created() {},
  methods: {
    login() {
      // start loading spinner
      this.$loading(true);
      // api
      const api = `${this.$urlAPI}user/login`;
      // request
      this.$axios
        .post(api, {
          email: this.email,
          password: this.password,
        })
        .then(({ data }) => {
          if (data.status) {
            // save the logged user on localStorage
            localStorage.setItem("user", JSON.stringify(data.user));
            // create session cookie
            document.cookie = `app_session=${
              JSON.parse(localStorage.getItem("user")).token
            }`;
            setTimeout(() => {
              this.$router.push("/home");
              // stop loading spinner
              this.$loading(false);
            }, 1000);
          }
        })
        .catch((e) => {
          alert(e.response.data.message);
          // stop loading spinner
          this.$loading(false);
        });
    },
  },
};
</script>
