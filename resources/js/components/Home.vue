<template>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-home" /> Home
        <small>| Página Inicial</small>
      </h1>
      <ol class="breadcrumb">
        <li class="active">
          <a href="#"><i class="fa fa-home"></i> Home</a>
        </li>
      </ol>
    </section>

    <!-- Main content -->
    <!--<section class="content container-fluid">-->
    <section class="content">
      <!-- Info boxes -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <router-link to="/appointments">
            <!-- small box -->
            <div class="small-box bg-blue">
              <div class="inner">
                <h3>Atendimentos</h3>
                <p>Gerencie os atendimentos cadastrados no sistema.</p>
              </div>
              <div class="icon">
                <i class="fa fa-clipboard"></i>
              </div>
              <a href="#" class="small-box-footer">&nbsp;</a>
            </div>
          </router-link>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <router-link to="/patients">
            <!-- small box -->
            <div class="small-box bg-blue">
              <div class="inner">
                <h3>Pacientes</h3>
                <p>Gerencie os pacientes cadastrados no sistema.</p>
              </div>
              <div class="icon">
                <i class="fa fa-venus-mars"></i>
              </div>
              <a href="#" class="small-box-footer">&nbsp;</a>
            </div>
          </router-link>
        </div>
        <!-- ./col -->
        <template v-if="user.group === 2">
          <div class="col-lg-3 col-xs-6">
            <router-link to="/reports">
              <!-- small box -->
              <div class="small-box bg-blue">
                <div class="inner">
                  <h3>Relatórios</h3>
                  <p>Gerencie os relatórios dos atendimentos cadastrados.</p>
                </div>
                <div class="icon">
                  <i class="fa fa-file-text"></i>
                </div>
                <a href="#" class="small-box-footer">&nbsp;</a>
              </div>
            </router-link>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-xs-6">
            <router-link to="/settings">
              <!-- small box -->
              <div class="small-box bg-blue">
                <div class="inner">
                  <h3>Configurações</h3>
                  <p>Gerencie os usuários, grupos e departamentos do sistema.</p>
                </div>
                <div class="icon">
                  <i class="fa fa-cogs"></i>
                </div>
                <a href="#" class="small-box-footer">&nbsp;</a>
              </div>
            </router-link>
          </div>
        </template>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6" style="cursor: pointer" @click="logout">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>Logout</h3>
              <p>Sair do sistema.</p>
            </div>
            <div class="icon">
              <i class="fa fa-sign-out"></i>
            </div>
            <a href="#" class="small-box-footer">&nbsp;</a>
          </div>
        </div>
        <!-- ./col -->
      </div>

      <!-- /.col -->

      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
</template>
<script>
export default {
  data() {
    return {
      user: "",
    }
  },
  created() {
    this.user = JSON.parse(localStorage.getItem('user'));
  },
  methods: {
    logout() {
      this.$loading(true);
      localStorage.clear();
      setTimeout(() => {
        this.$loading(false);
        this.$router.push("/login");
      }, 1000);
    },
    chatAPI() {
      /* begin loading spinner*/
      this.$loading(true);
      /* api */
      const instance = "289744";
      const token = "k3c6af2ydi4dxwmo";
      const api = `https://api.chat-api.com/instance${instance}/sendMessage?token=${token}`;
      /* request */
      this.$axios
        .post(api, {
          phone: "5592993138892",
          body: 'Ai você fala o seguinte: "- Mas vocês acabaram isso?" Vou te falar: -"Não, está em andamento!" Tem obras que "vai" durar pra depois de 2010. Agora, por isso, nós já não desenhamos, não começamos a fazer projeto do que nós "podêmo fazê"? 11, 12, 13, 14... Por que é que não?',
        })
        .then(({ data }) => {
          alert(JSON.stringify(data));
          this.$loading(false);
        })
        .catch((e) => {
          if (e.response.data) {
            alert(e.response.data.message);
          } else {
            alert(
              `Ocorreu um problema durante a execução! Tente novamente. Caso o problema persista, reporte o erro ao administrador do sistema. Código de erro: ( ${e} ).`
            );
          }
          /* stop loading spinner */
          this.$loading(false);
        });
    },
  },
};
</script>
<style scoped>
.bg-blue {
  background-color: #3c8dbc !important;
}
</style>