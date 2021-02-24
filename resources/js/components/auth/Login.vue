<template>
  <div class="container-fluid">
    <div class="row d-flex justify-content-center">
      <div class="col-lg-3 col-md-6 col-sm-12 mt-5">
        <div class="card">
          <div class="card-header card-header-info">
            <h4 class="card-title">LOGIN</h4>
            <p class="card-category">Informe os seus dados:</p>
          </div>
          <div class="card-body">
            <form @submit.prevent="login">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group bmd-form-group">
                    <label class="bmd-label-floating">E-mail</label>
                    <input
                      type="text"
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
              </div>
              <button type="submit" class="btn btn-info pull-right">
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
      user: "",
      email: "",
      password: "",
    };
  },
  created(){
  },
  methods: {
    login() {
      this.$loading(true);
      if (this.email && this.password) {
        const api = `${this.$urlAPI}user/login`; 
        this.$axios
          .post(api, {
            email: this.email,
            password: this.password,
          })
          .then(({data}) => {
            if (data.status) {
              localStorage.setItem("user", JSON.stringify(data.user));
              document.cookie = `app_session=${JSON.parse(localStorage.getItem('user')).id}`;
              setTimeout(() => {
                this.$loading(false);
                this.$router.push("/home");
              }, 1000);
            }
          })
          .catch((e) => {
            console.log(e);
          });
      } else {
        console.log("erro");
      }
    },
  },
};
</script>
<style scoped>
</style>