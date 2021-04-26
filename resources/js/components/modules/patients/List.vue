<template>
  <div>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-venus-mars"/> Pacientes
        <small>| Gerencie os pacientes cadastrados no sistema.</small>
      </h1>
      <ol class="breadcrumb">
        <li>
          <router-link to="#"
            ><i class="fa fa-home"></i> Home</router-link
          >
        </li>
        <li class="active">Pacientes</li>
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
                          <button class="btn btn-sm btn-primary"><i class="fa fa-plus"/> NOVO</button>
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
                              <th width="25">#AV</th>
                              <th>Nome</th>
                              <th>CPF</th>
                              <th>Data de nascimento</th>
                              <th>Gênero</th>
                              <th>Tipo sanguíneo</th>
                              <th>Contato</th>
                            </tr>
                            <tr
                              :title="`Clique para gerenciar o usuário: ${row.name}`"
                              v-for="(row, index) in patients"
                              :key="index"
                              class="clickable"
                              @click="edit(row.id)"
                            >
                              <td>{{ `#${row.id}` }}</td>
                              <td>
                                <img
                                  src="dist/img/user2-160x160.jpg"
                                  alt="User Image"
                                  class="img-circle"
                                  style="width: 25px; height: 25px"
                                />
                              </td>
                              <td>{{ row.name }} {{ row.nickname ? `(${ row.nickname })` : ''}}</td>
                              <td>{{ row.cpf }}</td>
                              <td>{{ row.birth_date }}</td>
                              <td>{{ row.gender }}</td>
                              <td>{{ row.blood_type }}</td>
                              <td>{{ row.phone_number }}</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <!-- /.box-body -->
                      <div class="box-footer clearfix">
                        <infinite-loading
                          @infinite="index"
                          spinner="spiral"
                          ref="infiniteUsersTable"
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
    users: Array,
    count: Number,
    //methods
    index: Function,
    edit: Function,
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
.content {
  /*min-height: 725px;*/
}
</style>