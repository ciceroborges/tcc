<template>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-file-text"></i> Relatórios
        <small>| Gerencie os relatórios dos atendimentos cadastrados.</small>
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
                  <multiselect
                    :selectLabel="''"
                    :deselectLabel="''"
                    :selectedLabel="'selecionado'"
                    :openDirection="'bottom'"
                    :hide-selected="false"
                    :close-on-select="true"
                    :multiple="false"
                    :allowEmpty="false"
                    :options="patients"
                    v-model="filter.patient"
                    label="name"
                    track-by="name"
                    placeholder="Selecione..."
                    required
                  >
                  </multiselect>
                </div>
                <div class="col-md-2 col-sm-12">
                  <label>Departamento: </label>
                  <multiselect
                    :selectLabel="''"
                    :deselectLabel="''"
                    :selectedLabel="'selecionado'"
                    :openDirection="'bottom'"
                    :hide-selected="false"
                    :close-on-select="true"
                    :multiple="false"
                    :allowEmpty="false"
                    :options="departments"
                    v-model="filter.department"
                    label="name"
                    track-by="name"
                    placeholder="Selecione..."
                    required
                  >
                  </multiselect>
                </div>
                <div class="col-md-2 col-sm-12">
                  <label>Status: </label>
                  <multiselect
                    :selectLabel="''"
                    :deselectLabel="''"
                    :selectedLabel="'selecionado'"
                    :openDirection="'bottom'"
                    :hide-selected="false"
                    :close-on-select="true"
                    :multiple="false"
                    :allowEmpty="false"
                    :options="status"
                    v-model="filter.status"
                    label="name"
                    track-by="name"
                    placeholder="Selecione..."
                    required
                  >
                  </multiselect>
                </div>
                <div class="col-md-2 col-sm-12">
                  <label>Data inicial: </label>
                  <input
                    pattern="\d{2}\/\d{2}\/\d{4}"
                    title="Digite a data no formato DD/MM/AAAA"
                    type="text"
                    class="form-control"
                    id="exampleInputEmail1"
                    placeholder="Ex: 01/01/2021"
                    v-model="filter.initial_date"
                  />
                </div>
                <div class="col-md-2 col-sm-12">
                  <label>Data final: </label>
                  <input
                    pattern="\d{2}\/\d{2}\/\d{4}"
                    title="Digite a data no formato DD/MM/AAAA"
                    type="text"
                    class="form-control"
                    id="exampleInputEmail1"
                    placeholder="Ex: 01/01/2021"
                    v-model="filter.end_date"
                  />
                </div>
                <div class="col-md-2 col-sm-12">
                  <br />
                  <button class="btn btn-primary" type="submit">
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
    <section class="invoice" v-if="show">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-file-text"></i> Relatório de Atendimentos
            <small class="pull-right">{{ `Emitido em: ${datetime}.` }}</small>
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
          <b>Relatório:</b> #007612
          <br />
          <b>Data:</b> {{ old_filter.date }}
          <br />
          <b>Paciente:</b> {{ old_filter.patient }}
          <br />
          <b>Departamento:</b> {{ old_filter.department }}
          <br />
          <b>Status:</b> {{ old_filter.status }}
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
              <tr v-for="(row, index) in appointments" :key="index">
                <td>{{ row.patient_name }}</td>
                <td>{{ row.patient_cpf }}</td>
                <td>{{ row.patient_phone_number }}</td>
                <td>{{ row.department_name }}</td>
                <td>{{ row.anamnesis }}</td>
                <td>
                  {{
                    row.status === "WAITING"
                      ? "Aguardando"
                      : row.status === "IN PROGRESS"
                      ? "Em progresso"
                      : row.status === "CONCLUDED"
                      ? "Concluído"
                      : "Cancelado"
                  }}
                </td>
                <td>{{ $moment.convert(row.start_date, "DD/MM/YYYY") }}</td>
                <td>
                  {{
                    row.end_date
                      ? $moment.convert(row.end_date, "DD/MM/YYYY")
                      : "Indefenido"
                  }}
                </td>
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
      patients: [],
      departments: [],
      show: false,
      datetime: null,
      filter: {
        patient: null,
        department: null,
        status: null,
        initial_date: null,
        end_date: null,
      },
      old_filter: {
        patient: null,
        department: null,
        status: null,
        date: null,
      },
      status: [
        { name: "Todos", value: "ALL" },
        { name: "Aguardando", value: "WAITING" },
        { name: "Em progresso", value: "IN PROGRESS" },
        { name: "Concluído", value: "CONCLUDED" },
        { name: "Cancelado", value: "CANCELED" },
      ],
    };
  },
  created() {
    this.getPatients();
    this.getDepartments();
  },
  methods: {
    index() {
      this.$loading(true);
      this.show = false;
      if (
        this.filter.patient ||
        this.filter.department ||
        this.filter.status ||
        this.filter.initial_date ||
        this.filter.end_date 
      ) {
        
        this.appointments = [];
        /* api */
        const api = `${this.$urlAPI}report/index`;
        const filters = {
          departments: this.$user.departments
        };

        if (this.filter.patient) {
          filters.patient_id = this.filter.patient.id;
        }
        if (this.filter.department) {
          filters.department_id = this.filter.department.id;
        }
        if (this.filter.status) {
          filters.status = this.filter.status.value;
        }
        if (this.filter.initial_date) {
          filters.initial_date = this.$moment.convertFromFormat(
            this.filter.initial_date,
            "DD/MM/YYYY",
            "YYYY-MM-DD"
          );
        }
        if (this.filter.end_date) {
          filters.end_date = this.$moment.convertFromFormat(
            this.filter.end_date,
            "DD/MM/YYYY",
            "YYYY-MM-DD"
          );
        }
        /* request */
        this.$axios
          .get(api, {
            params: filters,
          })
          .then(({ data }) => {
            if (data.appointments.length) {
              this.appointments = data.appointments;
              this.showTable();
              this.$loading(false);
            } else {
              alert(
                "Nenhum resultado encontrado. Mude os filtros e tente novamente."
              );
              this.$loading(false);
            }
          })
          .catch((e) => {
            console.log(e);
            this.$loading(false);
          });
      } else {
          alert(
            "Para gerar o relatório, utilize pelo menos 1 dos filtros disponíveis."
          );
          this.$loading(false);
      }
    },
    getPatients() {
      /* begin loading spinner*/
      this.$loading(true);
      /* api */
      const api = `${this.$urlAPI}patient/index`;
      /* request */
      this.$axios
        .get(api, {})
        .then(({ data }) => {
          this.patients = data.patients;
          this.patients.unshift({ id: 0, name: "Todos" });
          this.$loading(false);
        })
        .catch((e) => {
          console.log(e.response.data.message);
          this.$loading(false);
        });
    },
    getDepartments() {
      /* begin loading spinner*/
      this.$loading(true);
      /* api */
      const api = `${this.$urlAPI}department/index`;
      /* request */
      this.$axios
        .get(api, {})
        .then(({ data }) => {
          this.departments = data.departments;
          this.departments.unshift({ id: 0, name: "Todos" });
          this.$loading(false);
        })
        .catch((e) => {
          console.log(e.response.data.message);
          this.$loading(false);
        });
    },
    setOldFilters() {
      if (this.filter.initial_date && this.filter.end_date) {
        this.old_filter.date = `De ${this.filter.initial_date} até ${this.filter.end_date}.`;
      } else {
        this.old_filter.date = "Não filtrado";
      }

      if (this.filter.patient) {
        this.old_filter.patient = this.filter.patient.name;
      } else {
        this.old_filter.patient = "Não filtrado";
      }

      if (this.filter.department) {
        this.old_filter.department = this.filter.department.name;
      } else {
        this.old_filter.department = "Não filtrado";
      }

      if (this.filter.status) {
        this.old_filter.status = this.filter.status.name;
      } else {
        this.old_filter.status = "Não filtrado";
      }
    },
    showTable() {
        this.setOldFilters();
        this.datetime = this.$moment.now();
        this.show = true;
    },
    clear() {
      this.appointments = [];
      this.filter.patient = null;
      this.filter.department = null;
      this.filter.status = null;
      this.filter.initial_date = null;
      this.filter.end_date = null;
      this.old_filter.patient = null;
      this.old_filter.department = null;
      this.old_filter.status = null;
      this.old_filter.date = null;
      this.show = false;
    },
  },
};
</script>
