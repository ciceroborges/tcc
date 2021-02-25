<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-tabs card-header-info">
            <div class="row">
      <div class="col-md-10">  
            <h4 class="card-title">Tabela de Usuários</h4>
            <p class="card-category">
              Crie, edite, ou exclua os usuários do sistema
            </p>
      </div>
      <div class="col-md-2">  
            <div class="nav-tabs-navigation">
              <div class="nav-tabs-wrapper float-right">
                <!--<span class="nav-tabs-title">Ações:</span>-->
                <ul class="nav nav-tabs" data-tabs="tabs">
                  <li class="nav-item">
                    <a
                      class="nav-link active"
                      href="#profile"
                      data-toggle="tab"
                    >
                      <i class="material-icons">person_add_alt_1</i> Novo
                      Usuário
                      <div class="ripple-container"></div>
                    </a>
                  </li>
                  <!--
                  <li class="nav-item">
                    <a class="nav-link" href="#messages" data-toggle="tab">
                      <i class="material-icons">code</i> Website
                      <div class="ripple-container"></div>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#settings" data-toggle="tab">
                      <i class="material-icons">cloud</i> Server
                      <div class="ripple-container"></div>
                    </a>
                  </li>
                  -->
                </ul>
              </div>
            </div>
      </div>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table">
                <thead class="text-primary">
                  <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Grupo</th>
                    <th>Departamentos</th>
                    <th>Ações</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1</td>
                    <td>Dakota Rice</td>
                    <td>dakota@mail.com</td>
                    <td>Gestores</td>
                    <td>Financeiro, RH</td>
                    <td class="td-actions">
                      <button
                        type="button"
                        rel="tooltip"
                        title=""
                        class="btn btn-primary btn-link btn-sm"
                        data-original-title="Editar"
                      >
                        <i class="material-icons">edit</i>
                      </button>
                      <button
                        type="button"
                        rel="tooltip"
                        title=""
                        class="btn btn-danger btn-link btn-sm"
                        data-original-title="Excluir"
                      >
                        <i class="material-icons">close</i>
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  created() {},
};
</script>