<template>
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li class="active">
        <a href="#control-sidebar-home-tab" data-toggle="tab"
          ><i class="fa fa-search"></i
        ></a>
      </li>
      <li>
        <a href="#" data-toggle="control-sidebar"
          ><i class="fa fa-close"></i
        ></a>
      </li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane active" id="control-sidebar-home-tab">
        <ul class="control-sidebar-menu">
          <li>
            <form role="form" @submit.prevent="search()">
              <div class="box" style="border: none">
                <!-- /.box-header -->
                <div class="box-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Filtrar por nome:</label>
                    <input
                      v-model="vm_searched_name"
                      type="text"
                      minlength="3"
                      class="form-control"
                      id="exampleInputEmail1"
                      placeholder="Ex: Administradores"
                      required
                    />
                  </div>
                  <div class="form-group">
                    <button type="button" class="btn btn-default" @click="clear()">
                      <i class="fa fa-trash-o"></i> LIMPAR
                    </button>
                    <button type="submit" class="btn btn-primary pull-right">
                      <i class="fa fa-search"></i> BUSCAR
                    </button>
                  </div>
                </div>
              </div>
            </form>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->
        <!--
        <h3 class="control-sidebar-heading">Tasksa Progress</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:;">
              <h4 class="control-sidebar-subheading">
                Custom Template Design
                <span class="pull-right-container">
                  <span class="label label-danger pull-right">70%</span>
                </span>
              </h4>

              <div class="progress progress-xxs">
                <div
                  class="progress-bar progress-bar-danger"
                  style="width: 70%"
                ></div>
              </div>
            </a>
          </li>
        </ul>
        -->
        <!-- /.control-sidebar-menu -->
      </div>
      <!-- /.tab-pane -->
      <!-- Stats tab content  -->
      <div class="tab-pane" id="control-sidebar-stats-tab">
        Stats Tab Content
      </div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post">
          <h3 class="control-sidebar-heading">General Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked />
            </label>

            <p>Some information about this general settings option</p>
          </div>
          <!-- /.form-group -->
        </form>
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
</template>
<script>
export default {
  props: {
    /** @Objects */
    /** @Arrays */
    /** @Functions */
  },
  data() {
    return {
      vm_searched_name: null,
    };
  },
  methods: {
    search(){
      this.vm_searched_name = this.vm_searched_name.trim();
      if(this.vm_searched_name.length >= 3) {
        this.$emit('search', this.vm_searched_name);
      }
    },
    clear() {
      //console.log('exlcui')
      this.vm_searched_name = null;
      this.$emit('search', this.vm_searched_name);
    },
  }
};
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style scoped>
.box {
  background-color: #222d32 !important;
  border: none !important;
}
.box-footer {
  background-color: #222d32 !important;
  border: none !important;
}
</style>