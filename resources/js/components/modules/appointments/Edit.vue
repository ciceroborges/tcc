<template>
  <div class="modal fade" id="edit-appointment">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button
            type="button"
            class="close"
            data-dismiss="modal"
            aria-label="Close"
          >
            <span aria-hidden="true">×</span>
          </button>
          <h4 class="modal-title">
            {{
              `${this.target.new_record ? "Adicionar" : "Gerenciar"} ${title}:`
            }}
          </h4>
        </div>
        <!-- form start -->
        <form role="form" @submit.prevent="callUpdate()">
          <div class="modal-body">
            <div class="box" style="border: none">
              <!-- /.box-header -->
              <div class="box-body">
                <div class="row">
                  <div class="col col-md-7">
                    <div class="form-group">
                      <label for="exampleInputFile">Paciente:</label>
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
                        v-model="vm_target.patient"
                        label="name"
                        track-by="name"
                        placeholder="Selecione..."
                        required
                      >
                      </multiselect>
                    </div>
                  </div>
                  <div class="col col-md-3">
                    <div class="form-group">
                      <label for="exampleInputFile">Departamento:</label>
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
                        v-model="vm_target.department"
                        label="name"
                        track-by="name"
                        placeholder="Selecione..."
                        required
                      >
                      </multiselect>
                    </div>
                  </div>
                  <div class="col col-md-2">
                    <div class="form-group">
                      <label for="exampleInputEmail1"
                        >Previsão de início:</label
                      >
                      <input
                        pattern="\d{2}\/\d{2}\/\d{4}"
                        title="Digite a data no formato DD/MM/AAAA"
                        v-model="vm_target.start_date"
                        type="text"
                        class="form-control"
                        id="exampleInputEmail1"
                        placeholder="Ex: 01/01/2021"
                        required
                      />
                    </div>
                  </div>
                  <div class="col col-md-12">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Anamnese:</label>
                      <textarea
                        v-model="vm_target.anamnesis"
                        type="text"
                        rows="5"
                        class="form-control"
                        id="exampleInputEmail1"
                        placeholder="Ex: O paciente informou que está com coceira e irritação nos olhos. Apresenta sinais de..."
                      />
                    </div>
                  </div>
                  <div class="col col-md-12">
                    <div class="checkbox">
                      <label>
                        <input v-model="vm_target.destroy" type="checkbox" />
                        Excluir atendimento
                      </label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-default pull-left"
              data-dismiss="modal"
            >
              <i class="fa fa-close" /> FECHAR
            </button>
            <div class="btn-group dropup" v-if="!vm_target.new_record">
              <button
                title="Lista de ações disponíveis"
                type="button"
                class="btn bg-olive dropdown-toggle"
                data-toggle="dropdown"
                aria-expanded="false"
              >
                <i class="fa fa-edit" /> AÇÕES
              </button>
              <ul class="dropdown-menu dropdown-menu-right" role="menu">
                <li>
                  <a
                    @click="statusUpdate(vm_target.id, 'IN PROGRESS')"
                    class="action-info"
                    href="#"
                    ><i class="fa fa-play-circle-o" />Iniciar atendimento</a
                  >
                </li>
                <li>
                  <a
                    @click="statusUpdate(vm_target.id, 'CONCLUDED')"
                    class="action-success"
                    href="#"
                    ><i class="fa fa-check-circle-o" />Concluir atendimento</a
                  >
                </li>
                <li>
                  <a
                    @click="statusUpdate(vm_target.id, 'CANCELED')"
                    class="action-danger"
                    href="#"
                    ><i class="fa fa-ban" />Cancelar atendimento</a
                  >
                </li>
              </ul>
            </div>
            <button
              type="submit"
              class="btn btn-primary"
              title="Salvar as alterações do formulário"
            >
              <i class="fa fa-check" /> GRAVAR
            </button>
          </div>
        </form>

        <!-- /.nav-tabs-custom -->
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
</template>
<script>
// componentes importados
import Sessions from "../sessions/Index";
export default {
  components: {
    Sessions,
  },
  props: {
    /** @Objects */
    target: Object,
    /** @Arrays */
    target_patient: Array,
    target_department: Array,
    patients: Array,
    departments: Array,
    /** @Functions */
    store: Function,
    update: Function,
    destroy: Function,
    statusUpdate: Function,
  },
  data() {
    return {
      vm_target: {
        id: null,
        patient: null,
        department: null,
        start_date: null,
        anamnesis: null,
        new_record: false,
        destroy: false,
      },
      title: "atendimento",
      appointment_tab: true,
      sessions_tab: false,
    };
  },
  methods: {
    callUpdate() {
      let target = {
        patient: this.vm_target.patient[0]
          ? this.vm_target.patient[0]
          : this.vm_target.patient,
        department: this.vm_target.department[0]
          ? this.vm_target.department[0]
          : this.vm_target.department,
        start_date: this.$moment.convertFromFormat(
          this.vm_target.start_date,
          "DD/MM/YYYY",
          "YYYY-MM-DD"
        ),
        anamnesis: this.vm_target.anamnesis,
      };

      if (this.vm_target.new_record) {
        this.store(target);
      } else {
        target.id = this.vm_target.id;
        if (!this.vm_target.destroy) {
          this.update(target);
        } else {
          this.destroy(target);
        }
      }
    },
    activeTab($tab) {
      switch ($tab) {
        case "appointment":
          if (!this.appointment_tab) {
            this.title = "atendimento";
            this.appointment_tab = true;
            this.sessions_tab = false;
          }
          break;
        case "sessions":
          if (!this.sessions_tab) {
            this.title = "sessões";
            this.appointment_tab = false;
            this.sessions_tab = true;
          }
          break;
      }
    },
  },
  watch: {
    target() {
      this.activeTab("appointment");
      this.vm_target.id = this.target.id;
      this.vm_target.start_date = this.target.start_date
        ? this.$moment.convert(this.target.start_date, "DD/MM/YYYY")
        : "";
      this.vm_target.anamnesis = this.target.anamnesis;
      this.vm_target.new_record = this.target.new_record;
      this.vm_target.destroy = false;
    },
    target_patient() {
      this.vm_target.patient = this.target_patient;
    },
    target_department() {
      this.vm_target.department = this.target_department;
    },
  },
};
</script>
<style scoped>
.action-info:hover {
  background-color: #00c0ef;
  opacity: 0.92;
  color: #fff;
}
.action-success:hover {
  background-color: #00a65a;
  opacity: 0.92;
  color: #fff;
}
.action-danger:hover {
  background-color: #dd4b39;
  opacity: 0.92;
  color: #fff;
}
</style>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>