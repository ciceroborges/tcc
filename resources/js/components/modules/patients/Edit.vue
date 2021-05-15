<template>
  <div class="modal fade" id="edit-patient">
    <div class="modal-dialog">
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
          <h4 class="modal-title">{{`${this.target.new_record ? 'Adicionar' : 'Gerenciar'} paciente:`}}</h4>
        </div>
        <!-- form start -->
        <form role="form" @submit.prevent="callUpdate()">
          <div class="modal-body">
            <div class="box" style="border: none">
              <!-- /.box-header -->
              <div class="box-body">
                <div class="row">
                  <div class="col col-md-12">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Nome completo:</label>
                      <input
                        v-model="vm_target.name"
                        type="text"
                        class="form-control"
                        id="exampleInputEmail1"
                        placeholder="Ex: Lucas da Silva"
                        required
                      />
                    </div>
                  </div>
                  <div class="col col-md-6">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Apelido:</label>
                      <input
                        v-model="vm_target.nickname"
                        type="text"
                        class="form-control"
                        id="exampleInputEmail1"
                        placeholder="Ex: Lukinhas"
                      />
                    </div>
                  </div>
                  <div class="col col-md-6">
                    <div class="form-group">
                      <label for="exampleInputEmail1">CPF:</label>
                      <input
                        pattern="\d{3}\.\d{3}\.\d{3}-\d{2}"
                        title="Digite o CPF no formato xxx.xxx.xxx-xx"
                        v-model="vm_target.cpf"
                        type="text"
                        class="form-control"
                        id="exampleInputEmail1"
                        placeholder="Ex: 010.010.010-01"
                        required
                      />
                    </div>
                  </div>
                  <div class="col col-md-4">
                    <div class="form-group">
                      <label for="exampleInputFile">Gênero:</label>
                      <multiselect
                        :selectLabel="''"
                        :deselectLabel="''"
                        :selectedLabel="'selecionado'"
                        :openDirection="'bottom'"
                        :hide-selected="false"
                        :close-on-select="true"
                        :multiple="false"
                        :allowEmpty="false"
                        :options="gender_options"
                        v-model="vm_target.gender"
                        label="name"
                        track-by="name"
                        placeholder="Selecione..."
                        required
                      >
                      </multiselect>
                    </div>
                  </div>
                  <div class="col col-md-4">
                    <div class="form-group">
                      <label for="exampleInputFile">Tipo sanguíneo:</label>
                      <multiselect
                        :selectLabel="''"
                        :deselectLabel="''"
                        :selectedLabel="'selecionado'"
                        :openDirection="'bottom'"
                        :hide-selected="false"
                        :close-on-select="true"
                        :multiple="false"
                        :allowEmpty="false"
                        :options="blood_type_options"
                        v-model="vm_target.blood_type"
                        label="name"
                        track-by="name"
                        placeholder="Selecione..."
                        required
                      >
                      </multiselect>
                    </div>
                  </div>
                  <div class="col col-md-4">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Data de nascimento:</label>
                      <input
                        pattern="\d{2}\/\d{2}\/\d{4}"
                        title="Digite a data no formato DD/MM/AAAA"
                        v-model="vm_target.birth_date"
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
                      <label for="exampleInputEmail1">Alergia:</label>
                      <textarea
                        v-model="vm_target.allergy"
                        type="text"
                        rows="3"
                        class="form-control"
                        id="exampleInputEmail1"
                        placeholder="Ex: Dermatite: inflamação na pele que pode causar vermelhidão, coceira, pequenas bolhas e descamação..."
                      />
                    </div>
                  </div>
                  <div class="col col-md-12">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Endereço:</label>
                      <input
                        v-model="vm_target.address"
                        type="text"
                        class="form-control"
                        id="exampleInputEmail1"
                        placeholder="Ex: Rua da cidade, 1234, Bairro, Cidade, 00000-000"
                      />
                    </div>
                  </div>
                  <div class="col col-md-6">
                    <div class="form-group">
                      <label for="exampleInputEmail1">E-mail:</label>
                      <input
                        v-model="vm_target.email"
                        type="email"
                        class="form-control"
                        id="exampleInputEmail1"
                        placeholder="Ex: lucas@mail.com"
                      />
                    </div>
                  </div>
                  <div class="col col-md-6">
                    <div class="form-group">
                      <label for="exampleInputEmail1"
                        >Número do telefone:</label
                      >
                      <input
                        v-model="vm_target.phone_number"
                        type="text  "
                        class="form-control"
                        id="exampleInputEmail1"
                        placeholder="Ex: 54999999999 (apenas números)"
                        pattern="[0-9]{11}"
                        minlength="11"
                        maxlength="11"
                        required
                      />
                    </div>
                  </div>
                  <div class="col col-md-6">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Nome do contato:</label>
                      <input
                        v-model="vm_target.contact_name"
                        type="text"
                        class="form-control"
                        id="exampleInputEmail1"
                        placeholder="Ex: Joãozinho da Silva"
                      />
                    </div>
                  </div>
                  <div class="col col-md-6">
                    <div class="form-group">
                      <label for="exampleInputEmail1"
                        >Número de telefone do contato:</label
                      >
                      <input
                        v-model="vm_target.contact_phone_number"
                        type="text"
                        class="form-control"
                        id="exampleInputEmail1"
                        placeholder="Ex: 54999999999 (apenas números)"
                        pattern="[0-9]{11}"
                        minlength="11"
                        maxlength="11"
                      />
                    </div>
                  </div>
                  <div class="col col-md-12">
                    <div class="checkbox">
                      <label>
                        <input v-model="vm_target.destroy" type="checkbox" />
                        Excluir paciente
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
            <button type="submit" class="btn btn-primary">
              <i class="fa fa-check" /> GRAVAR
            </button>
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
</template>
<script>
export default {
  props: {
    /** @Objects */
    target: Object,
    /** @Arrays */
    /** @Functions */
    store: Function,
    update: Function,
    destroy: Function,
  },
  data() {
    return {
      vm_target: {
        id: null,
        name: null,
        nickname: null,
        cpf: null,
        birth_date: null,
        gender: null,
        blood_type: null,
        allergy: null,
        address: null,
        email: null,
        phone_number: null,
        contact_name: null,
        contact_phone_number: null,
        new_record: false,
        destroy: false,
      },
      gender_options: [
        { name: "Masculino", value: "M" },
        { name: "Feminino", value: "F" },
        { name: "Indefinido", value: "I" },
      ],
      blood_type_options: [
        { name: "A+" },
        { name: "A-" },
        { name: "B+" },
        { name: "B-" },
        { name: "AB+" },
        { name: "AB-" },
        { name: "O+" },
        { name: "O-" },
      ],
    };
  },
  methods: {
    callUpdate() {
      let target = {
        name: this.vm_target.name,
        nickname: this.vm_target.nickname,
        cpf: this.vm_target.cpf,
        birth_date: this.$moment.convertFromFormat(this.vm_target.birth_date, 'DD/MM/YYYY', 'YYYY-MM-DD'),
        gender: this.vm_target.gender.value,
        blood_type: this.vm_target.blood_type.name,
        allergy: this.vm_target.allergy,
        address: this.vm_target.address,
        email: this.vm_target.email,
        phone_number: this.vm_target.phone_number,
        contact_name: this.vm_target.contact_name,
        contact_phone_number: this.vm_target.contact_phone_number,
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
  },
  watch: {
    target() {
      this.vm_target.id = this.target.id;
      this.vm_target.name = this.target.name;
      this.vm_target.nickname = this.target.nickname;
      this.vm_target.cpf = this.target.cpf;
      this.vm_target.birth_date = this.target.birth_date ? this.$moment.convert(this.target.birth_date, 'DD/MM/YYYY') : '';
      this.vm_target.gender = {
        name: this.target.gender ? (this.target.gender === "M"  ? "Masculino" : this.target.gender === "F" ? "Feminino"  : "Indefinido") : 'Selecione...',
        value: this.target.gender,
      };
      this.vm_target.blood_type = {
        name: this.target.blood_type ? this.target.blood_type : 'Selecione...',
      };
      this.vm_target.allergy = this.target.allergy;
      this.vm_target.address = this.target.address;
      this.vm_target.email = this.target.email;
      this.vm_target.phone_number = this.target.phone_number;
      this.vm_target.contact_name = this.target.contact_name;
      this.vm_target.contact_phone_number = this.target.contact_phone_number;
      this.vm_target.new_record = this.target.new_record;
      this.vm_target.destroy = false;
    },
  },
};
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>