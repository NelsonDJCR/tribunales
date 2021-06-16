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
                <li class="breadcrumb-item active"><router-link :to="{ name: 'home'}"><span>Home</span></router-link> / <label for="" class="p-2">Tribunales de Garantía / Listado de Magistrados</label></li>
            </ol>
            <div class="row p-2 text-center border shadow rounded-3">
              <div class="row">
                <div class="col-12 col-md-12 col-lg-9 col-xl-9 p-2">
                  <h1 class="text-blue"><b>LISTADO DE FUNCIONARIOS</b></h1>
                </div>
                <div class="col-12 col-md-12 col-lg-3 col-xl-3 p-2">
                  <button
                    @click="pantallaNuevo"
                    class="btn btn-warning text-white w-100 mt-2"
                  >

                    Nuevo Funcionario
                  </button>
                </div>
              </div>
            </div>
            <form @submit.prevent="filter">
              <div class="row mt-5">
                <div class="mb-3 col-3">
                  <label for="" class="form-label"><b>Nombre</b></label>
                  <input
                    type="text"
                    class="form-control"
                    id="nombre_tema"
                    name="nombre_tema"
                    v-model="dataFilter.nombre"
                  />
                </div>
                <div class="mb-3 col-3">
                  <label for="" class="form-label"><b>Departamento</b></label>
                  <select
                    v-model="dataFilter.dep_id"
                    class="form-select"
                    name="dep_id"
                    id="dep_id"
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
                <div class="mb-3 col-3">
                  <label for="" class="form-label"><b>Documento</b></label>
                  <input
                    type="text"
                    class="form-control"
                    v-model="dataFilter.numero_identificacion"
                  />
                </div>
                <div class="mb-3 col-3">
                  <label for="" class="form-label"><b>Telefono</b></label>
                  <input
                    type="text"
                    class="form-control"
                    v-model="dataFilter.telefono"
                  />
                </div>

                <div class="row col-12">
                  <div class="mb-5 col-3 ">
                    <button
                      type="submit"
                      class="btn-secondary active btn w-100 btn_search"
                    >
                      Buscar
                    </button>
                  </div>


                </div>
              </div>
            </form>
          </div>
          <table class="table table-bordered table-striped table-sm" id="datos">
            <thead>
              <th>Opciones</th>
              <th>Nombre</th>
              <th>Documento</th>
              <th>Departamento</th>
              <th>Ciudad</th>
              <th>Teléfono</th>
              <th>Correo electrónico</th>
              <th>Estado</th>
            </thead>
            <tbody>
              <!--  -->
              <tr v-for="(i, index) in tabla" :key="index">
                <td class="aling_btn_options" style="width:180px;">

                  <button
                    type="button"
                    class="btn btn-success btn-sm"
                    @click="view(i.id)"
                  >
                    <i class="typcn typcn-eye"></i>
                  </button>
                  <button
                    type="button"
                    @click="editar(i.id)"
                    class="btn btn-info btn-sm"
                  >
                    <i class="typcn typcn-edit" style="color: white"></i>
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
                <td>{{ i.nombre }}</td>
                <td>{{ i.numero_identificacion }}</td>
                <td>{{ i.departamento }}</td>
                <td>{{ i.ciudad }}</td>
                <td>{{ i.telefono }}</td>
                <td>{{ i.correo }}</td>
                <td>
                <div v-if="i.estado == 1">
                  <span class="badge badge-success">Activo</span>
                </div>
                <div v-else>
                  <span class="badge badge-danger">Inactivo</span>
                </div>
              </td>
              </tr>
            </tbody>
          </table>
        <!-- </template> -->

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
        <tribunales-magistrados-nuevo />
      </div>

    </template>
    <template v-if="pantalla == 'editar'">
      <div>
        <tribunales-magistrados-editar :id="idEditar"></tribunales-magistrados-editar>
      </div>
    </template>
    <template v-if="pantalla == 'ver'">
      <div>
        <tribunales-magistrados-ver :id="idEditar"></tribunales-magistrados-ver>
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
      tabla: {},
      action: 0,
      idEditar: 0,
      datos_edit: {},
    //   pantalla: 'nuevo',
      pantalla: "lista",
    };
  },
  created() {
    axios.get('/listar/magistrados').then((r) => {
      this.tabla = r.data.tabla;

    });
    axios.get("/data-select").then((r) => {
      this.tipo_documentos = r.data.tipo_documento;
      this.ciudades = r.data.ciudades;
      this.departament = r.data.departamentos;
      this.bancos = r.data.bancos;
      this.tipo_cuentas = r.data.tipo_cuentas;
      this.tipo_archivos = r.data.tipo_archivos;
      this.tipo_identificacion = r.data.tipo_identificacion;
    });
  },
  methods: {
    filter(){
      axios.post('/filtros-magistrados', this.dataFilter).then((r)=>{
        this.tabla = r.data.tabla;
      })
    },
    editar(x) {
        this.idEditar = x
        // alert(this.idEditar)
      this.pantalla = "editar";
    },
    view(x) {
      this.idEditar = x
      this.pantalla = "ver";
    },
    pantallaNuevo(){
      this.pantalla = "nuevo";
    },
    inacive(id) {
      Swal.fire({
        title: "Desabilitar magistrado?",
        text: "¿Desea desabilitar este magistrado?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#757575",
        confirmButtonText: "Aceptar",
        cancelButtonText: "Cancelar",
      }).then((result) => {
        if (result.value) {
          axios
            .post(`/modificar-estado/${id}/magistrados/0`, { id: id })
            .then((r) => {
              Swal.fire(
                "Desabilitado!",
                "El magistrado ha sido desactivado",
                "success"
              );
              this.tabla = r.data.tabla;
            });
        }
      });
    },
    active(id) {
      Swal.fire({
        title: "¿Activar magistrado?",
        text: "¿Desea activar este magistrado?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#757575",
        confirmButtonText: "Aceptar",
        cancelButtonText: "Cancelar",
      }).then((result) => {
        if (result.value) {
          axios
            .post(`/modificar-estado/${id}/magistrados/1`, { id: id })
            .then((r) => {
              Swal.fire(
                "Activado!",
                "El magistrado ha sido activado",
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
