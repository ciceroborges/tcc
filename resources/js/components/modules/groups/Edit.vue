<template>
  <div class="modal fade" id="edit-group">
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
          <h4 class="modal-title">Gerenciar grupo:</h4>
        </div>
        <!-- form start -->
        <form role="form" @submit.prevent="callUpdate()">
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
                    disabled
                    required
                  />
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
    update: Function,
    destroy: Function,
  },
  data() {
    return {
      vm_target_id: null,
      vm_target_name: null,
      vm_target_destroy: false,
    };
  },
  methods:{
    callUpdate(){
      /*
      let target = {
        id: this.target.id,
        name: this.vm_target_name,
      };
      if(!this.vm_target_destroy){
        this.update(target);
      } else {
        this.destroy(target);
      } 
      */
    }
  },
  watch: {
    target(){
      this.vm_target_id = this.target.id;
      this.vm_target_name = this.target.name;
      this.vm_target_destroy = false;
    },
  }
};
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>