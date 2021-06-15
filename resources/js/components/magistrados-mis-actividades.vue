<template>
  <div>
    <template v-if="pantalla == 'lista'">
      <div class="main col-12">
        <link
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css"
          rel="stylesheet"
          integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0"
          crossorigin="anonymous"
        />
        <!-- <template v-if="action == 0"> -->
        <div class="container mt-5">
          <!-- Breadcrumb -->
          <ol class="breadcrumb">
            <li class="breadcrumb-item active">
              <router-link :to="{ name: 'home' }"
                ><span>Home</span></router-link
              >
              / <label for="" class="p-2">Magistrados / Mis actividades </label>
            </li>
          </ol>
          <div class="row p-2 text-center border shadow rounded-3">
            <div class="row">
              <div class="col-12 col-md-12 col-lg-10 col-xl-10 p-2">
                <h1 class="text-blue"><b>Mis actividades</b></h1>
              </div>
              <div class="col-12 col-md-12 col-lg-2 col-xl-2 p-2">
                <button
                  @click="pantallaNuevo(3)"
                  class="btn btn-warning text-white w-100 mt-2"
                >
                  Nueva actividad
                </button>
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

              <div class="mb-3 col-3">
                <div class="row">
                  <div class="mb-12 col-12 mt-4">
                    <button
                      type="submit"
                      class="btn btn-secondary active btn_search w-100 mt-2"
                    >
                      Buscar
                    </button>
                  </div>
                  <div class="mb-5 col-9"></div>
                </div>
              </div>

              <div class="mb-3 col-3"></div>
            </div>
          </form>
        </div>
        <div class="justify-content-end d-flex mb-3">
          <button class="btn btn-danger" @click="informe_PDF">
            <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
          </button>
        </div>
        <table class="table table-bordered table-sm" id="datos">
          <thead>
            <th>Opciones</th>
            <th>Fecha</th>
            <th>Tema</th>
            <th class="w-25">Descripcion</th>
            <th>Departamento</th>
            <th>Ciudad</th>
          </thead>
          <tbody>
            <!--  -->
            <tr v-for="(i, index) in tabla" :key="index">
              <td class="aling_btn_options">
                <button
                  type="button"
                  class="btn btn-success btn-sm"
                  @click="ver(i.id)"
                >
                  <i class="typcn typcn-eye"></i>
                </button>
              </td>
              <td>{{ i.fecha }}</td>
              <td>{{ i.tema }}</td>
              <td class="w-25">{{ i.descripcion }}</td>
              <td>{{ i.departamento }}</td>
              <td>{{ i.ciudad }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </template>

    <template v-if="pantalla == 'ver'">
      <div>
        <magistrados-mis-actividades-ver
          :id="id_record"
        ></magistrados-mis-actividades-ver>
      </div>
    </template>

    <template v-if="pantalla == 'nuevo'">
      <div>
        <tribunales-actividades-nuevo
          :id="id_magistrado"
        ></tribunales-actividades-nuevo>
      </div>
    </template>
  </div>
</template>

<script>
export default {
  data() {
    return {
      tabla: [],
      dataFilter: { fecha_inicial: "", fecha_final: "" },
      fechas: { min_fecha: "", max_fecha: "" },
      pantalla: "lista",
      id_record: 0,
      id_magistrado: 0,
    };
  },
  created() {
    axios.get("/magistrado/mis-actividades").then((r) => {
      this.tabla = r.data.table;
      this.formatear_fecha()
      this.fechas.min_fecha = r.data.minimo;
      this.fechas.max_fecha = r.data.maximo;
    });
  },
  methods: {
    formatear_fecha() {
      var fecha = "";
      var array = [];
      var fecha_format = "";

      for (let index = 0; index < this.tabla.length; index++) {
        fecha = this.tabla[index].fecha;
        array = fecha.split("-");
        fecha_format = array[2] + "-" + array[1] + "-" + array[0];
        this.tabla[index].fecha = fecha_format;
      }
    },
    ver(id) {
      this.id_record = id;
      this.pantalla = "ver";
    },
    filter() {
      axios.post("/filtros-mis-actividades", this.dataFilter).then((r) => {
        this.tabla = r.data.tabla;
        this.fechas.min_fecha = r.data.minimo;
        this.fechas.max_fecha = r.data.maximo;
        console.log(this.fechas);
      });
    },
    informe_PDF() {
      let fecha_inicial = "";
      let fecha_final = "";
      if (this.dataFilter.fecha_inicial == "") {
        fecha_inicial = this.fechas.min_fecha;
      } else {
        fecha_inicial = this.dataFilter.fecha_inicial;
      }
      if (this.dataFilter.fecha_final == "") {
        fecha_final = this.fechas.min_fecha;
      } else {
        fecha_final = this.dataFilter.fecha_final;
      }
      window.open(
        "/informe_pdf_mis?min_fecha=" +
          fecha_inicial +
          "&max_fecha=" +
          fecha_final
      );
    },
    pantallaNuevo(x) {
      this.pantalla = "nuevo";
      this.id_magistrado = x;
    },
  },
};
</script>

