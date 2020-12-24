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
                    <input type="text" class="form-control" v-model.trim="account" required/>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group bmd-form-group">
                    <label class="bmd-label-floating">Senha</label>
                    <input type="password" class="form-control" v-model.trim="password" required/>
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
      account: "",
      password: "",
    };
  },
  methods: {
    login() {
      if (this.account && this.password) {
        this.$axios
          .post(this.$urlAPI + `user/login`, {
            account: this.account,
            password: this.password,
          })
          .then((response) => {
            if(response.data.status === 'Success!') {
              localStorage.setItem('user', JSON.stringify(response.data.user));
              this.$router.push('/home');
              console.log($user);
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