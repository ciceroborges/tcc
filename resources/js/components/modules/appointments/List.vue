<template>
  <div>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-clipboard" /> Atendimentos
        <small>| Gerencie os atendimentos cadastrados no sistema.</small>
      </h1>
      <ol class="breadcrumb">
        <li>
          <router-link to="#"><i class="fa fa-home"></i> Home</router-link>
        </li>
        <li class="active">Atendimentos</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="nav-tabs-custom">
            <div class="tab-content">
              <div class="tab-pane active" id="users">
                <section class="content container-fluid">
                  <div class="col-xs-12">
                    <div class="box box-primary">
                      <div class="box-header with-border">
                        <h3 class="box-title">Lista de registros:</h3>
                        <div class="box-tools">
                          <button
                            class="btn btn-sm btn-primary"
                            @click="edit(0)"
                          >
                            <i class="fa fa-plus" /> NOVO
                          </button>
                        </div>
                      </div>
                      <!-- /.box-header -->
                      <div class="box-body table-responsive no-padding">
                        <table
                          class="table table-bordered table-hover table-condensed table-striped"
                        >
                          <tbody>
                            <tr>
                              <th>#ID</th>
                              <th>Data de início</th>
                              <th>Paciente</th>
                              <th>Departamento</th>
                              <th>Status</th>
                              <th>Data Final</th>
                            </tr>
                            <tr
                              :title="`Clique para gerenciar o atendimento: ${row.id}`"
                              v-for="(row, index) in appointments"
                              :key="index"
                              class="clickable"
                              @click="edit(row.id)"
                            >
                              <td>{{ `#${row.id}` }}</td>
                              <td>
                                {{
                                  $moment.convert(row.start_date, "DD/MM/YYYY")
                                }}
                              </td>
                              <td>{{ row.patient_name }}</td>
                              <td><span class="label label-primary upper">{{ row.department_name }}</span></td>
                              <td><span :class="status[row.status].class">{{ status[row.status].name }}</span></td>
                              <td>
                                {{
                                  row.end_date ? $moment.convert(row.end_date, "DD/MM/YYYY") : 'Indefinido'
                                }}
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <!-- /.box-body -->
                      <div class="box-footer clearfix">
                        <infinite-loading
                          @infinite="index"
                          spinner="spiral"
                          ref="infiniteAppointmentsTable"
                        >
                          <div slot="no-more">
                            <small>{{
                              `${count} registro(s) encontrado(s).`
                            }}</small>
                          </div>
                          <div slot="no-results">
                            <small>{{
                              `${count} registro(s) encontrado(s).`
                            }}</small>
                          </div>
                        </infinite-loading>
                      </div>
                    </div>
                    <!-- /.box -->
                  </div>
                </section>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>
<script>
export default {
  props: {
    appointments: Array,
    count: Number,
    //methods
    index: Function,
    edit: Function,
  },
  data(){
    return {
      status: {
        'WAITING': {
          name: 'Aguardando', 
          class: 'label label-warning upper'
        },
        'IN PROGRESS': {
          name: 'Em Progresso', 
          class: 'label label-info upper'
        },
        'CONCLUDED': {
          name: 'Concluído', 
          class: 'label label-success upper'
        },
        'CANCELED': {
          name: 'Cancelado', 
          class: 'label label-danger upper'
        },
      }
    }
  },
  created() {},
};
</script>
<style scoped>
tr.clickable {
  cursor: pointer;
}
tr.clickable:hover {
  color: white;
  background-color: #72afd2 !important;
}
.upper {
  text-transform: uppercase;
}
</style>