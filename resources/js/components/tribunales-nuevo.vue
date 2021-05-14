<template>
  <div id="form">
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0"
      crossorigin="anonymous"
    />

    <div class="container mt-5">
      <label for="" class="p-2"
        >Cabildos/Listado de cabildos/Nuevo tribunal
      </label>
      <div class="row p-2 text-center border shadow">
        <div class="row">
          <h1 class="text-blue"><b>NUEVO TRIBUNAL</b></h1>
        </div>
      </div>

      <form @submit.prevent="saveCourt">
        <div class="row">
          <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-5">
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Nombre *</b></label>
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
                <label for="" class="form-label"><b>Departamento *</b></label>
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
                <label for="" class="form-label"><b>Ciudad *</b></label>
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
                <label for="" class="form-label"
                  ><b>Fecha de inicio *</b>
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
                <label for="" class="form-label"
                  ><b>Fecha de final *</b>
                </label>
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
              <label for="" class="form-label"
                ><b>Estado *</b></label
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
            <div class="row">
              <label for="" class="form-label"
                ><b>Tipo de archivo *</b></label
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
           
            <div class="row mt-5">
              <div
                class="form-group files border"
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
            <div class="row mt-5">
              <button type="submit"  class="btn btn-primary">Crear tribunal</button>
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
    box_file(){
      $("#file").trigger('click')
    },
    changeCity() {
      var id = $("#departamento_id").val();
      axios.post("/changeCity", { id: id }).then((r) => {
        this.ciudades = r.data;
      });
    },
    saveCourt() {
      let form = new FormData
      axios.post('/saveCourt', form).then((res) => {
        console.log(res.data);
      });
    },
  },
};
</script>





