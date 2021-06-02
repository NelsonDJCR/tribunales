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
          <li class="breadcrumb-item active"><router-link :to="{ name: 'home'}"><span>Home</span></router-link> / <label for="" class="p-2">Tribunales de Garantía / Listado de Tribunales / Editar tribunal </label></li>
      </ol>
      <div class="row p-2 text-center border shadow rounded-3">
        <div class="row">
          <h1 class="text-blue" ><b>VER TRIBUNAL</b></h1>
        </div>
      </div>
      <form >
        <div class="row">
          <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-5">
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Nombre</b></label>
                <input

                  type="text"
                  class="form-control"
                  v-model="data_record.nombre"
                  maxlength="250"
                  name="theme"
                  disabled
                  placeholder=""
                />
              </div>
            </div>
             <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Departamento</b></label>
                <select
                  class="form-select"
                  name="department"
                  v-model="data_record.dep_id"
                  id="departamento_id"
                  v-on:change="changeCity()"
                  disabled
                >
                  <option disabled>Seleccione ...</option>
                  <option
                    v-for="(i, index) in departament"
                    :key="index"
                    :value="i.id"
                  >
                    {{ i.nombre }}
                  </option>
                </select>
                
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Ciudad</b></label>
                <select
                  class="form-select"
                  v-model="data_record.ciu_id"
                  name="municipality"
                  id="municipio"
                  disabled
                >
                  <option disabled>Seleccione ...</option>
                  <option
                    v-for="(i, index) in ciudades"
                    :key="index"
                    :value="i.id"
                  >
                    {{ i.nombre }}
                  </option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Dirección</b></label>
                <input
                disabled
                  type="text"
                  class="form-control"
                  maxlength="250"
                   v-model="data_record.direccion"
                  name="theme"
                  placeholder=""
                />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"
                  ><b>Fecha de inicio</b>
                </label>
                <div class="input-group">
                  <input
                  disabled
                    v-model="data_record.fecha_inicio"
                    type="date"
                    class="form-control"
                  />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Fecha fin estimada</b></label>
                <div class="input-group">
                  <input
                  disabled
                    v-model="data_record.fecha_final"
                    type="date"
                    class="form-control"
                  />
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-5">
            <div class="row">
                <div class="mb-3">
                    <label for="" class="form-label"
                        ><b>Tipo de archivo</b></label
                    >
                    <select
                        class="form-select"
                        name="type_file"
                        v-model="data_record.tipo_archivo"
                    >
                        <option
                        v-for="(i, index) in type_file"
                        :key="index"
                        :value="i.id"
                        v-text="i.nombre"
                        ></option>
                    </select>
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
  props: ['id'],
  data() {
    return {
      type_file: [],
      ciudades: [],
      departament: [],
      data_record: {},
      data: {},
      documentos: [],
      index: 0,
    };
  },
  created() {
    axios.get(`/data-rercord/${this.id}/tribunal`).then((r) => {
      this.data_record = r.data.formulario;
      this.departament = r.data.departamentos;
      this.ciudades = r.data.ciudades;
      this.type_file = r.data.tipo_archivos;
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





