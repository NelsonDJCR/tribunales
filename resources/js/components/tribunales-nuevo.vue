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
            >Tribunales de Garantía / Listado de Tribunales / Nuevo
          </label>
        </li>
      </ol>
      <div class="row p-2 text-center border shadow rounded-3">
        <div class="row">
          <div class="col-12 col-md-12 col-lg-10 col-xl-10 p-2">
            <h1 class="text-blue"><b>NUEVO TRIBUNAL</b></h1>
          </div>
          <div class="col-12 col-md-12 col-lg-2 col-xl-2 p-2">
            <button
              class="btn btn-danger text-white w-100 mt-2"
              @click="regresar"
              >Cancelar</button>
          </div>
        </div>
      </div>

      <form @submit.prevent="save" enctype="multipart/form-data">
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
                  name="theme"
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
                  <option disabled>Seleccione ...</option>
                  <option
                    v-for="(i, index) in departamentos"
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
                  type="text"
                  class="form-control"
                  v-model="form.direccion"
                  maxlength="250"
                  name="theme"
                />
              </div>
            </div>

            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Fecha de inicio</b> </label>
                <div class="input-group">
                  <input
                    v-model="form.fecha_inicio"
                    type="date"
                    class="form-control"
                  />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"
                  ><b>Fecha fin estimada</b></label
                >
                <div class="input-group">
                  <input
                    v-model="form.fecha_final"
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
                <label for="" class="form-label"><b>Tipo de archivo</b></label>
                <select
                  class="form-select"
                  name="type_file"
                  v-model="form.tipo_archivo"
                >
                  <option value="">Seleccione</option>
                  <option
                    v-for="(i, index) in tipo_documento"
                    :key="index"
                    :value="i.id"
                    v-text="i.nombre"
                  ></option>
                </select>
              </div>
            </div>

            <div class="row mt-5">
              <div
                class="form-group files border opacity-2 opacity-2h"
                role="button"
                id="box_file"
                @click="box_file()"
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
              class="d-none"
              accept=".pdf, .png, .jpg"
              @change="subirArchivo($event)"
              id="file"
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
                        <div class="btn btn-light btn-sm mt-2">
                          <span class="text-start float-start mt-1">
                            <select class="form-control bg-transparent text-dark" disabled v-model="i.id_tipo_documento">
                                <option v-for="(item,index) in tipo_documentos" :key="index" :value="item.id" v-text="item.nombre"></option>
                            </select>
                          </span>
                          <button
                            href="#"
                            @click="eliminarArchivo(index)"
                            class="badge bg-danger float-end text-end m-1"
                          >
                            <i class="fa fa-trash fa-md"></i>
                          </button>
                        </div>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <div class="d-grid gap-2 col-6 mx-auto">
              <button type="submit" class="btn btn-success">
                Crear Tribunal
              </button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      tipo_documento: [],
      ciudades: [],
      departamentos: [],
      estado: [],
      tipo_archivo: [],
      tipo_documentos: [],
      form: { tipo_archivo: "" },
      documentos: [],
      archivos: [],
      index: 0,
    };
  },
  created() {
    axios.get("/data-select").then((r) => {
        console.log(r.data);
      this.tipo_documento = r.data.tipo_documento;
      this.ciudades = r.data.municipios;
      this.departamentos = r.data.departamentos;
      this.tipo_documentos = r.data.tipo_archivos
      this.estado = r.data.estado;
    });
    this.form.token = Math.floor(Math.random() * (9999 - 5000)) + 5000;
  },
  methods: {
      regresar(){
          this.$emit('pantalla', 'lista')
      },
    eliminarArchivo(index) {
      this.archivos.splice(index, 1);
      this.tipo_archivo.splice(index, 1);
    },
    subirArchivo(event) {
      for (let index = 0; index < this.tipo_archivo.length; index++) {
        if (this.tipo_archivo[index] == this.form.tipo_archivo) {
          Swal.fire(
            "¡Advertencia!",
            "Ya usaste este tipo de archivo",
            "warning"
          );
          return;
        }
      }
      let archivo = event.target.files[0];
      archivo["id_tipo_documento"] = this.form.tipo_archivo;
      this.archivos.push(archivo);
      this.tipo_archivo.push(this.form.tipo_archivo);
      this.form.tipo_archivo = "";
    },
    box_file() {
      if (this.form.tipo_archivo != "") {
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
      var datos = new FormData();
      datos.append("nombre", this.form.nombre);
      datos.append("direccion", this.form.direccion);
      datos.append("dep_id", this.form.dep_id);
      datos.append("ciu_id", this.form.ciu_id);
      datos.append("fecha_inicio", this.form.fecha_inicio);
      datos.append("fecha_final", this.form.fecha_final);
      datos.append("cantidad", this.archivos.length);

      for (let index = 0; index < this.tipo_archivo.length; index++) {
          datos.append('tipo_archivo'+index, this.tipo_archivo[index])
      }

      for (let i = 0; i < this.archivos.length; i++) {
        datos.append("archivos" + i, this.archivos[i]);
      }
      axios.post("/guardarTribunal", datos).then((res) => {
        if (res.data.status == 200) {
          Swal.fire("Perfecto!", res.data.msg, "success").then(function () {
            location.reload();
          });
        } else if (res.data.status == 406) {
          Swal.fire(
            res.data.msg,
            "Complete todos los campos de forma correcta",
            "warning"
          );
        } else {
          Swal.fire("¡Error!", res.data.msg, "error");
        }
      });
    },
  },
};
</script>





