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
            <hr class="hr-header" />
            <div class="row">
              <div class="col-md-2">
                <input
                  type="text"
                  value=""
                  class="form-control input-header"
                  placeholder="Filtrar por nome..."
                />
              </div>
              <div class="col-md-2">
                <input
                  type="text"
                  value=""
                  class="form-control input-header"
                  placeholder="Filtrar por e-mail..."
                />
              </div>
              <div class="col-md-2">
                <select class="form-control">
                  <option>Selecione</option>
                  <option>1</option>
                  <option>2</option>
                  <option>3</option>
                </select>
              </div>
              <div class="col-md-2">
               <multiselect
                deselect-label=""
                selectLabel=""
                :hide-selected="true"
                v-model="searched_group"
                :options="groups"
                label="name"
                track-by="name"
                @select="attachSelected = true"
                placeholder="Grupo..."
                :multiple="false"
                :close-on-select="true"
              >
              </multiselect>
              </div>
              <div class="col-md-2">
                <button
                  class="btn btn-round btn-sm btn-white btn-just-icon"
                  data-toggle="tab"
                >
                  <i class="material-icons" style="color: rgb(0, 188, 212) !important;">search</i>
                  <div class="ripple-container"></div>
                </button>
                <button
                  class="btn btn-round btn-sm btn-white btn-just-icon"
                  data-toggle="tab"
                >
                  <i class="material-icons" style="color: #f44336;">close</i>
                  <div class="ripple-container"></div>
                </button>
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
                  <tr v-for="(row, index) in users" :key="index">
                    <td>{{ row.id }}</td>
                    <td>{{ row.name }}</td>
                    <td>{{ row.email }}</td>
                    <td>
                      {{ row.group_name ? row.group_name : "Indefinido" }}
                    </td>
                    <td>
                      {{
                        row.departments_names
                          ? row.departments_names
                          : "Indefinido"
                      }}
                    </td>
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
              <infinite-loading
                @infinite="getAll"
                spinner="spiral"
                ref="loadUsers"
              >
                <!-- criar chave de tradução -->
                <div slot="no-more">
                  <hr />
                  <small>Sem mais resultados</small>
                </div>
                <!-- criar chave de tradução -->
                <div slot="no-results">
                  <hr />
                  <small>Nenhum resultado encontrado</small>
                </div>
              </infinite-loading>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      //general
      users: [],
      departments: [],
      groups: [],
      //search
      searched_name: null,
      searched_email: null,
      searched_department: null,
      searched_group: null,
      //infinite loading
      skip: 0,
      take: 5,
    };
  },
  created() {
    this.getDepartments();
    this.getGroups();
  },
  methods: {
    getAll($state) {
      setTimeout(() => {
        /* api */
        const api = `${this.$urlAPI}user/all`;
        /* request */
        this.$axios
          .get(api, {
            params: {
              skip: this.skip,
              take: this.take,
            },
          })
          .then(({ data }) => {
            if (data.users.length) {
              this.skip = data.skip;
              this.users.push(...data.users);
              $state.loaded();
            } else {
              $state.complete();
            }
          })
          .catch((e) => {
            console.log(e.response.data.message);
          });
      }, 1000);
    },
    getDepartments() {
        /* api */
        const api = `${this.$urlAPI}department/all`;
        /* request */
        this.$axios
          .get(api, {}).then(({ data }) => {
            this.departments = data.departments;
          })
          .catch((e) => {
            console.log(e.response.data.message);
          });
    },
    getGroups() {
        /* api */
        const api = `${this.$urlAPI}group/all`;
        /* request */
        this.$axios
          .get(api, {}).then(({ data }) => {
            this.groups = data.groups;
          })
          .catch((e) => {
            console.log(e.response.data.message);
          });
    },
  },
};
</script>
<style scoped>
.hr-header {
  background-color: rgba(255, 255, 255, 0.8) !important;
}
.input-header {
  color: rgba(255, 255, 255, 0.8);
  border-color: #aaaaaa;
  background-image: linear-gradient(
      to top,
      rgba(255, 255, 255, 0.8) 2px,
      rgba(156, 39, 176, 0) 2px
    ),
    linear-gradient(
      to top,
      rgba(255, 255, 255, 0.8) 1px,
      rgba(210, 210, 210, 0) 1px
    );
}
.input-header::placeholder {
  color: rgba(255, 255, 255, 0.8);
  opacity: 1;
}
</style>