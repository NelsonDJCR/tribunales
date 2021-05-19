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
          <li class="breadcrumb-item active"><router-link :to="{ name: 'home'}"><span>Home</span></router-link> / <label for="" class="p-2">Tribunales de Garantía / Listado de Tribunales / Nuevo </label></li>
      </ol>
      <div class="row p-2 text-center border shadow rounded-3">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-10 col-xl-10 p-2">
                <h1 class="text-blue"><b>NUEVO TRIBUNAL</b></h1>
            </div>
            <div class="col-12 col-md-12 col-lg-2 col-xl-2 p-2">
                <router-link :to='`/tribunales-listar`' @click.native="$router.go()" class="btn btn-danger text-white w-100 mt-2">Cancelar</router-link>
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
                  name="theme"
                />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Dirección *</b></label>
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
                <label for="" class="form-label"><b>Municipio</b></label>
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
                  v-model="form.nombre"
                  maxlength="250"
                  name="theme"
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
                    v-model="form.fecha_inicio"
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
                    <label for="" class="form-label"
                        ><b>Estado</b></label
                    >
                    <select
                        class="form-select"
                        name="type_file"
                        v-model="form.estado"
                    >
                        <option
                        v-for="(i, index) in estado"
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
                        ><b>Tipo de archivo</b></label
                    >
                    <select
                        class="form-select"
                        name="type_file"
                        v-model="form.type_file"
                    >
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
            <input type="file" class="d-none" @change="archivo($event)" id="file">
            <div class="d-grid gap-2 col-6 mx-auto">
              <button type="submit"  class="btn btn-success">Crear Tribunal</button>
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
      form: {},
      documentos: [],
      index: 0,
    };
  },
  created() {
    axios.get("/departament-city").then((r) => {
      this.tipo_documento = r.data.tipo_documento;
      this.ciudades = r.data.municipios;
      this.departamentos = r.data.departamentos;
      this.estado = r.data.estado;
    });
  },
  methods: {
    archivo(event){
      this.archivo = event.file[0]

    },
    uploadFile(event) {
      this.archivo = event.target.files[0];
    },
    box_file() {
      $("#file").trigger("click");
    },
    changeCity() {
      var id = $("#departamento_id").val();
      axios.post("/changeCity", { id: id }).then((r) => {
        this.ciudades = r.data;
      });
    },
    save() {
      var datos = new FormData();
      datos.append("archivo", this.archivo);
      datos.append("nombre", this.form.nombre);
      datos.append("direccion", this.form.direccion);
      datos.append("dep_id", this.form.dep_id);
      datos.append("ciu_id", this.form.ciu_id);
      datos.append("tipo_archivo", this.form.tipo_archivo);
      datos.append("fecha_inicio", this.form.fecha_inicio);
      datos.append("fecha_final", this.form.fecha_final);
      axios.post("/guardarTribunal", datos).then((res) => {
        if (res.data.code == 200) {
          Swal.fire("¡Perfecto!", res.data.msg, "success").then(function () {
            location.reload();
          });
        }
      });
    },
  },
};
</script>





