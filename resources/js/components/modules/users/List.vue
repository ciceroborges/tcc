<template>
  <div>
    <!-- Content Header (Page header) -->
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
    <!-- Main content -->
    <section class="content container-fluid">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Bordered Table</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table
              class="table table-bordered table-hover table-condensed table-striped"
            >
              <tbody>
                <tr>
                  <th>#ID</th>
                  <th>Nome</th>
                  <th>E-mail</th>
                  <th>Grupo</th>
                  <th>Departamentos</th>
                </tr>
                <tr
                  v-for="(row, index) in users"
                  :key="index"
                  class="clickable"
                  @click="update(row.id)"
                >
                  <td>{{ `#${row.id}` }}</td>
                  <td>{{ row.name }}</td>
                  <td>{{ row.email }}</td>
                  <td>{{ row.group_name ? row.group_name : "Indefinido" }}</td>
                  <td>
                    {{
                      row.departments_names
                        ? row.departments_names
                        : "Indefinido"
                    }}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.box-body -->
          <div class="box-footer clearfix">
            <slot />
          </div>
        </div>
        <!-- /.box -->
      </div>
    </section>
  </div>
</template>
<script>
export default {
  props: {
    users: Array,
  },
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