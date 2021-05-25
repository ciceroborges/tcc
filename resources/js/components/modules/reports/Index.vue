<template>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-file-text"></i> Relatórios
        <small>Gerenciar relatórios dos atendimentos cadastrados</small>
      </h1>
      <ol class="breadcrumb">
        <li>
          <a href="#"><i class="fa fa-dashboard"></i> Home</a>
        </li>
        <li><a href="#">Relatórios</a></li>
      </ol>
    </section>
    <section class="invoice">
      <div class="no-print">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">
              Utilize os filtros abaixo para gerar o relatório:
            </h3>
          </div>
          <div class="box-body">
            <div class="row">
              <form @submit.prevent="index">
                <div class="col-md-4 col-sm-12">
                  <label>Paciente: </label>
                  <input
                    type="text"
                    class="form-control"
                    placeholder=".col-xs-3"
                  />
                </div>
                <div class="col-md-2 col-sm-12">
                  <label>Departamento: </label>
                  <input
                    type="text"
                    class="form-control"
                    placeholder=".col-xs-4"
                  />
                </div>
                <div class="col-md-2 col-sm-12">
                  <label>Status: </label>
                  <input
                    type="text"
                    class="form-control"
                    placeholder=".col-xs-5"
                  />
                </div>
                <div class="col-md-2 col-sm-12">
                  <label>Data inicial: </label>
                  <input
                    type="text"
                    class="form-control"
                    placeholder=".col-xs-5"
                  />
                </div>
                <div class="col-md-2 col-sm-12">
                  <label>Data final: </label>
                  <input
                    type="text"
                    class="form-control"
                    placeholder=".col-xs-5"
                  />
                </div>
                <div class="col-md-2 col-sm-12">
                  <br />
                  <button class="btn btn-primary">
                    <i class="fa fa-print" /> GERAR RELATÓRIO
                  </button>
                </div>
              </form>
            </div>
          </div>
          <!-- /.box-body -->
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="invoice">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-file-text"></i> Relatório de Atendimentos
            <small class="pull-right">{{
              `Emitido em: ${$moment.now()}.`
            }}</small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-3 invoice-col">
          <address>
            <strong>TCC, Clinic.</strong><br />
            Rua Aldino Loureiro, 9999, Centro<br />
            Carazinho-RS, 99300-00<br />
            Telefone: (54) 3311-5432<br />
            Email: info@tcclinic.com
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-6 invoice-col"></div>
        <!-- /.col -->
        <div class="col-sm-3 invoice-col">
          <b>Relatório:</b> #007612<br />
          <b>Data:</b> 20/10/2021 até 20/10/2021<br />
          <b>Paciente:</b> 2/22/2014<br />
          <b>Departamento:</b> 968-34567<br />
          <b>Status:</b> 968-34567
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>#ID</th>
                <th>Paciente</th>
                <th>CPF</th>
                <th>Contato</th>
                <th>Departamento</th>
                <th>Anamnese</th>
                <th>Status</th>
                <th>Data de inicio</th>
                <th>Data final</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>Call of Duty</td>
                <td>455-981-221</td>
                <td>El snort testosterone trophy driving gloves handsome</td>
                <td>$64.50</td>
                <td>Need for Speed IV</td>
                <td>247-925-726</td>
                <td>Wes Anderson umami biodiesel</td>
                <td>$50.00</td>
              </tr>
              <tr>
                <td>1</td>
                <td>Need for Speed IV</td>
                <td>247-925-726</td>
                <td>Wes Anderson umami biodiesel</td>
                <td>$50.00</td>
                <td>Need for Speed IV</td>
                <td>247-925-726</td>
                <td>Wes Anderson umami biodiesel</td>
                <td>$50.00</td>
              </tr>
              <tr>
                <td>1</td>
                <td>Monsters DVD</td>
                <td>735-845-642</td>
                <td>Terry Richardson helvetica tousled street art master</td>
                <td>$10.70</td>
                <td>Need for Speed IV</td>
                <td>247-925-726</td>
                <td>Wes Anderson umami biodiesel</td>
                <td>$50.00</td>
              </tr>
              <tr>
                <td>1</td>
                <td>Grown Ups Blue Ray</td>
                <td>422-568-642</td>
                <td>Tousled lomo letterpress</td>
                <td>$25.99</td>
                <td>Need for Speed IV</td>
                <td>247-925-726</td>
                <td>Wes Anderson umami biodiesel</td>
                <td>$50.00</td>
              </tr>
              <tr>
                <td>1</td>
                <td>Grown Ups Blue Ray</td>
                <td>422-568-642</td>
                <td>Tousled lomo letterpress</td>
                <td>$25.99</td>
                <td>Need for Speed IV</td>
                <td>247-925-726</td>
                <td>Wes Anderson umami biodiesel</td>
                <td>$50.00</td>
              </tr>
              <tr>
                <td>1</td>
                <td>Grown Ups Blue Ray</td>
                <td>422-568-642</td>
                <td>Tousled lomo letterpress</td>
                <td>$25.99</td>
                <td>Need for Speed IV</td>
                <td>247-925-726</td>
                <td>Wes Anderson umami biodiesel</td>
                <td>$50.00</td>
              </tr>
              <tr>
                <td>1</td>
                <td>Grown Ups Blue Ray</td>
                <td>422-568-642</td>
                <td>Tousled lomo letterpress</td>
                <td>$25.99</td>
                <td>Need for Speed IV</td>
                <td>247-925-726</td>
                <td>Wes Anderson umami biodiesel</td>
                <td>$50.00</td>
              </tr>
              <tr>
                <td>1</td>
                <td>Grown Ups Blue Ray</td>
                <td>422-568-642</td>
                <td>Tousled lomo letterpress</td>
                <td>$25.99</td>
                <td>Need for Speed IV</td>
                <td>247-925-726</td>
                <td>Wes Anderson umami biodiesel</td>
                <td>$50.00</td>
              </tr>
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
    <div class="clearfix"></div>
  </div>
