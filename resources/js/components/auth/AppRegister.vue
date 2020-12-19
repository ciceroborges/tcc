<template>
  <div>
    <h3>REGISTER</h3>
    <input
      class="form-control"
      placeholder="Name:"
      type="text"
      required="required"
      v-model="name"
    />
    <br />
    <input
      class="form-control"
      placeholder="E-mail:"
      type="email"
      required="required"
      v-model="email"
    />
    <br />
    <input
      class="form-control"
      placeholder="Password:"
      type="password"
      required="required"
      v-model="password"
    />
    <br />
    <input
      class="form-control"
      placeholder="Confirm your Password:"
      type="password"
      required="required"
      v-model="confirm_password"
    />
    <br />
    <button class="btn btn-primary" @click="register">Entrar</button>
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