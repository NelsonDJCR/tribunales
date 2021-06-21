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
            >Tribunales de Garantía / Listado de Actividades / Ver actividad
          </label>
        </li>
      </ol>
      <div class="row p-2 text-center border shadow rounded-3">
        <div class="row">
          <div class="col-12 col-md-12 col-lg-10 col-xl-10 p-2">
            <h2 class="text-blue"><b>VISUALIZACIÓN DE LA ACTIVIDAD</b></h2>
          </div>
          <div class="col-12 col-md-12 col-lg-2 col-xl-2 p-2">
          <button class="btn btn-warning text-white w-100 mt-2" @click="regresar">Cancelar</button>
          </div>
        </div>
      </div>

      <form @submit.prevent="save">
        <div class="row">
          <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-5">
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Fecha</b> </label>
                <div class="input-group">
                  <input
                    v-model="formulario.fecha"
                    type="date"
                    class="form-control"
                    disabled
                  />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Tema</b></label>
                <input
                  type="text"
                  class="form-control"
                  id=""
                  name=""
                  v-model="formulario.tema"
                  placeholder="Tema Ejemplo"
                  disabled
                />
              </div>
            </div>

            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Descripción</b></label>
                <textarea
                  class="form-control"
                  id=""
                  v-model="formulario.descripcion"
                  rows="5"
                  placeholder="Descripción ejemplo"
                  disabled
                ></textarea>
              </div>
            </div>

            <div class="row">
                <div class="mb-3">
                    <label for="" class="form-label">Tipo de actividad</label>
                    <select class="form-control" v-model="formulario.id_tipo_actividad" disabled>
                        <option value="">Seleccione</option>
                        <option v-for="(i,index) in tipo_actividad" :key="index" :value="i.id" v-text="i.nombre"></option>
                    </select>
                </div>
            </div>

          </div>

          <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-5">
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Departamento</b></label>
                <select
                  disabled
                  class="form-select"
                  name="dep_id"
                  id="dep_id"
                  v-model="formulario.dep_id"
                >
                  <option
                    v-for="(i, index) in departament"
                    :key="index"
                    v-text="i.nombre"
                    :value="i.id"
                  ></option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Ciudad</b> </label>
                <select
                  class="form-select"
                  name=""
                  v-model="formulario.ciu_id"
                  disabled
                >
                  <option
                    v-for="(i, index) in ciudades"
                    :key="index"
                    v-text="i.nombre"
                    :value="i.id"
                  ></option>
                </select>
              </div>
            </div>

            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Magistrado</b></label>
                <input
                  type="text"
                  class="form-control"
                  id=""
                  name=""
                  v-model="magistrado.magistrado"
                  placeholder="Nombre de Magistrado"
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
                              ></option>
                            </select>
                          </span>
                          <a
                            :href="i.ruta"
                            :download="i.ruta"
                            class="badge bg-info float-end text-end m-1"
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
      ciudades: [],
      departament: [],
      formulario: {},
      documentos: [],
      tipo_actividad: [],
      type_file: [],
      magistrado: "",
    };
  },
  created() {
    axios.get(`/data-rercord/${this.id}/actividades`).then((r) => {
      this.ciudades = r.data.ciudades;
      this.departament = r.data.departamentos;
      this.formulario = r.data.formulario;
      this.magistrado = r.data.magistrado;
      this.documentos = r.data.documentos
      this.type_file = r.data.tipo_archivos
      this.tipo_actividad = r.data.tipo_actividad
    });
  },
  methods: {
      regresar(){
          this.$emit('pantalla', 'lista')
      }
  }
};
</script>





