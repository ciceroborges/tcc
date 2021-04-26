<template>
  <div class="login-box">
    <div class="login-logo">
      <a href="#"><b><i class="fa fa-heartbeat"/> TCC</b>LINIC</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
      <p class="login-box-msg">Solicitação de acesso.</p>
      <form @submit.prevent="register">
        <div class="form-group has-feedback">
          <input
            type="text"
            class="form-control"
            required
            placeholder="Nome Completo"
            v-model.trim="name"
          />
          <span
            class="glyphicon glyphicon-user form-control-feedback"
          ></span>
        </div>
        <div class="form-group has-feedback">
          <input
            type="email"
            class="form-control"
            required
            placeholder="E-mail"
            v-model.trim="email"
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
            v-model.trim="password"
          />
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <input
            type="password"
            class="form-control"
            required
            placeholder="Repita a senha"
            v-model.trim="confirm_password"
          />
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
          <!-- /.col -->
          <div class="col-xs-12">
            <button type="submit" class="btn btn-danger btn-block btn-flat">
              Solicitar
            </button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <div class="social-auth-links">
        <router-link to="login" class="text-center">Já possuí acesso?</router-link>
        <br>
        <router-link to="#" class="text-center">Esqueceu sua senha?</router-link>
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
      name: "",
      email: "",
      password: "",
      confirm_password: "",
    };
  },
  methods: {
    register() {
      this.$axios
        .post(this.$urlAPI + `user/register`, {
          name: this.name,
          email: this.email,
          password: this.password,
          confirm_password: this.confirm_password,
        })
        .then((response) => {
          console.log(response);
        })
        .catch((e) => {
          console.log(e);
        });
    },
  },
};
</script>