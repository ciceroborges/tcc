<template>
  <!--<div>-->
  <!-- Content Header (Page header) -->
  <!--
    <section class="content-header">
      <h1>
        Usuários
        <small>Optional description</small>
      </h1>
      <ol class="breadcrumb">
        <li>
          <router-link to="home"
            ><i class="fa fa-dashboard"></i> Home</router-link
          >
        </li>
        <li class="active">Usuários</li>
      </ol>
    </section>
    -->
  <!-- Main content -->
  <section class="content container-fluid">
    <div class="col-xs-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Lista de registros:</h3>
          <div class="box-tools">
            <button class="btn btn-sm btn-primary" @click="edit(0)">
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
                <th>Nome</th>
              </tr>
              <tr
                :title="`Clique para gerenciar o departamento: ${row.name}`"
                v-for="(row, index) in departments"
                :key="index"
                class="clickable"
                @click="edit(row.id)"
              >
                <td>{{ `#${row.id}` }}</td>
                <td>{{ row.name }}</td>
              </tr>
            </tbody>
          </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer clearfix">
          <infinite-loading
            @infinite="index"
            spinner="spiral"
            ref="infiniteDepartmentsTable"
          >
            <div slot="no-more">
              <small>{{ `${count} registro(s) encontrado(s).` }}</small>
            </div>
            <div slot="no-results">
              <small>{{ `${count} registro(s) encontrado(s).` }}</small>
            </div>
          </infinite-loading>
        </div>
      </div>
      <!-- /.box -->
    </div>
  </section>
  <!--
  </div>
  -->
</template>
<script>
export default {
  props: {
    departments: Array,
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
</style>