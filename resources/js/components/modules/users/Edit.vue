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
          <h4 class="modal-title">Default Modal</h4>
        </div>
        <div class="modal-body">
          <p>{{ target }}</p>
        </div>
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-default pull-left"
            data-dismiss="modal"
          >
            Close
          </button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
</template>
<script>
export default {
  props:{
    target: Object,
  },
}
</script>