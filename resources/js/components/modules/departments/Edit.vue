<template>
  <div class="modal fade" id="edit-department">
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
          <h4 class="modal-title">
            {{
              `${
                vm_target_new_record ? "Adicionar" : "Gerenciar"
              } departamento:`
            }}
          </h4>
        </div>
        <!-- form start -->
        <form role="form" @submit.prevent="callAction()">
          <div class="modal-body">
            <div class="box" style="border: none">
              <!-- /.box-header -->
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Nome:</label>
                  <input
                    v-model="vm_target_name"
                    type="name"
                    class="form-control"
                    id="exampleInputEmail1"
                    placeholder="Nome completo"
                    required
                  />
                </div>
                <div class="checkbox" v-if="!vm_target_new_record">
                  <label>
                    <input v-model="vm_target_destroy" type="checkbox" />
                    Excluir departamento
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
      vm_target_id: null,
      vm_target_name: null,
      vm_target_destroy: false,
      vm_target_new_record: false,
    };
  },
  methods:{
    callAction(){
      if(this.vm_target_new_record) {
        let target = {
          name: this.vm_target_name,
        }
        this.store(target);
      } else {
        let target = {
          id: this.target.id,
          name: this.vm_target_name,
        };
        if(!this.vm_target_destroy){
          this.update(target);
        } else {
          this.destroy(target);
        }
      } 
    }
  },
  watch: {
    target(){
      this.vm_target_id = this.target.id;
      this.vm_target_name = this.target.name;
      this.vm_target_destroy = false;
      this.vm_target_new_record = this.target.new_record;
    },
  }
};
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>