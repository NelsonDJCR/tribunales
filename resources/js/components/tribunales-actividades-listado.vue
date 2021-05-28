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
                <li class="breadcrumb-item active"><router-link :to="{ name: 'home'}"><span>Home</span></router-link> / <label for="" class="p-2">Tribunales de Garantía / Listado de actividades </label></li>
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
              <th>Fecha</th>
              <th>Tema</th>
              <th>Descripción</th>
              <th>Departamento</th>
              <th>Municipio</th>
              <th>Magistrado</th>
              <th>Estado</th>
            </thead>
            <tbody>
              <tr v-for="(i, index) in tabla" :key="index">
                <td class="aling_btn_options" style="width:170px;">
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
                    <button type="button" class="btn btn-info btn-sm" @click="active(i.id)">
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
        <tribunales-actividades-nuevo></tribunales-actividades-nuevo>
      </div>
    </template>
    <template v-if="pantalla == 'editar'">
      <div>
        <tribunales-actividades-editar :id="id_record"></tribunales-actividades-editar>
      </div>
    </template>
    <template v-if="pantalla == 'ver'">
      <div>
        <tribunales-actividades-ver :id="id_record"></tribunales-actividades-ver>
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
      tabla: [],
      dataFilter: {},
      action: 0,
      id_record: 0,
      datos_edit: {},
      pantalla: "lista",
    };
  },
  created() {
    axios.get('/listar/actividades').then((r) => {
      this.tabla = r.data.tabla;
    });
  },
  methods: {
    filter(){
      axios.post('/filtros-actividad', this.dataFilter).then((r)=>{
        this.tabla = r.data.tabla;
      })
    },
    editar(id) {
      this.id_record = id;
      this.pantalla = "editar";
    },
    view(id) {
      this.id_record = id;
      this.pantalla = "ver";
    },
    pantallaNuevo(){
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

    // modal_export(id) {
    //   $("#cabildos_id").val(id);
    //   this.dataPdf.cabildo_id = id;
    //   this.dataPdf.radicado = "";
    //   this.dataPdf.ciudadano = "";
    //   $("#modal_export").modal("show");
    // },
    // exportPdf() {
    //   window.open(
    //     "/download?id=" +
    //       this.dataPdf.cabildo_id +
    //       "&radicado=" +
    //       this.dataPdf.radicado +
    //       "&ciudadano=" +
    //       this.dataPdf.ciudadano
    //   );
    //   $("#modal_export").modal("hide");
    // },
    // export_exel() {
    //   let url = "/excel-cabildos";
    //   let filtros = this.dataFilter;
    //   axios.post(url, filtros).then((res) => {
    //     let blob = new Blob([res.data]);
    //     let link = document.createElement("a");
    //     link.href = window.URL.createObjectURL(blob);
    //     link.download = "ReporteCabildos.xls";
    //     link.click();
    //   });
    // },
    // changeCity() {
    //   var id = $("#departamento_id").val();
    //   axios.post("/changeCity", { id: id }).then((r) => {
    //     this.ciudades = r.data;
    //   });
    // },
    // filter() {
    //   let filtros = this.dataFilter;
    //   axios.post("/filter-list-cabildos", filtros).then((r) => {
    //     console.log(r.data.cabildos);
    //     this.cabildos = r.data.cabildos;
    //   });
    // },
    // report() {
    //   var form = new FormData();
    //   form.append("nombre_tema", $("#nombre_tema").val());
    //   form.append("dep_id", $("#dep_id").val());
    //   form.append("fecha_realizacion", $("#fecha_realizacion").val());
    //   form.append("fecha_final", $("#fecha_final").val());
    //   axios.post("/excel-cabildos", form).then((r) => {});
    // },
    // deleteSesion(id) {
    //   Swal.fire({
    //     title: "¿Eliminar registro?",
    //     text: "Esta acción no se puede revertir",
    //     icon: "question",
    //     showCancelButton: true,
    //     confirmButtonColor: "#3085d6",
    //     cancelButtonColor: "#757575",
    //     confirmButtonText: "Aceptar",
    //     cancelButtonText: "Cancelar",
    //   }).then((result) => {
    //     console.log(result);
    //     if (result.value) {
    //       const url = "/delete-session/" + id;
    //       axios.get(url).then((r) => {
    //         this.cabildos = r.data.cabildos;
    //         Swal.fire(
    //           "¡Perfecto!",
    //           "Datos eliminados correctamente",
    //           "success"
    //         );
    //       });
    //     }
    //   });
    // },
    // editSession(id) {
    //   this.action = 1;
    //   this.idEditar = id;
    //   axios
    //     .get("/edit-sesion/" + id)
    //     .then((r) => {
    //       this.datos_edit = r.data.datos;
    //       this.departament = r.data.departament;
    //       this.ciudades = r.data.ciudades;
    //       this.type_file = r.data.type_file;
    //     })
    //     .catch(function (error) {
    //       console.log(error);
    //     });
    // },
    // saveEdit() {
    //   let datos = this.datos_edit;
    //   let url = "/editSesion";
    //   axios.post(url, datos).then((res) => {
    //     if (res.data.status == 406) {
    //       Swal.fire({
    //         icon: "error",
    //         title: "¡Error!",
    //         text: res.data.msg,
    //       });
    //     } else {
    //       this.action = 0;
    //       this.cabildos = res.data.table;
    //       // console.log(r.data);
    //       // return false;
    //       Swal.fire({
    //         icon: "success",
    //         title: "¡Perfercto!",
    //         text: "Datos guardados exitosamente",
    //       });
    //     }
    //   });
    // },
  },
};
</script>

