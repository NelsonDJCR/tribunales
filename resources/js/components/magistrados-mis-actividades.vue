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
                <li class="breadcrumb-item active"><router-link :to="{ name: 'home'}"><span>Home</span></router-link> / <label for="" class="p-2">Magistrados / Mis actividades </label></li>
            </ol>
            <div class="row p-2 text-center border shadow rounded-3">
              <div class="row">
                <div class="col-12 col-md-12 col-lg-12 col-xl-12 p-2">
                  <h1 class="text-blue"><b>MIS ACTIVIDADES</b></h1>
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
                    v-model="dataFilter.nombre_tema"
                  />
                </div>
                <div class="mb-3 col-3">
                  <label for="" class="form-label"><b>Fecha</b></label>
                  <input
                    type="date"
                    class="form-control"
                    id="fecha_realizacion"
                    v-model="dataFilter.fecha_realizacion"
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
                        <!-- <div class="mb-3 col-1">
                                <button
                                style="color: white"
                                class="btn btn-info"
                                id="btn_exece"
                                type="button"
                                @click="export_exel()"
                                >
                                <i class="typcn typcn-database"></i>
                                </button>
                            </div> -->
                    </div>
                </div>

                <div class="mb-3 col-3">

                </div>

              </div>
            </form>
          </div>
          <table class="table table-bordered table-sm" id="datos">
            <thead>
              <th>Opciones</th>
              <th>Fecha</th>
              <th>Tema</th>
              <th class="w-25">Descripcion</th>
              <th>Departamento</th>
              <th>Municipio</th>
              <th>Magistrado</th>
            </thead>
            <tbody>
              <!-- v-for="(i, index) in cabildos" :key="index" -->
              <tr>
                <td class="aling_btn_options">

                  <button
                    type="button"
                    class="btn btn-success btn-sm"
                    @click="view()"
                  >
                    <i class="typcn typcn-eye"></i>
                  </button>

                </td>
                <td>20/20/2020</td>
                <td>Tema</td>
                <td class="w-25">Descripcion</td>
                <td>Departamento</td>
                <td>Municipio</td>
                <td>Magistrado</td>
                <!-- <td>{{ i.nombre_tema }}</td>
                <td>{{ i.description }}</td>
                <td>{{ i.nombre_dep }}</td>
                <td>{{ i.nombre_ciu }}</td>
                <td>{{ i.fecha_realizacion }}</td> -->
              </tr>
            </tbody>
          </table>
        <!-- </template> -->

      </div>
    </template>

    <template v-if="pantalla == 'ver'">
      <div>
        <magistrados-mis-actividades-ver></magistrados-mis-actividades-ver>
      </div>
    </template>

  </div>
</template>

<script>
export default {
  data() {
    return {
      dataPdf: { cabildo_id: "", radicado: "", ciudadano: "" },
      departament: [],
      ciudades: [],
      type_file: [],
      cabildos: [],
      dataFilter: {},
      action: 0,
      idEditar: 0,
      datos_edit: {},
      pantalla: "lista",
    };
  },
  created() {
    const url = "/data-list-cabildos";
    axios.get(url).then((r) => {
      this.cabildos = r.data.cabildos;
      //   this.ciudades = r.data.municipios;
      this.departament = r.data.departments;
      console.log(this.cabildos);
    });
  },
  methods: {
    editar() {
      this.pantalla = "editar";
    },
    view() {
      this.pantalla = "ver";
    },
    pantallaNuevo(){
      this.pantalla = "nuevo";

    },
  },
};
</script>

