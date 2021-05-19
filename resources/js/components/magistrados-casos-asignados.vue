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
        <template v-if="action == 0">
          <div class="container mt-5">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><router-link :to="{ name: 'home'}"><span>Home</span></router-link> / <label for="" class="p-2">Magistrados / Casos asignados</label></li>
            </ol>
            <div class="row p-2 text-center border shadow rounded-3">
              <div class="row">
                <div class="col-12 col-md-12 col-lg-12 col-xl-12 p-2">
                  <h1 class="text-blue"><b>CASOS ASIGNADOS</b></h1>
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
          <table class="table table-bordered table-striped table-lg" id="datos">
            <thead class="text-left align-middle">
              <th class="w-5">Opciones</th>
              <th>Fecha</th>
              <th>Tema</th>
              <th colspan="2" class="w-25">Descripción</th>
              <th>Departamento</th>
              <th>Municipio</th>
              <th>Magistrado</th>
            </thead>
            <tbody>
              <!-- v-for="(i, index) in cabildos" :key="index" -->
              <tr >
                <td class="aling_btn_options">

                  <button
                    type="button"
                    @click="modal_export(5)"
                    class="btn btn-secondary btn-sm"
                  >
                    <i
                      class="typcn typcn-cog cl-white"
                    ></i>
                  </button>
                  <button
                    type="button"
                    class="btn btn-success btn-sm"
                    @click="pantallaEditar()"
                  >
                    <i class="typcn typcn-eye"></i>
                  </button>


                </td>
                <td>20/20/20</td>
                <td>Tema</td>
                <td colspan="2">Descripción</td>
                <td>Cundinamarca</td>
                <td>Chía</td>
                <td>Camilo Avendaño</td>
                <!-- <td>{{ i.nombre_tema }}}</td> -->
              </tr>
            </tbody>
          </table>
        </template>

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
                <h3 class="modal-title" id="exampleModalLabel">
                  Gestionar caso asignado
                </h3>
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
                    <label for="" class="form-label"><b>Estado</b></label>
                    <!--input
                      type="text"
                      required
                      class="form-control"
                      v-model="dataPdf.radicado"
                    /-->
                    <select
                        class="form-select"
                    >
                        <option>Estado 1</option>
                        <option>Estado 2</option>
                        <option>Estado 3</option>
                    </select>
                  </div>

                    <div class="mb-3 col-12">
                        <label for="" class="form-label"><b>Observaciones</b></label>
                        <!--input
                        type="text"
                        required
                        class="form-control"
                        v-model="dataPdf.ciudadano"
                        /-->
                        <textarea class="form-control" id="" rows="5"></textarea>
                    </div>

                    <div class="mb-3 col-12">
                        <label for="" class="form-label"
                            ><b>Tipo de archivo</b></label
                        >
                        <select
                            class="form-select"
                            name="type_file"
                        >
                            <option
                            v-for="(i, index) in type_file"
                            :key="index"
                            :value="i.id"
                            v-text="i.nombre"
                            ></option>
                        </select>
                    </div>

                    <div class="mb-3 col-12">
                        <div class="form-group files border opacity-2 opacity-2h"
                            role="button"
                            id="box_file"
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

                </div>

                <div class="modal-footer">
                    <div class="d-grid gap-2 d-md-block mx-auto">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal"
                        >
                            Cerrar
                        </button>
                        <button type="submit" class="btn btn-secondary active">
                            Guardar
                        </button>
                    </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </template>

    <template v-if="pantalla == 'editar'">
      <div>
        <magistrados-casos-asignados-ver></magistrados-casos-asignados-ver>
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
      pantalla: 'lista',
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
      pantallaEditar(){
          this.pantalla = 'editar'
      },
    modal_export(id) {
      $("#cabildos_id").val(id);
      this.dataPdf.cabildo_id = id;
      this.dataPdf.radicado = "";
      this.dataPdf.ciudadano = "";
      $("#modal_export").modal("show");
    },
    exportPdf() {
      window.open(
        "/download?id=" +
          this.dataPdf.cabildo_id +
          "&radicado=" +
          this.dataPdf.radicado +
          "&ciudadano=" +
          this.dataPdf.ciudadano
      );
      $("#modal_export").modal("hide");
    },
    export_exel() {
      let url = "/excel-cabildos";
      let filtros = this.dataFilter;
      axios.post(url, filtros).then((res) => {
        let blob = new Blob([res.data]);
        let link = document.createElement("a");
        link.href = window.URL.createObjectURL(blob);
        link.download = "ReporteCabildos.xls";
        link.click();
      });
    },
    changeCity() {
      var id = $("#departamento_id").val();
      axios.post("/changeCity", { id: id }).then((r) => {
        this.ciudades = r.data;
      });
    },
    filter() {
      let filtros = this.dataFilter;
      axios.post("/filter-list-cabildos", filtros).then((r) => {
        console.log(r.data.cabildos);
        this.cabildos = r.data.cabildos;
      });
    },

    report() {
      var form = new FormData();
      form.append("nombre_tema", $("#nombre_tema").val());
      form.append("dep_id", $("#dep_id").val());
      form.append("fecha_realizacion", $("#fecha_realizacion").val());
      form.append("fecha_final", $("#fecha_final").val());
      axios.post("/excel-cabildos", form).then((r) => {});
    },

    deleteSesion(id) {
      Swal.fire({
        title: "¿Eliminar registro?",
        text: "Esta acción no se puede revertir",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#757575",
        confirmButtonText: "Aceptar",
        cancelButtonText: "Cancelar",
      }).then((result) => {
        console.log(result);
        if (result.value) {
          const url = "/delete-session/" + id;
          axios.get(url).then((r) => {
            this.cabildos = r.data.cabildos;
            Swal.fire(
              "¡Perfecto!",
              "Datos eliminados correctamente",
              "success"
            );
          });
        }
      });
    },
    editSession(id) {
      this.action = 1;
      this.idEditar = id;
      axios
        .get("/edit-sesion/" + id)
        .then((r) => {
          this.datos_edit = r.data.datos;
          this.departament = r.data.departament;
          this.ciudades = r.data.ciudades;
          this.type_file = r.data.type_file;
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    saveEdit() {
      let datos = this.datos_edit;
      let url = "/editSesion";
      axios.post(url, datos).then((res) => {
        if (res.data.status == 406) {
          Swal.fire({
            icon: "error",
            title: "¡Error!",
            text: res.data.msg,
          });
        } else {
          this.action = 0;
          this.cabildos = res.data.table;
          // console.log(r.data);
          // return false;
          Swal.fire({
            icon: "success",
            title: "¡Perfercto!",
            text: "Datos guardados exitosamente",
          });
        }
      });
    },
  },
};
</script>