</template>
<script>
export default {
  name: "Reports",
  data() {
    return {
      appointments: [],
      filter: {
        patient: null,
        department: null,
        status: null,
        initial_date: null,
        end_date: null,
      },
    };
  },
  created() {
    //console.log(this.$user);
  },
  methods: {
    index() {
      this.$loading(true);
      if (
        this.filter.patient ||
        this.filter.department ||
        this.filter.status ||
        (this.filter.initial_date && this.filter.end_date)
      ) {
        if (this.filter.initial_date || this.filter.end_date) {
          alert(
            "Para filtrar por data, selecione a data inicial e a data final."
          );
          this.$loading(false);
          return;
        }

        this.appointments = [];
        /* api */
        const api = `${this.$urlAPI}report/index`;
        /* request */
        this.$axios
          .get(api, {
            params: {
              patient: this.filter.patient,
              department: this.filter.department,
              status: this.filter.status,
              initial_date: this.filter.initial_date,
              end_date: this.filter.end_date,
            },
          })
          .then(({ data }) => {
            if (data.appointments.length) {
              this.appointments.push(...data.patients);
              $state.complete();
              this.$loading(false);
            } else {
              alert(
                "Nenhum resultado encontrado. Mude os filtros e tente novamente."
              );
              $state.complete();
              this.$loading(false);
            }
          })
          .catch((e) => {
            console.log(e.response.data.message);
            this.$loading(false);
          });
      } else {
        if (this.filter.initial_date || this.filter.end_date) {
          alert(
            "Para filtrar por data, selecione a data inicial e a data final."
          );
          this.$loading(false);
        } else {
          alert(
            "Para gerar o relatório, utilize pelo menos 1 dos filtros disponíveis."
          );
          this.$loading(false);
        }
      }
    },
  },
};
</script>
