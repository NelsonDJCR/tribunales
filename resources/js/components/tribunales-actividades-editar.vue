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
            >Tribunales de Garantía / Listado de Actividades / Editar actividad
          </label>
        </li>
      </ol>
      <div class="row p-2 text-center border shadow rounded-3">
        <div class="row">
          <h1 class="text-blue"><b>EDITAR ACTIVIDAD</b></h1>
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
                ></textarea>
              </div>
            </div>

            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"
                  ><b>Tipo de actividad</b>
                </label>
                <select
                  v-model="formulario.id_tipo_actividad"
                  class="form-select"
                  name="dep_id"
                  id="dep_id"
                >
                  <option value="">Selecciona</option>
                  <option
                    v-for="(i, index) in tipo_actividad"
                    :key="index"
                    v-text="i.nombre"
                    :value="i.id"
                  ></option>
                </select>
              </div>
            </div>
          </div>

          <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-5">
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Departamento</b></label>
                <select
                  v-on:change="changeCity()"
                  class="form-select"
                  name="dep_id"
                  id="departamento_id"
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
                <label for="" class="form-label"><b>Ciudades</b> </label>
                <select
                  class="form-select"
                  name=""
                  id=""
                  v-model="formulario.ciu_id"
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
            <input type="hidden" v-model="formulario.id" />

            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Magistrado</b></label>
                <select
                  v-model="formulario.id_magistrado"
                  class="form-select"
                  name="dep_id"
                  id="dep_id"
                >
                  <option
                    v-for="(i, index) in magistrados"
                    :key="index"
                    v-text="i.nombre"
                    :value="i.id"
                  ></option>
                </select>
              </div>
            </div>

            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Tipo de archivo</b></label>
                <select
                  v-model="formulario.id_tipo_documento"
                  class="form-select"
                  name="dep_id"
                  id="dep_id"
                >
                  <option
                    v-for="(i, index) in type_file"
                    :key="index"
                    v-text="i.nombre"
                    :value="i.id"
                  ></option>
                </select>
              </div>
            </div>

            <div class="row mt-5">
              <div
                class="form-group files border opacity-2 opacity-2h"
                role="button"
                id="box_file"
                @click="box_file"
              >
                <div class="row mt-5">
                  <img
                    class="img_file mx-auto d-block"
                    alt=""
                    style="width: 100px"
                    src="https://img.icons8.com/ios/452/google-docs.png"
                  />
                </div>
                <div class="row mt-1 mb-5">
                  <p class="text_file text-center">
                    Ingresa aquí tus documentos .pdf .png .jpg
                  </p>
                </div>
              </div>
            </div>

            <input
              type="file"
              id="file"
              class="d-none"
              accept=".pdf, .png, .jpg"
              @change="upload_file($event)"
            />
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
                          <button
                            type="button"
                            @click="eliminar_archivo(index)"
                            class="badge bg-danger float-end text-end m-1"
                          >
                            <i class="fa fa-trash fa-md"></i>
                          </button>
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
            <div class="d-grid gap-2 col-6 mx-auto">
              <button type="submit" class="btn btn-primary">Guardar</button>
              <router-link
                :to="`/tribunales/listado-de-actividades`"
                @click.native="$router.go()"
                class="btn btn-danger text-white w-100 mt-2"
                >Cancelar</router-link
              >
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
      type_file: [],
      ciudades: [],
      departament: [],
      magistrados: [],
      formulario: {},
      documentos: [],
      eliminados: [],
      tipo_documentos: [],
      tipo_actividad: [],
      index: 0,
    };
  },
  created() {
    axios.get(`/data-rercord/${this.id}/actividades`).then((r) => {
      // axios.get(`/data-rercord/7/actividades`).then((r) => {
      this.ciudades = r.data.ciudades;
      this.type_file = r.data.tipo_archivo;
      this.departament = r.data.departamentos;
      this.documentos = r.data.documentos;
      this.formulario = r.data.formulario;
      this.tipo_actividad = r.data.tipo_actividad
      for (let index = 0; index < this.documentos.length; index++) {
        this.tipo_documentos.push(this.documentos[index].id_tipo_documento);
      }
      this.formulario["id_tipo_documento"] = "";
    });
    axios.get("/data-select").then((r) => {
      this.magistrados = r.data.magistrados;
    });
  },
  methods: {
    save() {
      let formulario = new FormData();
      formulario.append("id", this.id);
      //   formulario.append('id', id)
      formulario.append("ciu_id", this.formulario.ciu_id);
      formulario.append("dep_id", this.formulario.dep_id);
      formulario.append("descripcion", this.formulario.descripcion);
      formulario.append("fecha", this.formulario.fecha);
      formulario.append("id_magistrado", this.formulario.id_magistrado);
      formulario.append("tema", this.formulario.tema);
      formulario.append("tribunal_id", this.formulario.tribunal_id);
      formulario.append("cantidad", this.documentos.length);
      formulario.append("cantidad_eliminados", this.eliminados.length);

      for (let index = 0; index < this.documentos.length; index++) {
        formulario.append("archivo" + index, this.documentos[index]);
      }

      for (let index = 0; index < this.tipo_documentos.length; index++) {
        formulario.append("tipo_archivo" + index, this.tipo_documentos[index]);
      }

      for (let index = 0; index < this.eliminados.length; index++) {
        formulario.append("e_id" + index, this.eliminados[index]);
      }

      axios.post("/editar-actividad", formulario).then((r) => {
        if (r.data.code == 200) {
          Swal.fire(
            "¡Perfecto!",
            "Datos actualizados correctamente",
            "success"
          ).then(function () {
            location.reload();
          });
        }
      });
    },
    changeCity() {
      var id = $("#departamento_id").val();
      axios.post("/changeCity", { id: id }).then((r) => {
        this.ciudades = r.data;
      });
    },
    box_file() {
      if (this.formulario.id_tipo_documento == "") {
        Swal.fire("¡Error!", "Selecciona primero un tipo de archivo", "error");
      } else {
        $("#file").trigger("click");
      }
    },
    eliminar_archivo(index) {
      // console.log(this.documentos[0])
      if (this.documentos[index].id != 0) {
        //   console.log(this.documentos[index]);
        this.eliminados.push(this.documentos[index].id);
      }
      this.documentos.splice(index, 1);
      this.tipo_documentos.splice(index, 1);
      //   console.log(this.eliminados);
    },
    upload_file(event) {
      //   console.log(this.documentos);
      for (let index = 0; index < this.tipo_documentos.length; index++) {
        if (this.tipo_documentos[index] == this.formulario.id_tipo_documento) {
          Swal.fire(
            "¡Advertencia!",
            "Ya usaste este tipo de archivo",
            "warning"
          );
          return;
        }
      }
      if (this.formulario.id_tipo_documento == "") {
        Swal.fire("¡Error!", "Selecciona primero un tipo de archivo", "error");
      } else {
        let archivo = event.target.files[0];
        archivo["id_tipo_documento"] = this.formulario.id_tipo_documento;
        archivo["id"] = 0;
        this.documentos.push(archivo);
        this.tipo_documentos.push(this.formulario.id_tipo_documento);
        this.formulario.id_tipo_documento = "";
      }
    },
  },
};
</script>





