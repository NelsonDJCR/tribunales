<template>
  <div>

    <template >
      <div class="main col-12">
        <link
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css"
          rel="stylesheet"
          integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0"
          crossorigin="anonymous"
        />
          <div class="container mt-5">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><router-link :to="{ name: 'home'}"><span>Home</span></router-link> / <label for="" class="p-2">Tribunales de Garantía / Informe de actividades </label></li>
            </ol>
            <div class="row p-2 text-center border shadow rounded-3">
              <div class="row">
                <div class="col-12 col-md-12">
                  <h1 class="text-blue"><b>INFORME DE ACTIVIDADES</b></h1>
                </div>
              </div>
            </div>
            <form @submit.prevent="filter">
              <div class="row mt-5">
                <div class="mb-3 col-3">
                  <label for="" class="form-label"><b>Tema</b></label>
                  <input
                    type="text"
                    class="form-control"
                    id="nombre_tema"
                    name="nombre_tema"
                    v-model="dataFilter.tema"
                  />
                </div>
                <div class="mb-3 col-3">
                  <label for="" class="form-label"><b>Magistrado</b></label>
                  <input
                    type="text"
                    class="form-control"
                    id=""
                    name=""
                    v-model="dataFilter.magistrado"
                  />
                </div>
                <div class="mb-3 col-3">
                  <label for="" class="form-label"><b>Fecha inicial</b></label>
                  <input
                    type="date"
                    class="form-control"
                    id="fecha_realizacion"
                    v-model="dataFilter.fecha_inicial"
                  />
                </div>
                <div class="mb-3 col-3">
                  <label for="" class="form-label"><b>Fecha final</b></label>
                  <input
                    type="date"
                    class="form-control"
                    id="fecha_realizacion"
                    v-model="dataFilter.fecha_final"
                  />
                </div>
                <div class="row">
                  <div class="mb-3 col-3">
                    <button
                      type="submit"
                      class="btn-secondary active btn w-80 btn_search w-100"
                    >
                      Buscar
                    </button>
                  </div>
                  <div class="mb-5 col-9"></div>
                </div>
              </div>
            </form>
          </div>
          <table class="table table-bordered table-striped table-sm" id="datos">
          <caption class="top">
              <div class="container">
                <div class="row align-items-start">
                  <div class="col">

                  </div>
                  <div class="col text-end">
                    <button @click="export_exel()" type="button" class="btn btn-labeled btn-primary">
                      <i class="fa fa-file-excel-o"></i></button>
                  </div>
                </div>
              </div>
            </caption>
            <thead>
              <th>Fecha</th>
              <th>Tema</th>
              <th>Descripción</th>
              <th>Departamento</th>
              <th>Ciudad</th>
              <th>Magistrado</th>
            </thead>
            <tbody>
              <tr v-for="(i, index) in tabla" :key="index" style="height:50px;">
                <td>{{ i.fecha }}</td>
                <td>{{ i.tema }}</td>
                <td>{{ i.descripcion }}</td>
                <td>{{ i.departamento }}</td>
                <td>{{ i.ciudad }}</td>
                <td>{{ i.magistrado }}</td>
              </tr>
            </tbody>
          </table>
      </div>
    </template>
  </div>
</template>

<script>
export default {
  data() {
    return {
      tabla: [],
      dataFilter: {},
    };
  },
  created() {
    axios.get('/listar/actividades').then((r) => {
      this.tabla = r.data.tabla;
    });
  },
  methods: {
    export_exel() {
      let url = "/excel-actividades";
      let filtros = this.dataFilter;
      axios.post(url, filtros).then((res) => {
        let blob = new Blob([res.data]);
        let link = document.createElement("a");
        link.href = window.URL.createObjectURL(blob);
        link.download = "ReporteCabildos.xls";
        link.click();
      });
    },
    filter(){
      axios.post('/filtros-actividad', this.dataFilter).then((r)=>{
        this.tabla = r.data.tabla;
      })
    },
  
  },
};
</script>

