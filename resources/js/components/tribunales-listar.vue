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
          <ol class="breadcrumb">
            <li class="breadcrumb-item active">
              <router-link :to="{ name: 'home' }"
                ><span>Home</span></router-link
              >
              /
              <label for="" class="p-2"
                >Tribunales de Garantía / Listado de tribunales
              </label>
            </li>
          </ol>
          <div class="row p-2 text-center border shadow rounded-3">
            <div class="row">
              <div class="col-12 col-md-12 col-lg-10 col-xl-10 p-2">
                <h1 class="text-blue"><b>LISTADO DE TRIBUNALES</b></h1>
              </div>
              <div class="col-12 col-md-12 col-lg-2 col-xl-2 p-2">
                <button
                  @click="pantallaNuevo"
                  class="btn btn-warning text-white w-100 mt-2"
                >
                  Nuevo tribunal
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
                <label for="" class="form-label"><b>Fecha inicio</b></label>
                <input
                  type="date"
                  class="form-control"
                  id="fecha_realizacion"
                  v-model="dataFilter.fecha_inicio"
                />
              </div>
              <div class="mb-3 col-3">
                <label for="" class="form-label"><b>Fecha final</b></label>
                <input
                  type="date"
                  class="form-control"
                  id="fecha_final"
                  v-model="dataFilter.fecha_end"
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
          </form>
        </div>
        <table class="table table-bordered table-striped table-sm" id="datos">
          <thead>
            <th style="width: 195px">Opciones</th>
            <th>Nombre</th>
            <th>Departamento</th>
            <th>Ciudad</th>
            <th>Dirección</th>
            <th>Fecha inicio</th>
            <th>Fecha fin</th>
            <th>Estado</th>
          </thead>
          <tbody>
            <tr v-for="(i, index) in tabla" :key="index">
              <td class="aling_btn_options">
                <button
                  type="button"
                  @click="editar(i)"
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
              <td>{{ i.nombre }}</td>
              <td>{{ i.departamento }}</td>
              <td>{{ i.ciudad }}</td>
              <td>{{ i.direccion }}</td>
              <td>{{ i.fecha_inicio }}</td>
              <td>{{ i.fecha_final }}</td>
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
      </div>
    </template>
    <template v-if="pantalla == 'nuevo'">
      <div>
        <tribunales-nuevo @pantalla="pantalla = $event"></tribunales-nuevo>
      </div>
    </template>
    <template v-if="pantalla == 'editar'">
      <div>
        <tribunales-editar @pantalla="pantalla = $event" :id="idEditar"></tribunales-editar>
      </div>
    </template>
    <template v-if="pantalla == 'ver'">
      <div>
        <tribunales-ver :id="idEditar"></tribunales-ver>
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
      dataFilter: {},
      tabla: [],
      action: 0,
      idEditar: 0,
      datos_edit: {},
      pantalla: "lista",
        // pantalla: "nuevo",
    };
  },
  created() {
    axios.get(`/listar/tribunal`).then((r) => {
      this.tabla = r.data.tabla;
      this.departament = r.data.departments;
      this.fecha_format()
      console.log(r.data.tabla);
    });
  },
  methods: {
    fecha_format() {
        var fecha = ''
        var fecha_format = ''
        var array = []

        for (let index = 0; index < this.tabla.length; index++) {
            fecha = this.tabla[index].fecha_inicio
            array = fecha.split('-')
            fecha_format = array[2] + '-' + array[1] + '-' + array[0]
            this.tabla[index].fecha_inicio = fecha_format

            fecha = this.tabla[index].fecha_final
            array = fecha.split('-')
            fecha_format = array[2] + '-' + array[1] + '-' + array[0]
            this.tabla[index].fecha_final = fecha_format
        }
    },
    filter() {
      axios.post("/filtros-tribunales", this.dataFilter).then((r) => {
        this.tabla = r.data.tabla;
      });
    },
    editar(i) {
      this.idEditar = i.id;
      this.pantalla = "editar";
    },
    view(x) {
      this.idEditar = x;
      this.pantalla = "ver";
    },
    pantallaNuevo() {
      this.pantalla = "nuevo";
    },
    inacive(id) {
      Swal.fire({
        title: "Desabilitar tribunal?",
        text: "¿Desea desabilitar este tribunal?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#757575",
        confirmButtonText: "Aceptar",
        cancelButtonText: "Cancelar",
      }).then((result) => {
        if (result.value) {
          axios
            .post(`/modificar-estado/${id}/tribunal/0`, { id: id })
            .then((r) => {
              Swal.fire(
                "Desabilitado!",
                "El tribunal ha sido desactivado",
                "success"
              );
              this.tabla = r.data.tabla;
            });
        }
      });
    },
    active(id) {
      Swal.fire({
        title: "¿Activar tribunal?",
        text: "¿Desea activar este tribunal?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#757575",
        confirmButtonText: "Aceptar",
        cancelButtonText: "Cancelar",
      }).then((result) => {
        if (result.value) {
          axios
            .post(`/modificar-estado/${id}/tribunal/1`, { id: id })
            .then((r) => {
              Swal.fire("Activado!", "El tribunal ha sido activado", "success");
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
