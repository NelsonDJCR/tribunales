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
              /
              <label for="" class="p-2"
                >Tribunales de Garantía / Listado de actividades
              </label>
            </li>
          </ol>
          <div class="row p-2 text-center border shadow rounded-3">
            <div class="row">
              <div class="col-12 col-md-12 col-lg-10 col-xl-10 p-2">
                <h1 class="text-blue"><b>LISTADO DE ACTIVIDADES</b></h1>
              </div>
              <div class="col-12 col-md-12 col-lg-2 col-xl-2 p-2">
                <button
                  @click="pantallaNuevo"
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
          <thead>
            <th>Opciones</th>
            <th class="w-85">Fecha</th>
            <th>Tema</th>
            <th>Descripción</th>
            <th>Departamento</th>
            <th>Municipio</th>
            <th>Magistrado</th>
            <th>Estado</th>
          </thead>
          <tbody>
            <tr v-for="(i, index) in tabla" :key="index">
              <td class="aling_btn_options" style="width: 170px">
                <button
                  type="button"
                  @click="editar(i.id)"
                  class="btn btn-info btn-sm"
                >
                  <i class="typcn typcn-edit" style="color: white"></i>
                </button>

                <button
                  type="button"
                  class="btn btn-success btn-sm"
                  @click="view(i.id)"
                >
                  <i class="typcn typcn-eye"></i>
                </button>

                <template v-if="i.estado == 1">
                  <button
                    type="button"
                    class="btn btn-danger btn-sm"
                    @click="inacive(i.id)"
                  >
                    <i class="typcn typcn-trash"></i>
                  </button>
                </template>
                <template v-else>
                  <button
                    type="button"
                    class="btn btn-info btn-sm"
                    @click="active(i.id)"
                  >
                    <i class="typcn typcn-tick-outline"></i>
                  </button>
                </template>
              </td>
              <td>{{ i.fecha }}</td>
              <td>{{ i.tema }}</td>
              <td>{{ i.descripcion }}</td>
              <td>{{ i.departamento }}</td>
              <td>{{ i.ciudad }}</td>
              <td>{{ i.magistrado }}</td>
              <div v-if="i.estado == 1">
                <span class="badge badge-success">Activo</span>
              </div>
              <div v-else>
                <span class="badge badge-danger">Inactivo</span>
              </div>
            </tr>
          </tbody>
        </table>

        <div
          class="modal fade bd-example-modal-lg"
          tabindex="-1"
          role="dialog"
          aria-labelledby="myLargeModalLabel"
          aria-hidden="true"
          id="modal_export"
        >
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                  Generar reporte
                </h5>
                <button
                  type="button"
                  class="close"
                  data-dismiss="modal"
                  aria-label="Close"
                >
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form @submit.prevent="exportPdf">
                <input
                  type="hidden"
                  name=""
                  id="cabildos_id"
                  v-model="dataPdf.cabildo_id"
                />
                <div class="modal-body">
                  <div class="mb-3 col-12">
                    <label for="" class="form-label">Radicado</label>
                    <input
                      type="text"
                      required
                      class="form-control"
                      v-model="dataPdf.radicado"
                    />
                  </div>
                  <div class="mb-3 col-12">
                    <label for="" class="form-label">Ciudadano</label>
                    <input
                      type="text"
                      required
                      class="form-control"
                      v-model="dataPdf.ciudadano"
                    />
                  </div>
                </div>
                <div class="modal-footer">
                  <button
                    type="button"
                    class="btn btn-secondary"
                    data-dismiss="modal"
                  >
                    Close
                  </button>
                  <button type="submit" class="btn btn-primary">
                    Generar PDF
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </template>
    <template v-if="pantalla == 'nuevo'">
      <div>
        <tribunales-actividades-nuevo @pantalla="pantalla = $event"></tribunales-actividades-nuevo>
      </div>
    </template>
    <template v-if="pantalla == 'editar'">
      <div>
        <tribunales-actividades-editar
        @pantalla="pantalla = $event"
          :id="id_record"
        ></tribunales-actividades-editar>
      </div>
    </template>
    <template v-if="pantalla == 'ver'">
      <div>
        <tribunales-actividades-ver
          :id="id_record"
          @pantalla="pantalla = $event"
        ></tribunales-actividades-ver>
      </div>
    </template>
  </div>
</template>

<script>
export default {
  props: ["id"],
  data() {
    return {
      dataPdf: { cabildo_id: "", radicado: "", ciudadano: "" },
      departament: [],
      ciudades: [],
      type_file: [],
      tabla: [],
      dataFilter: {},
      action: 0,
      id_record: 0,
      datos_edit: {},
      pantalla: "lista",
      //   pantalla: "nuevo",
    };
  },
  created() {
    axios.get("/listar/actividades").then((r) => {
      this.tabla = r.data.tabla;
      this.formatear_fecha();
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
    filter() {
      axios.post("/filtros-actividad", this.dataFilter).then((r) => {
        this.tabla = r.data.tabla;
        this.formatear_fecha()
      });
    },
    editar(id) {
      this.id_record = id;
      this.pantalla = "editar";
    },
    view(id) {
      this.id_record = id;
      this.pantalla = "ver";
    },
    pantallaNuevo() {
      this.pantalla = "nuevo";
    },
    inacive(id) {
      Swal.fire({
        title: "Desabilitar actividad?",
        text: "¿Desea desabilitar esta actividad?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#757575",
        confirmButtonText: "Aceptar",
        cancelButtonText: "Cancelar",
      }).then((result) => {
        if (result.value) {
          axios
            .post(`/modificar-estado/${id}/actividades/0`, { id: id })
            .then((r) => {
              Swal.fire(
                "Desabilitado!",
                "La actividad ha sido desactivada",
                "success"
              );
              this.tabla = r.data.tabla;
            });
        }
      });
    },
    active(id) {
      Swal.fire({
        title: "¿Activar actividad?",
        text: "¿Desea activar esta actividad?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#757575",
        confirmButtonText: "Aceptar",
        cancelButtonText: "Cancelar",
      }).then((result) => {
        if (result.value) {
          axios
            .post(`/modificar-estado/${id}/actividades/1`, { id: id })
            .then((r) => {
              Swal.fire(
                "Activado!",
                "El actividad ha sido activado",
                "success"
              );
              this.tabla = r.data.tabla;
            });
        }
      });
    },
  },
};
</script>

<style>
.w-85 {
  width: 85px;
}
</style>

