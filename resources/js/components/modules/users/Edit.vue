<template>
  <div class="modal fade" id="edit-user">
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
          <h4 class="modal-title">Gerenciar usuário:</h4>
        </div>
        <!-- form start -->
        <form role="form" @submit.prevent="callUpdate()">
          <div class="modal-body">
            <div class="box" style="border: none">
              <!-- /.box-header -->
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Nome completo:</label>
                  <input
                    v-model="vm_target_name"
                    type="name"
                    class="form-control"
                    id="exampleInputEmail1"
                    placeholder="Enter email"
                    required
                  />
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">E-mail:</label>
                  <input
                    v-model="vm_target_email"
                    type="email"
                    class="form-control"
                    id="exampleInputEmail1"
                    placeholder="Enter email"
                    required
                  />
                </div>
                <div class="form-group">
                  <label>Grupo</label>
                  <multiselect
                    :selectLabel="''"
                    :deselectLabel="''"
                    :selectedLabel="'selecionado'"
                    :openDirection="'bottom'"
                    :hide-selected="false"
                    :close-on-select="true"
                    :multiple="false"
                    :allowEmpty="false"
                    :options="groups"
                    v-model="vm_target_group"
                    label="name"
                    track-by="name"
                    placeholder="Selecione..."
                    required
                  >
                  </multiselect>
                </div>
                <div class="form-group">
                  <label for="exampleInputFile">Departamentos</label>
                  <multiselect
                    :selectLabel="''"
                    :deselectLabel="''"
                    :selectedLabel="'selecionado'"
                    :openDirection="'bottom'"
                    :hide-selected="true"
                    :close-on-select="true"
                    :multiple="true"
                    :allowEmpty="false"
                    :options="departments"
                    v-model="vm_target_departments"
                    label="name"
                    track-by="name"
                    placeholder="Selecione..."
                  >
                  </multiselect>
                </div>
                <div class="checkbox">
                  <label>
                    <input v-model="vm_target_destroy" type="checkbox"> Excluir usuário
                  </label>
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
              Fechar
            </button>
            <button type="submit" class="btn btn-primary">Gravar</button>
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
    target_group: Array,
    target_departments: Array,
    departments: Array,
    groups: Array,
    /** @Functions */
    update: Function,
    destroy: Function,
  },
  data() {
    return {
      vm_target_name: null,
      vm_target_email: null,
      vm_target_group: null,
      vm_target_departments: null,
      vm_target_destroy: false,
    };
  },
  methods:{
    callUpdate(){
      let target = {
        uuid: this.target.uuid,
        name: this.vm_target_name,
        email: this.vm_target_email,
        group: this.vm_target_group,
        departments: this.vm_target_departments,
      };
      if(!this.vm_target_destroy){
        this.update(target);
      } else {
        this.destroy(target);
      } 
    }
  },
  watch: {
    target(){
      this.vm_target_name = this.target.name;
      this.vm_target_email = this.target.email;
      this.vm_target_destroy = false;
    },
    target_group(){
      this.vm_target_group = this.target_group;
    },
    target_departments(){
      this.vm_target_departments = this.target_departments;
    },
  }
};
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>