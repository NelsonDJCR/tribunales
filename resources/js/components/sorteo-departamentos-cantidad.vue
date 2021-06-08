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
          <li class="breadcrumb-item active"><router-link :to="{ name: 'home'}"><span>Home</span></router-link> / <label for="" class="p-2">Tribunales de Garantía / Listado de Actividades / Nueva actividad </label></li>
      </ol>
      <div class="row p-2 text-center border shadow rounded-3">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-10 col-xl-10 p-2">
                <h1 class="text-blue"><b>NUEVA ACTIVIDAD</b></h1>
            </div>
            <div class="col-12 col-md-12 col-lg-2 col-xl-2 p-2">
                <router-link :to='`/tribunales/listado-de-actividades`' @click.native="$router.go()" class="btn btn-danger text-white w-100 mt-2">Cancelar</router-link>
            </div>
        </div>
      </div>

      <form @submit.prevent="save">
        <div class="row">
          <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-5">
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"
                  ><b>Fecha</b>
                </label>
                <div class="input-group">
                  <input
                    v-model="form.fecha"
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
                    :maxlength="150"
                    v-model="form.tema"
                  />
              </div>
            </div>


            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Descripción</b></label>
                <textarea v-model="form.descripcion" class="form-control" :maxlength="501" id="" rows="3"></textarea>
                    
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Departamento</b></label>
                  <select
                  
                    v-on:change="changeCity()"
                    v-model="form.dep_id"
                    class="form-select"
                    name="dep_id"
                    id="departamento_id"
                  >
                    <option value="">Selecciona</option>
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
                <label for="" class="form-label"
                  ><b>Ciudad</b>
                </label>
                <select
                    v-model="form.ciu_id"
                    class="form-select"
                    name="dep_id"
                    id="dep_id"
                  >
                    <option value="">Selecciona</option>
                    <option
                      v-for="(i, index) in ciudades"
                      :key="index"
                      v-text="i.nombre"
                      :value="i.id"
                    ></option>
                  </select>
              </div>
            </div>
          </div>

          <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-5">



            
            <div class="row" v-if="origen == 'actividades'">
              <div class="mb-3">
                <label for="" class="form-label"><b>Magistrado</b></label>
                  <select
                    v-model="form.id_magistrado"
                    class="form-select"
                    name="dep_id"
                    id="dep_id"
                  >
                    <option value="">Selecciona</option>
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
                <label for="" class="form-label"><b>Tribunal</b></label>
                  <select
                    v-model="form.tribunal_id"
                    class="form-select"
                  >
                    <option value="">Selecciona</option>
                    <option
                      v-for="(i, index) in tribunales"
                      :key="index"
                      v-text="i.nombre"
                      :value="i.id"
                    ></option>
                  </select>
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"
                  ><b>Tipo de archivo *</b></label
                >
                <select
                  class="form-select"
                  name="type_file"
                  v-model="form.id_tipo_archivo"
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
            <div class="row mt-5">
              <div
                class="form-group files border opacity-2 opacity-2h"
                role="button"
                id="box_file"
                @click="openModalFile()"
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
            <input type="hidden" v-model="form.token">
            <div class="d-grid gap-2 col-6 mx-auto">
                <button type="submit"  class="btn btn-primary">Crear Actividad</button>
            </div>
          </div>
        </div>
      </form>
    </div>


  </div>
</template>



<script>

export default {
  props:['id'],
  data() {
    return {
      type_file: [],
      ciudades: [],
      departament: [],
      tribunales: [],
      magistrados: [],
      form: {},
      documentos: [],
      origen: '',
      index: 0,
    };
  },
  created() {
    if(this.id){
      this.origen = 'magistrado'
    }else{
      this.origen = 'actividades'
    }    
    axios.get("/data-select").then((r) => {
      this.ciudades = r.data.ciudades;
      this.departament = r.data.departamentos;
      this.type_file = r.data.tipo_archivos;
      this.magistrados = r.data.magistrados;
      this.tribunales = r.data.tribunales;
    });
    this.form.token = Math.floor(Math.random() * (9999 - 5000)) + 5000
  },
  methods: {
   
    changeCity() {
      var id = $("#departamento_id").val();
      console.log(id);
      axios.post("/changeCity", { id: id }).then((r) => {
        this.ciudades = r.data;
      });
    },
    save() {
      axios.post('/guardar-actividad', this.form).then((r) => {
          if (r.data.code == 200) {
            Swal.fire('¡Perfecto!','Datos guardados exitosamente','success').then(function(){ location.reload() });
          }else if(r.data.code == 406){
            Swal.fire(r.data.msg,'Ingrese todos los datos para continuar','warning')
          }
      });
    },
  },
};
</script>





