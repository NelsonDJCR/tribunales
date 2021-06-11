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
            >Tribunales de Garantía / Listado de Magistrados / Editar
            Magistrado</label
          >
        </li>
      </ol>
      <div class="row p-2 text-center border shadow rounded-3">
        <div class="row">
          <div class="col-12 col-md-12 col-lg-10 col-xl-10 p-2">
            <h1 class="text-blue"><b>EDITAR MAGISTRADO</b></h1>
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

      <form @submit.prevent="edit">
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
                  v-model="form.nombre"
                  placeholder="Nombre de Magistrado"
                />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"
                  ><b>Tipo de Identificación</b></label
                >
                <select
                  class="form-select"
                  name=""
                  v-model="form.id_tipo_identificacion"
                >
                  <option>Seleccione ...</option>
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
                  v-model="form.numero_identificacion"
                  type="number"
                  class="form-control"
                  maxlength="15"
                  name=""
                />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Departamento</b></label>
                <select
                  class="form-select"
                  name="department"
                  v-model="form.dep_id"
                  id="departamento_id"
                  v-on:change="changeCity()"
                >
                  <option>Seleccione ...</option>
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
                <label for="" class="form-label"><b>Municipio</b></label>
                <select
                  class="form-select"
                  v-model="form.ciu_id"
                  name="municipality"
                  id="municipio"
                >
                  <option>Seleccione ...</option>
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
                  v-model="form.direccion"
                  type="text"
                  class="form-control"
                  maxlength="250"
                  name=""
                  placeholder="Dirección del Magistrado"
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
                  v-model="form.correo"
                  class="form-control"
                  placeholder="correo@correo.com"
                />
              </div>
            </div>

            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Teléfono</b> </label>
                <div class="input-group">
                  <input
                    v-model="form.telefono"
                    type="number"
                    class="form-control"
                    placeholder="123456789"
                  />
                </div>
              </div>
            </div>
          </div>

          <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-5">
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Banco</b></label>
                <select v-model="form.id_banco" class="form-select" name="">
                  <option>Seleccione ...</option>
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
                  v-model="form.id_tipo_cuenta"
                  class="form-select"
                  name=""
                >
                  <option>Seleccione ...</option>
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
                  v-model="form.numero_cuenta"
                  placeholder="123456789"
                />
              </div>
            </div>

            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Tipo de archivo</b></label>
                <select
                  class="form-select"
                  name="type_file"
                  v-model="form.id_tipo_documento"
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

            <div class="row mt-2" @click="box_file()">
              <div class="mb-3">
                <div
                  class="form-group files border opacity-2 opacity-2h"
                  role="button"
                  id="box_file"
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
                      <!-- <li class="list-group-item">
                        <button class="btn btn-light btn-sm mt-2">
                          <span class="text-start float-start mt-1">Nombre de Archivo 2</span>
                          <a href="#" class="badge bg-danger float-end text-end m-1"><i class="fa fa-trash fa-md"></i></a>
                          <a href="#" class="badge bg-info float-end text-end m-1"><i class="fa fa-download fa-md"></i></a>
                        </button>
                      </li> -->
                    </ul>
                  </div>
                </div>
              </div>
            </div>

            <div class="d-grid gap-2 col-6 mx-auto">
              <button type="submit" class="btn btn-secondary active">
                Guardar Magistrado
              </button>
              <router-link
                :to="`/tribunales-magistrados-listar`"
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
      form: {
        cargo: "",
        ciu_id: "",
        correo: "",
        dep_id: "",
        direccion: "",
        id_banco: "",
        id_tipo_documento: "",
        id_tipo_cuenta: "",
        id_tipo_identificacion: "",
        nombre: "",
        numero_cuenta: "",
        numero_identificacion: "",
        telefono: "",
        tribunal_id: "",
      },
      documentos: [],
      eliminados: [],
      tipo_archivos: [],
      tipo_documentos: [],
      tipo_identificacion: [],
      bancos: [],
      tipo_cuentas: [],
      index: 0,
    };
  },
  created() {
    axios.get(`/data-rercord/${this.id}/magistrados`).then((r) => {
    // axios.get(`/data-rercord/26/magistrados`).then((r) => {
      //   this.documentos = r.data.documentos;
      //   for (let index = 0; index < r.data.documentos.length; index++) {
      //       this.documentos.push(r.documentos[index])
      //   }
      this.documentos = r.data.documentos;
      console.log(this.documentos);
      this.type_file = r.data.tipo_archivo;
      this.ciudades = r.data.ciudades;
      this.departament = r.data.departamentos;
      this.form = r.data.formulario;
      this.bancos = r.data.bancos;
      this.tipo_cuentas = r.data.tipo_cuentas;
      this.tipo_archivos = r.data.tipo_archivos;
      this.tipo_identificacion = r.data.tipo_identificacion;
      for (let index = 0; index < this.documentos.length; index++) {
        this.tipo_documentos.push(this.documentos[index].id_tipo_documento);
      }
      this.form["id_tipo_documento"] = "";
    });
  },
  methods: {
    box_file() {
      if (this.form.id_tipo_documento == "") {
        Swal.fire("¡Error!", "Selecciona primero un tipo de archivo", "error");
      } else {
        $("#file").trigger("click");
      }
    },
    upload_file(event) {
      console.log(this.documentos);
      for (let index = 0; index < this.tipo_documentos.length; index++) {
        if (this.tipo_documentos[index] == this.form.id_tipo_documento) {
          Swal.fire(
            "¡Advertencia!",
            "Ya usaste este tipo de archivo",
            "warning"
          );
          return;
        }
      }
      if (this.form.id_tipo_documento == "") {
        Swal.fire("¡Error!", "Selecciona primero un tipo de archivo", "error");
      } else {
        let archivo = event.target.files[0];
        archivo["id_tipo_documento"] = this.form.id_tipo_documento;
        archivo["id"] = 0;
        this.documentos.push(archivo);
        this.tipo_documentos.push(this.form.id_tipo_documento);
        this.form.id_tipo_documento = "";
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
    edit() {
      if (this.documentos.length == 0) {
        Swal.fire("¡Error!", "Carga por lo menos un archivo", "error");
        return;
      }
      var formulario = new FormData();
    //   formulario.append('id', 26)
      formulario.append('id', this.id)
      formulario.append("cargo", this.form.cargo);
      formulario.append("ciu_id", this.form.ciu_id);
      formulario.append("correo", this.form.correo);
      formulario.append("dep_id", this.form.dep_id);
      formulario.append("direccion", this.form.direccion);
      formulario.append("id_banco", this.form.id_banco);
      formulario.append("id_tipo_cuenta", this.form.id_tipo_cuenta);
      formulario.append(
        "id_tipo_identificacion",
        this.form.id_tipo_identificacion
      );
      formulario.append("nombre", this.form.nombre);
      formulario.append("numero_cuenta", this.form.numero_cuenta);
      formulario.append(
        "numero_identificacion",
        this.form.numero_identificacion
      );
      formulario.append("telefono", this.form.telefono);
      formulario.append("tribunal_id", this.form.tribunal_id);
      formulario.append("cantidad", this.documentos.length);
      formulario.append('cantidad_eliminados', this.eliminados.length)

      for (let index = 0; index < this.documentos.length; index++) {
        formulario.append("archivo" + index, this.documentos[index]);
      }
      for (let index = 0; index < this.tipo_documentos.length; index++) {
        formulario.append("tipo_archivo" + index, this.tipo_documentos[index]);
      }

      for (let index = 0; index < this.eliminados.length; index++) {
        formulario.append("e_id" + index, this.eliminados[index]);
      }

      axios.post("/editar-magistrado", formulario).then((res) => {
        if (res.data.status == 200) {
          Swal.fire("¡Perfecto!", res.data.msg, "success").then(function () {
            location.reload();
          });
        } else if (res.data.status == 406) {
          Swal.fire("¡Error!", res.data.msg, "error");
        }
      });
    },
    changeCity() {
      var id = $("#departamento_id").val();
      axios.post("/changeCity", { id: id }).then((r) => {
        this.ciudades = r.data;
      });
    },
  },
};
</script>





