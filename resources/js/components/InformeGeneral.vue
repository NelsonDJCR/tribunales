<template>
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
        <li class="breadcrumb-item active">
          <router-link :to="{ name: 'home' }"><span>Home</span></router-link>
          /
          <label for="" class="p-2"
            >Tribunales de Garantía / Listado de actividades
          </label>
        </li>
      </ol>
      <div class="row p-2 text-center border shadow rounded-3">
        <div class="row">
          <div class="col-12 col-md-12 col-lg-12 col-xl-12 p-2">
            <h1 class="text-blue"><b>INFORME GENERAL</b></h1>
          </div>
        </div>
      </div>
      <form>
        <div class="row mt-5">
          <div class="mb-3 col-3">
            <label for="" class="form-label"><b>Tribunal</b></label>
            <select class="form-select" v-model="filtros.tribunal">
              <option value="">Seleccione</option>
              <option
                v-for="(i, index) in tribunales"
                :key="index"
                :value="i.id"
                v-text="i.nombre"
              ></option>
            </select>
          </div>
          <div class="mb-3 col-3">
            <label for="" class="form-label"><b>Magistrado</b></label>
            <select class="form-select" v-model="filtros.magistrado">
              <option value="">Seleccione</option>
              <option
                v-for="(i, index) in magistristrados"
                :key="index"
                :value="i.id"
                v-text="i.nombre"
              ></option>
            </select>
          </div>
          <div class="mb-3 col-3">
            <label for="" class="form-label"><b>Departamento</b></label>
            <select class="form-select" v-model="filtros.departamento">
              <option value="">Seleccione</option>
              <option
                v-for="(i, index) in departamentos"
                :key="index"
                :value="i.id"
                v-text="i.nombre"
              ></option>
            </select>
          </div>
          <div class="mb-3 col-3">
            <label for="" class="form-label"><b>Ciudad</b></label>
            <select class="form-select" v-model="filtros.ciudad">
              <option value="">Seleccione</option>
              <option
                v-for="(i, index) in ciudades"
                :key="index"
                :value="i.id"
                v-text="i.nombre"
              ></option>
            </select>
          </div>
          <div class="row">
            <div class="mb-3 col-3">
              <button
                type="button"
                class="btn-secondary active btn w-80 btn_search w-100"
                @click="filtrar"
              >
                Buscar
              </button>
            </div>
            <div class="mb-5 col-9"></div>
          </div>
        </div>
        <div class="row justify-content-end mb-3">
          <div class="col-11"></div>
          <div class="col-1">
            <button class="btn btn-success" @click="informe_excel">
              <i class="fa fa-file-excel-o"></i>
            </button>
          </div>
        </div>
      </form>
    </div>

    <div class="container">
      <table class="w-100 table-bordered">
        <thead>
          <tr>
            <th>Tribunal</th>
            <th>Magistrado</th>
            <th>Departamento</th>
            <th>Municipio</th>
            <th>Correo electrónico</th>
            <th>Teléfono</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(i, index) in tabla" :key="index">
            <td class="p-2">{{ i.nom_tribunal }}</td>
            <td>{{ i.nombre }}</td>
            <td>{{ i.dep_nombre }}</td>
            <td>{{ i.ciu_nombre }}</td>
            <td>{{ i.correo }}</td>
            <td>{{ i.telefono }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      tabla: [],
      departamentos: [],
      ciudades: [],
      magistristrados: [],
      tribunales: [],
      filtros: { tribunal: "", magistrado: "", departamento: "", ciudad: "" },
    };
  },
  created() {
    let url = "/tabla_informe_general";
    axios.post(url).then((res) => {
      this.tabla = res.data.tabla;
      this.departamentos = res.data.departamentos;
      this.ciudades = res.data.ciudades;
      this.magistristrados = res.data.magistristrados;
      this.tribunales = res.data.tribunales;
      //   console.log(this.tabla);
    });
  },
  methods: {
    filtrar() {
      let url = "/informe_general";
      axios.post(url, this.filtros).then((res) => {
        this.tabla = res.data.tabla;
      });
    },
    informe_excel() {
      let url = "/informe_general_descargar";
      let filtros = this.filtros;
      axios.post(url, filtros).then((res) => {
        let blob = new Blob([res.data]);
        let link = document.createElement("a");
        link.href = window.URL.createObjectURL(blob);
        link.download = "Reporte_general.xls";
        link.click();
      });
    },
  },
};
</script>
