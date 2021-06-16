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
          <li class="breadcrumb-item active"><router-link :to="{ name: 'home'}"><span>Home</span></router-link> / <label for="" class="p-2">Funcionarios / Mis actividades / Ver actividad </label></li>
      </ol>
      <div class="row p-2 text-center border shadow rounded-3">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-10 col-xl-10 p-2">
                <h2 class="text-blue"><b>VISUALIZACIÓN DE LA ACTIVIDAD</b></h2>
            </div>
            <div class="col-12 col-md-12 col-lg-2 col-xl-2 p-2">
                <p @click="reload" class="btn btn-secondary active text-white w-100 mt-2">Volver al listado</p>
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
                    type="text"
                    class="form-control"
                    disabled
                    v-model="data.fecha"
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
                    disabled
                    v-model="data.tema"
                  />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Descripción</b></label>
                <textarea class="form-control" id="" rows="5" v-text="data.descripcion" disabled></textarea>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-5">
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Departamento</b></label>
                  <input
                    type="text"
                    class="form-control"
                    disabled
                    v-model="data.departamento"
                  />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"
                  ><b>Ciudad</b>
                </label>
                <input
                    type="text"
                    class="form-control"
                    disabled
                    v-model="data.ciudad"
                  />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Archivos</b></label>
                <div class="row">
                  <div class="btns-block d-grid gap-2">
                    <ul class="list-group btn-group-vertical">
                      <li class="list-group-item" v-for="(i,index) in documentos" :key="index">
                        <div class="btn btn-light btn-sm mt-2">
                          <span class="text-start float-start">
                            <select class="form-control text-dark bg-transparent" disabled style="outline: none;">
                                <option v-for="(item,index) in tipo_archivo" :key="index" :value="item.id" v-text="item.nombre"></option>
                            </select>
                          </span>
                          <span class="badge bg-info float-end text-end m-1"> <a class="" :href="i.ruta" :download="i.ruta"><i class="fa fa-download fa-md"></i></a></span>
                          <a class="text-end">
                            <span class="badge bg-primary badge-dot"></span>
                          </a>
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
  </div>
</template>
<script>
export default {
  props:['id'],
  data() {
    return {
      data:[],
      documentos:[],
      tipo_archivo: [],
    };
  },
  created() {
     axios.get(`/magistrado/mis-actividades-ver/${this.id}`).then((r) => {
      this.data = r.data.data;
      this.documentos = r.data.documentos
      this.tipo_archivo = r.data.tipo_archivo
    });
  },
  methods:{
    reload(){
      location.reload()
    }
  }

};
</script>





