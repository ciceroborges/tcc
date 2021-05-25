<template>
  <!-- Content Wrapper. Contains page content -->
  <div>
    <!-- list table -->
    <list
      :appointments="appointments"
      :count="count"
      :index="index"
      :edit="edit"
      ref="AppointmentList"
    />
    <!-- edit modal -->
    <edit 
      :target="target"
      :target_patient="target_patient"
      :target_department="target_department"
      :patients="patients"
      :departments="departments" 
      :store="store" 
      :update="update" 
      :destroy="destroy"
    />
  </div>
  <!-- /.content-wrapper -->
</template>
<script>
// componentes importados
import Edit from "../sessions/Edit.vue";
import List from "../sessions/List.vue";

export default {
  name: "Sessions",
  components: {
    Edit,
    List,
  },
  data() {
    return {
      //general
      appointments: [],
      patients: [],
      departments: [],
      //edit
      target: {},
      target_patient: [],
      target_department: [],
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
      console.log($target);
      /* begin loading spinner*/
      this.$loading(true);
      /* close edit modal */
      $("#edit-appointment").modal("hide");
      /* api */
      const api = `${this.$urlAPI}appointment/store`;
      /* request */
      this.$axios
        .post(api, {
          department: $target.department,
          patient: $target.patient,
          anamnesis: $target.anamnesis,
          //status: $target.status,
          start_date: $target.start_date,
          //end_date: $target.end_date,
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
      console.log($target);
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
          department: $target.department,
          patient: $target.patient,
          anamnesis: $target.anamnesis,
          //status: $target.status,
          start_date: $target.start_date,
          //end_date: $target.end_date,
        })
        .then(({ data }) => {
          if (data.status) {
            let index = this.appointments.findIndex(
              (item) => item.id === data.appointment.id
            );
            if (index !== -1) {
              this.appointments[index].department_id = data.appointment.department_id;
              this.appointments[index].department_name = data.appointment.department_name;
              this.appointments[index].patient_id = data.appointment.patient_id;
              this.appointments[index].patient_name = data.appointment.patient_name;
              this.appointments[index].anamnesis = data.appointment.anamnesis;
              //this.appointments[index].status = data.appointment.status;
              this.appointments[index].start_date = data.appointment.start_date;
              //this.appointments[index].end_date = data.appointment.end_date;
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
        `Você tem certeza? O atendimento #${$target.id} de ${$target.patient.name} será excluído. Está ação não poderá ser desfeita.`
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
          this.$loading(false);
        })
        .catch((e) => {
          console.log(e.response.data.message);
          this.$loading(false);
        });
    },
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
      this.target_patient = [];
      this.target_department = [];

      this.getPatients();
      this.getDepartments();

      if ($id === 0) {
        this.target.id = null;
        this.target.department_id = null;
        this.target.patient_id = null;
        this.target.anamnesis = null;
        //this.target.status = null;
        this.target.start_date = null;
        //this.target.end_date = null;
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
            // get target patient
            if (data.appointment.patient_id) {
              let index = this.patients.findIndex(
                (item) => item.id === data.appointment.patient_id
              );
              if (index !== -1) {
                this.target_patient.push(this.patients[index]);
              }
            }
            // get target group
            if (data.appointment.department_id) {
              let index = this.departments.findIndex(
                (item) => item.id === data.appointment.department_id
              );
              if (index !== -1) {
                this.target_department.push(this.departments[index]);
              }
            }
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
