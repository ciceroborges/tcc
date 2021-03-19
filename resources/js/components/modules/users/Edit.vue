<template>
  <div class="modal fade" id="edit-modal">
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
          <h4 class="modal-title">Editar usuário</h4>
        </div>
        <!-- form start -->
        <form role="form" @submit.prevent="consoleee">
          <div class="modal-body">
            <div class="box" style="border: none">
              <!-- /.box-header -->
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Nome completo:</label>
                  <input
                    :value="`${target !== null ? target.name : ''}`"
                    type="name"
                    class="form-control"
                    id="exampleInputEmail1"
                    placeholder="Enter email"
                  />
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">E-mail:</label>
                  <input
                    :value="`${target !== null ? target.email : ''}`"
                    type="email"
                    class="form-control"
                    id="exampleInputEmail1"
                    placeholder="Enter email"
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
                    :options="groups"
                    v-model="vm_target_group"
                    label="name"
                    track-by="name"
                    placeholder="Selecione..."
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
                    :options="departments"
                    v-model="vm_target_departments"
                    label="name"
                    track-by="name"
                    placeholder="Selecione..."
                  >
                  </multiselect>
                </div>
                <p>{{ target }}</p>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-default pull-left"
              data-dismiss="modal"
            >
              Close
            </button>
            <button type="submit" class="btn btn-primary">Save changes</button>
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
  },
  data() {
    return {
      vm_target_group: this.target_group !== null ? this.target_group : null,
      vm_target_departments: this.target_departments !== null ? this.target_departments : null,
    };
  },
  created() {
    
  },
  methods: {
    consoleee(){
      console.log(this.groups);
      console.log(this.target_group);
      console.log(this.departments);
      console.log(this.target_departments);
    }
  }
};
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>