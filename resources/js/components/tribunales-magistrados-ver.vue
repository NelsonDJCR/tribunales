<template>
  <div class="main col-12" id="sesion">
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0"
      crossorigin="anonymous"
    />

    <div class="container mt-5">
      <!-- Breadcrumb -->
      <ol class="breadcrumb">
        <li class="breadcrumb-item active">
          <router-link :to="{ name: 'home' }"><span>Home</span></router-link> /
          <label for="" class="p-2"
            >Tribunales de Garantía / Listado de Magistrados / Ver
            Magistrado</label
          >
        </li>
      </ol>
      <div class="row p-2 text-center border shadow rounded-3">
        <div class="row">
          <div class="col-12 col-md-12 col-lg-10 col-xl-10 p-2">
            <h1 class="text-blue"><b>VISUALIZACIÓN DE FUNCIONARIO</b></h1>
          </div>
          <div class="col-12 col-md-12 col-lg-2 col-xl-2 p-2">
            <router-link
              :to="`/tribunales-magistrados-listar`"
              @click.native="$router.go()"
              class="btn btn-secondary active text-white w-100 mt-2"
              >Volver al listado</router-link
            >
          </div>
        </div>
      </div>

      <form @submit.prevent="save">
        <div class="row">
          <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-5">
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Nombre</b></label>
                <input
                  type="text"
                  class="form-control"
                  maxlength="250"
                  name=""
                  v-model="data_record.nombre"
                  disabled
                />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"
                  ><b>Tipo de Identificación</b></label
                >
                <select
                  disabled
                  v-model="data_record.id_tipo_identificacion"
                  class="form-select"
                  name=""
                >
                  <option
                    v-for="(i, index) in tipo_identificacion"
                    :key="index"
                    :value="i.id"
                    v-text="i.nombre"
                  ></option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"
                  ><b>Número de Identificación</b></label
                >
                <input
                  type="number"
                  class="form-control"
                  maxlength="15"
                  v-model="data_record.numero_identificacion"
                  disabled
                />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Departamento</b></label>
                <select
                  disabled
                  class="form-select"
                  name=""
                  v-model="data_record.dep_id"
                >
                  <option
                    v-for="(i, index) in departament"
                    :key="index"
                    :value="i.id"
                    v-text="i.nombre"
                  ></option>
                </select>
              </div>
            </div>

            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Ciudad</b></label>
                <select
                  disabled
                  v-model="data_record.ciu_id"
                  class="form-select"
                  name="municipality"
                  id="municipio"
                >
                  <option
                    v-for="(i, index) in ciudades"
                    :key="index"
                    :value="i.id"
                    v-text="i.nombre"
                  ></option>
                </select>
              </div>
            </div>

            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Dirección</b></label>
                <input
                  type="text"
                  class="form-control"
                  maxlength="250"
                  name=""
                  v-model="data_record.direccion"
                  disabled
                />
              </div>
            </div>

            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"
                  ><b>Correo Electrónico</b>
                </label>
                <input
                  type="email"
                  class="form-control"
                  placeholder="correo@correo.com"
                  disabled
                  v-model="data_record.correo"
                />
              </div>
            </div>

            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Teléfono</b> </label>
                <div class="input-group">
                  <input
                    type="number"
                    class="form-control"
                    v-model="data_record.telefono"
                    disabled
                  />
                </div>
              </div>
            </div>
          </div>

          <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-5">
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Banco</b></label>
                <select
                  disabled
                  class="form-select"
                  v-model="data_record.id_banco"
                  name=""
                >
                  <option
                    v-for="(i, index) in bancos"
                    :key="index"
                    :value="i.id"
                    v-text="i.nombre"
                  ></option>
                </select>
              </div>
            </div>

            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Tipo de Cuenta</b></label>
                <select
                  disabled
                  class="form-select"
                  v-model="data_record.id_tipo_cuenta"
                  name=""
                >
                  <option
                    v-for="(i, index) in tipo_cuentas"
                    :key="index"
                    :value="i.id"
                    v-text="i.nombre"
                  ></option>
                </select>
              </div>
            </div>

            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"
                  ><b>Número de Cuenta</b>
                </label>
                <input
                  type="number"
                  class="form-control"
                  v-model="data_record.numero_cuenta"
                  disabled
                />
              </div>
            </div>
            <div class="row">
              <div class="mb-1">
                <label for="" class="form-label"><b>Archivos</b></label>
                <div class="row">
                  <div class="btns-block d-grid gap-2">
                    <ul class="list-group btn-group-vertical">
                      <li
                        class="list-group-item"
                        v-for="(i, index) in documentos"
                        :key="index"
                      >
                        <div class="btn btn-light btn-sm mt-2">
                          <span class="text-start float-start mt-1">
                            <select
                              class="form-control bg-transparent text-dark"
                              style="outline: none"
                              v-model="i.id_tipo_documento"
                              disabled
                            >
                              <option
                                v-for="(item, index) in type_file"
                                :key="index"
                                :value="item.id"
                                v-text="item.nombre"
                              ></option></select
                          ></span>
                          <a
                            :href="i.ruta"
                            :download="i.ruta"
                            class="badge bg-info float-end text-end m-1"
                            id="prueba"
                            ><i class="fa fa-download fa-md"></i
                          ></a>
                        </div>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>

    <div
      class="modal fade"
      id="modal_file"
      data-bs-backdrop="static"
      data-bs-keyboard="false"
      tabindex="-1"
      aria-labelledby="staticBackdropLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">
              Agregar Documentos
            </h5>
            <button
              type="button"
              class="btn-close"
              @click="closeAddFile()"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <div class="row mb-2">
              <div class="col-11">
                <label class="form-label">Agrege todos los documentos</label>
              </div>
              <div class="col-1">
                <button
                  class="btn-more btn"
                  id="add_file"
                  @click="add_file()"
                  type="button"
                >
                  <!-- <i class="fas fa-plus"></i> -->
                  <i class="typcn typcn-document-add" style="color: green"></i>
                </button>
              </div>
            </div>
            <div class="col-12" id="box_files"></div>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-primary"
              @click="closeAddFile()"
            >
              Aceptar
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: ["id"],
  data() {
    return {
      type_file: [],
      ciudades: [],
      departament: [],
      sesion: {},
      data_record: {},
      documentos: [],
      index: 0,
    };
  },
  created() {
    axios.get(`/data-rercord/${this.id}/magistrados`).then((r) => {
      // axios.get('/data-rercord/26/magistrados').then((r) => {
      this.data_record = r.data.formulario;
      this.documentos = r.data.documentos;
    });
    axios.get("/data-select").then((r) => {
      this.tipo_documentos = r.data.tipo_documento;
      this.ciudades = r.data.ciudades;
      this.departament = r.data.departamentos;
      this.bancos = r.data.bancos;
      this.tipo_cuentas = r.data.tipo_cuentas;
      this.type_file = r.data.tipo_archivos;
      this.tipo_identificacion = r.data.tipo_identificacion;
    });
  },
  methods: {
    changeCity() {
      var id = $("#departamento_id").val();
      axios.post("/changeCity", { id: id }).then((r) => {
        this.ciudades = r.data;
      });
    },
  },
};
</script>





