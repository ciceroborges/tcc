<template>
  <div class="container-fluid">
    <div class="row d-flex justify-content-center">
      <div class="col-lg-3 col-md-6 col-sm-12 mt-5">
        <div class="card">
          <div class="card-header card-header-danger">
            <h4 class="card-title">REGISTRO</h4>
            <p class="card-category">Informe os seus dados:</p>
          </div>
          <div class="card-body">
            <form @submit.prevent="register">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group bmd-form-group">
                    <label class="bmd-label-floating">Nome</label>
                    <input
                      type="text"
                      class="form-control"
                      v-model.trim="name"
                      required
                    />
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group bmd-form-group">
                    <label class="bmd-label-floating">E-mail</label>
                    <input
                      type="email"
                      class="form-control"
                      v-model.trim="email"
                      required
                    />
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group bmd-form-group">
                    <label class="bmd-label-floating">Senha</label>
                    <input
                      type="password"
                      class="form-control"
                      v-model.trim="password"
                      required
                    />
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group bmd-form-group">
                    <label class="bmd-label-floating">Confirme a senha</label>
                    <input
                      type="password"
                      class="form-control"
                      v-model.trim="confirm_password"
                      required
                    />
                  </div>
                </div>
              </div>
              <button type="submit" class="btn btn-danger pull-right">
                Entrar
              </button>
              <div class="clearfix"></div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
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
  mounted() {
    this.removeClass("main", "main-panel");
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
    removeClass(id, Class) {
      document.getElementById(id).classList.remove(Class);
    },
  },
};
</script>