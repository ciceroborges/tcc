<template>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- list table -->
    <list
      :patients="patients"
      :count="count"
      :index="index"
      :edit="edit"
      ref="PatientList"
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
import Edit from "../patients/Edit.vue";
import List from "../patients/List.vue";
import Search from "../patients/Search.vue";

export default {
  name: "Patients",
  components: {
    Edit,
    List,
    Search,
  },
  data() {
    return {
      //general
      patients: [],
      //edit
      target: {},
      //search
      filter: null,
      searched_patient: null,
      //infinite loading
      skip: 0,
      take: 30,
      //count
      count: 0,
    };
  },
  created() {},
  methods: {
    /*--------*/
    /** @read */
    /*--------*/
    index($state) {
      /* api */
      const api = `${this.$urlAPI}patient/index`;
      /* request */
      this.$axios
        .get(api, {
          params: {
            filter: this.searched_patient,
            skip: this.skip,
            take: this.take,
          },
        })
        .then(({ data }) => {
          if (data.patients.length) {
            this.skip = data.skip;
            this.count = this.patients.length + data.patients.length;
            this.patients.push(...data.patients);

            if (data.patients.length === this.take) {
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
      $("#edit-patient").modal("hide");
      /* api */
      const api = `${this.$urlAPI}patient/store`;
      /* request */
      this.$axios
        .post(api, {
          name: $target.name,
          nickname: $target.nickname,
          cpf: $target.cpf,
          birth_date: $target.birth_date,
          gender: $target.gender,
          blood_type: $target.blood_type,
          allergy: $target.allergy,
          address: $target.address,
          email: $target.email,
          phone_number: $target.phone_number,
          picture: $target.picture,
          contact_name: $target.contact_name,
          contact_phone_number: $target.contact_phone_number,
        })
        .then(({ data }) => {
          if (data.status) {
            //this.patients.push(data.patient);
            this.reset();
            alert(data.message);
          } else {
            alert(data.message);
            $("#edit-patient").modal("show");
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
      $("#edit-patient").modal("hide");
      /* api */
      const api = `${this.$urlAPI}patient/update`;
      /* request */
      this.$axios
        .put(api, {
          id: $target.id,
          name: $target.name,
          nickname: $target.nickname,
          cpf: $target.cpf,
          birth_date: $target.birth_date,
          gender: $target.gender,
          blood_type: $target.blood_type,
          allergy: $target.allergy,
          address: $target.address,
          email: $target.email,
          phone_number: $target.phone_number,
          picture: $target.picture,
          contact_name: $target.contact_name,
          contact_phone_number: $target.contact_phone_number,
        })
        .then(({ data }) => {
          if (data.status) {
            let index = this.patients.findIndex(
              (item) => item.id === data.patient.id
            );
            if (index !== -1) {
              this.patients[index].name = data.patient.name;
              this.patients[index].nickname = data.patient.nickname;
              this.patients[index].cpf = data.patient.cpf;
              this.patients[index].birth_date = data.patient.birth_date;
              this.patients[index].gender = data.patient.gender;
              this.patients[index].blood_type = data.patient.blood_type;
              this.patients[index].allergy = data.patient.allergy;
              this.patients[index].address = data.patient.address;
              this.patients[index].email = data.patient.email;
              this.patients[index].phone_number = data.patient.phone_number;
              this.patients[index].picture = data.patient.picture;
              this.patients[index].contact_name = data.patient.contact_name;
              this.patients[index].contact_phone_number =
                data.patient.contact_phone_number;
            }
            alert(data.message);
          } else {
            alert(data.message);
            $("#edit-patient").modal("show");
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
        `Você tem certeza? O paciente ${$target.name} será excluído. Está ação não poderá ser desfeita.`
      );
      if ($confirm) {
        /* begin loading spinner*/
        this.$loading(true);
        /* close edit modal */
        $("#edit-patient").modal("hide");
        /* api */
        const api = `${this.$urlAPI}patient/destroy`;
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
              $("#edit-patient").modal("hide");
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
        this.target.name = null;
        this.target.nickname = null;
        this.target.cpf = null;
        this.target.birth_date = null;
        this.target.gender = null;
        this.target.blood_type = null;
        this.target.allergy = null;
        this.target.address = null;
        this.target.email = null;
        this.target.phone_number = null;
        this.target.contact_name = null;
        this.target.contact_phone_number = null;
        this.target.new_record = true;
        // show edit modal
        $("#edit-patient").modal("show");
        // stop loading spinner
        this.$loading(false);
      } else {
        /* api */
        const api = `${this.$urlAPI}patient/find`;
        /* request */
        this.$axios
          .get(api, {
            params: {
              id: $id,
            },
          })
          .then(({ data }) => {
            // get target data
            this.target = data.patient;
            // show edit modal
            $("#edit-patient").modal("show");
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
      this.patients = [];
      this.skip = 0;
      this.count = 0;
      this.$refs.PatientList.$refs.infinitePatientsTable.stateChanger.reset();
    }
  },
  watch: {
    searched_patient() {
      this.reset();
    },
  },
};
</script>
