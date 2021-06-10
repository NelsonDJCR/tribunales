<template>
  <div class="main col-12" id="form">
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
            >Tribunales de Garantía / Listado de Magistrados / Nuevo
          </label>
        </li>
      </ol>
      <div class="row p-2 text-center border shadow rounded-3">
        <div class="row">
          <div class="col-12 col-md-12 col-lg-10 col-xl-10 p-2">
            <h1 class="text-blue"><b>NUEVO MAGISTRADO</b></h1>
          </div>
          <div class="col-12 col-md-12 col-lg-2 col-xl-2 p-2">
            <router-link
              :to="`/tribunales-magistrados-listar`"
              @click.native="$router.go()"
              class="btn btn-danger text-white w-100 mt-2"
              >Cancelar</router-link
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
                  v-model="form.nombre"
                  maxlength="250"
                  name=""
                />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Cargo</b></label>
                <select class="form-select" name="" v-model="form.cargo">
                  <option>Seleccione ...</option>
                  <option value="Funcionario">Funcionario</option>
                  <option value="Magistrado">Magistrado</option>
                </select>
              </div>
            </div>
            <div class="row" v-if="form.cargo == 'Funcionario'">
              <div class="mb-3">
                <label for="" class="form-label"><b>Tribunal</b></label>
                <select class="form-select" name="" v-model="form.tribunal_id">
                  <option>Seleccione ...</option>
                  <option
                    v-for="(i, index) in tribunales"
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
                  type="number"
                  v-model="form.numero_identificacion"
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
                <label for="" class="form-label"><b>Ciudad</b></label>
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
                />
              </div>
            </div>

            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"
                  ><b>Correo Electrónico</b>
                </label>
                <input
                  v-model="form.correo"
                  type="email"
                  class="form-control"
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
                  />
                </div>
              </div>
            </div>
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
          </div>

          <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-5">
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Tipo de Cuenta</b></label>
                <select
                  class="form-select"
                  v-model="form.id_tipo_cuenta"
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
                  v-model="form.numero_cuenta"
                  type="number"
                  class="form-control"
                />
              </div>
            </div>

            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Tipo de archivo</b></label>
                <select
                  class="form-select"
                  name="type_file"
                  v-model="form.id_tipo_archivo"
                >
                  <option>Seleccione ...</option>
                  <option
                    v-for="(i, index) in tipo_archivos"
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
              @change="upload_file($event)"
              accept=".pdf,.png,.jpg"
            />

            <div class="row">
              <div class="mb-1">
                <label for="" class="form-label"><b>Archivos</b></label>
                <div class="row">
                  <div class="btns-block d-grid gap-2">
                    <ul class="list-group btn-group-vertical">
                      <li
                        class="list-group-item"
                        v-for="(i, index) in archivos"
                        :key="index"
                      >
                        <button class="btn btn-light btn-sm mt-2">
                          <span class="text-start float-start mt-1">{{
                            i.name
                          }}</span>
                          <button
                            class="badge bg-danger float-end text-end m-1"
                            @click="eliminar_archivo(index)"
                          >
                            <i class="fa fa-trash fa-md"></i>
                          </button>
                          <!-- <a href="#" class="badge bg-info float-end text-end m-1"><i class="fa fa-download fa-md"></i></a> -->
                        </button>
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
              <button type="submit" class="btn btn-success">
                Crear Magistrado
              </button>
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
  data() {
    return {
      type_file: [],
      ciudades: [],
      departament: [],
      archivo: {},
      archivos: [],
      tipo_archivo: [],
      tribunales: [],
      form: {
        cargo: "",
        ciu_id: "",
        correo: "",
        dep_id: "",
        direccion: "",
        id_banco: "",
        id_tipo_archivo: "",
        id_tipo_cuenta: "",
        id_tipo_identificacion: "",
        nombre: "",
        numero_cuenta: "",
        numero_identificacion: "",
        telefono: "",
        tribunal_id: "",
      },
      documentos: [],
      usados: [],
      index: 0,
    };
  },
  created() {
    axios.get("/data-select").then((r) => {
      this.tipo_documentos = r.data.tipo_documento;
      this.ciudades = r.data.ciudades;
      this.departament = r.data.departamentos;
      this.bancos = r.data.bancos;
      this.tipo_cuentas = r.data.tipo_cuentas;
      this.tipo_archivos = r.data.tipo_archivos;
      this.tipo_identificacion = r.data.tipo_identificacion;
      this.tribunales = r.data.tribunales;
    });
  },
  methods: {
    eliminar_archivo(index) {
      this.archivos.splice(index);
      this.tipo_archivo.splice(index);
    },
    upload_file(event) {
      for (let index = 0; index < this.tipo_archivo.length; index++) {
        if (this.tipo_archivo[index] == this.form.id_tipo_archivo) {
          Swal.fire(
            "¡Advertencia!",
            "Ya usaste este tipo de archivo",
            "warning"
          );
          return;
        }
      }
      this.archivo = event.target.files[0];
      this.archivos.push(this.archivo);
      this.tipo_archivo.push(this.form.id_tipo_archivo);
      this.form.id_tipo_archivo = "";
    //   console.log(this.archivos);
    },
    box_file() {
      if (this.form.id_tipo_archivo != "") {
        $("#file").trigger("click");
      } else {
        Swal.fire("¡Error!", "Selecciona un tipo de archivo", "error");
      }
    },
    changeCity() {
      var id = $("#departamento_id").val();
      axios.post("/changeCity", { id: id }).then((r) => {
        this.ciudades = r.data;
      });
    },
    save() {
      console.log(this.form);
      if (this.archivos.length == 0) {
        Swal.fire("¡Error!", "Carga por lo menos un archivo", "error");
        return;
      }
      // return
      var formulario = new FormData();
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
      formulario.append("cantidad", this.archivos.length);

      for (let index = 0; index < this.archivos.length; index++) {
        formulario.append("archivo" + index, this.archivos[index]);
      }
      for (let index = 0; index < this.tipo_archivo.length; index++) {
        formulario.append("tipo_archivo" + index, this.tipo_archivo[index]);
      }

      axios.post("/guardarMagistrados", formulario).then((res) => {
        console.log(res.data);
        if (res.data.code == 200) {
          Swal.fire("¡Perfecto!", res.data.msg, "success").then(function () {
            location.reload();
          });
        } else if (res.data.code == 406) {
          Swal.fire(
            res.data.msg,
            "Ingrese todos los campos para continuar",
            "warning"
          );
        }
      });
    },
  },
};
</script>





