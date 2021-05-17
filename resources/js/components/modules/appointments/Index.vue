<template>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- list table -->
    <list
      :appointments="appointments"
      :count="count"
      :index="index"
      :edit="edit"
      ref="AppointmentList"
    />
    <!-- search aside -->
    <search @search="search($event)" />
    <!-- This div must be placed immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
    <!-- edit modal -->
    <edit :target="target" :store="store" :update="update" :destroy="destroy" />
  </div>
  <!-- /.content-wrapper -->
</template>
<script>
// componentes importados
import Edit from "../appointments/Edit.vue";
import List from "../appointments/List.vue";
import Search from "../appointments/Search.vue";

export default {
  name: "Appointments",
  components: {
    Edit,
    List,
    Search,
  },
  data() {
    return {
      //general
      appointments: [],
      //edit
      target: {},
      //search
      filter: null,
      //searched_patient: null,
      //infinite loading
      skip: 0,
      take: 30,
      //count
      count: 0,
    };
  },
  created() {
    //console.log(this.$user);
  },
  methods: {
    /*--------*/
    /** @read */
    /*--------*/
    index($state) {
      /* api */
      const api = `${this.$urlAPI}appointment/index`;
      /* request */
      this.$axios
        .get(api, {
          params: {
            //filter: this.searched_patient,
            skip: this.skip,
            take: this.take,
          },
        })
        .then(({ data }) => {
          if (data.appointments.length) {
            this.skip = data.skip;
            this.count = this.appointments.length + data.appointments.length;
            this.appointments.push(...data.appointments);

            if (data.appointments.length === this.take) {
              $state.loaded();
            } else {
              $state.complete();
            }
          } else {
            $state.complete();
          }
        })
        .catch((e) => {
          console.log(e.response.data.message);
        });
    },
    /*----------*/
    /** @create */
    /*----------*/
    store($target) {
      /* begin loading spinner*/
      this.$loading(true);
      /* close edit modal */
      $("#edit-appointment").modal("hide");
      /* api */
      const api = `${this.$urlAPI}appointment/store`;
      /* request */
      this.$axios
        .post(api, {
          department_id: $target.department_id,
          patient_id: $target.patient_id,
          anamnesis: $target.anamnesis,
          status: $target.status,
          start_date: $target.start_date,
          end_date: $target.end_date,
        })
        .then(({ data }) => {
          if (data.status) {
            //this.patients.push(data.patient);
            this.reset();
            alert(data.message);
          } else {
            alert(data.message);
            $("#edit-appointment").modal("show");
          }
          /* stop loading spinner */
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
    /*----------*/
    /** @update */
    /*----------*/
    update($target) {
      /* begin loading spinner*/
      this.$loading(true);
      /* close edit modal */
      $("#edit-appointment").modal("hide");
      /* api */
      const api = `${this.$urlAPI}appointment/update`;
      /* request */
      this.$axios
        .put(api, {
          id: $target.id,
          department_id: $target.department_id,
          patient_id: $target.patient_id,
          anamnesis: $target.anamnesis,
          status: $target.status,
          start_date: $target.start_date,
          end_date: $target.end_date,
        })
        .then(({ data }) => {
          if (data.status) {
            let index = this.patients.findIndex(
              (item) => item.id === data.patient.id
            );
            if (index !== -1) {
              this.appointments[index].department_id = data.appointment.department_id;
              this.appointments[index].patient_id = data.appointment.patient_id;
              this.appointments[index].anamnesis = data.appointment.anamnesis;
              this.appointments[index].status = data.appointment.status;
              this.appointments[index].start_date = data.appointment.start_date;
              this.appointments[index].end_date = data.appointment.end_date;
            }
            alert(data.message);
          } else {
            alert(data.message);
            $("#edit-appointment").modal("show");
          }
          /* stop loading spinner */
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
    /*----------*/
    /** @delete */
    /*----------*/
    destroy($target) {
      let $confirm = confirm(
        `Você tem certeza? O atendimento ${$target.id} será excluído. Está ação não poderá ser desfeita.`
      );
      if ($confirm) {
        /* begin loading spinner*/
        this.$loading(true);
        /* close edit modal */
        $("#edit-appointment").modal("hide");
        /* api */
        const api = `${this.$urlAPI}appointment/destroy`;
        /* request */
        this.$axios
          .delete(api, {
            params: {
              id: $target.id,
            },
          })
          .then(({ data }) => {
            if (data.status) {
              this.reset();
              /*
              let index = this.users.findIndex(
                (item) => item.id === data.patient.id
              );
              if (index !== -1) {
                this.users.splice(index, 1);
                if (this.count > 0) {
                  this.count--;
                }
              }
              */
              alert(data.message);
            } else {
              alert(data.message);
              $("#edit-appointment").modal("hide");
            }
            /* stop loading spinner */
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
      }
    },
    /*-------*/
    /** @get */
    /*-------*/

    /*--------*/
    /** @post */
    /*--------*/

    /*----------*/
    /** @others */
    /*----------*/
    edit($id) {
      // start loading spinner
      this.$loading(true);
      this.target = {};

      if ($id === 0) {
        this.target.id = null;
        this.target.department_id = null;
        this.target.patient_id = null;
        this.target.anamnesis = null;
        this.target.status = null;
        this.target.start_date = null;
        this.target.end_date = null;
        this.target.new_record = true;
        // show edit modal
        $("#edit-appointment").modal("show");
        // stop loading spinner
        this.$loading(false);
      } else {
        /* api */
        const api = `${this.$urlAPI}appointment/find`;
        /* request */
        this.$axios
          .get(api, {
            params: {
              id: $id,
            },
          })
          .then(({ data }) => {
            // get target data
            this.target = data.appointment;
            // show edit modal
            $("#edit-appointment").modal("show");
            // stop loading spinner
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
            // stop loading spinner
            this.$loading(false);
          });
      }
    },
    search($e) {
      this.searched_patient = $e;
    },
    reset() {
      this.filter = this.searched_patient;
      this.appointments = [];
      this.skip = 0;
      this.count = 0;
      this.$refs.AppointmentList.$refs.infiniteAppointmentsTable.stateChanger.reset();
    }
  },
  watch: {
    searched_patient() {
      this.reset();
    },
  },
};
</script>
