
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
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><router-link :to="{ name: 'home'}"><span>Home</span></router-link> / <label for="" class="p-2">Tribunales de Garantía / Informe de PQRS  </label></li>
            </ol>
            <div class="row p-2 text-center border shadow rounded-3">
              <div class="row">
                <div class="col-12 col-md-12 col-lg-12 col-xl-12 p-2">
                  <h1 class="text-blue"><b>INFORMES DE PQRS</b></h1>
                </div>

              </div>
            </div>
            <form @submit.prevent="filter">
              <div class="row mt-5">
                <div class="mb-3 col-3">
                  <label for="" class="form-label"><b>Tipo de trámite</b></label>
                  <input
                    type="text"
                    class="form-control"
                    id="nombre_tema"
                    name="nombre_tema"
                    v-model="dataFilter.nombre_tema"
                  />
                </div>
                <div class="mb-3 col-3">
                  <label for="" class="form-label"><b>Fecha recibido</b></label>
                  <input
                    type="date"
                    class="form-control"
                    id="fecha_realizacion"
                    v-model="dataFilter.fecha_realizacion"
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
                  <label for="" class="form-label"><b>Estado</b></label>
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

                <div class="row">
                  <div class="mb-3 col-3">
                    <button
                      type="submit"
                      class="btn-primary btn w-80 btn_search w-100"
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
            <caption class="top">
              <div class="container">
                <div class="row align-items-start">
                  <div class="col">

                  </div>
                  <div class="col text-end">
                    <button type="button" class="btn btn-labeled btn-secondary active">
                      <i class="fa fa-file-excel-o"></i></button>
                  </div>
                </div>
              </div>
            </caption>
            <thead>
              <th>Tipo de Trámite</th>
              <th>Prioridad</th>
              <th>Fecha Recibido</th>
              <th>Departamento</th>
              <th>Municipio</th>
              <th>Solicitante</th>
              <th>Estado</th>
              <th>Usuario Asignado</th>
            </thead>
            <tbody>
              <!--tr v-for="(i, index) in cabildos" :key="index">
                <td>{{ i.nombre_tema }}</td>
                <td>{{ i.description }}</td>
                <td>{{ i.nombre_dep }}</td>
                <td>{{ i.nombre_ciu }}</td>
                <td>{{ i.nombre_dep }}</td>
                <td>{{ i.nombre_dep }}</td>
                <td>{{ i.nombre_ciu }}</td>
                <td>{{ i.nombre_dep }}</td>
              </tr-->
              <tr>
                <td>Queja</td>
                <td>Alta</td>
                <td>01-02-2021</td>
                <td>Cundinamarca</td>
                <td>Chía</td>
                <td>Camilo AVENDAÑO</td>
                <td>En Proceso</td>
                <td>Pepito Perez</td>
              </tr>
            </tbody>

          </table>
        </template>

        <template v-if="action == 1">



          <div>
            <div class="container mt-5">
              <label for="" class="p-2"
                >Cabildos/Listado de cabildos/Editar sesión</label
              >
              <div class="row p-2 text-center border shadow">
                <h1 class="text-blue"><b>EDITAR SESIÓN</b></h1>
              </div>
              <form @submit.prevent="saveEdit">
                <!-- @include('modals.edit-file') -->
                <input type="hidden" name="id_record" />
                <div class="row">
                  <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-5">
                    <div class="row">
                      <div class="mb-3">
                        <label for="" class="form-label"><b>Tema *</b></label>
                        <input
                          v-model="datos_edit.nombre_tema"
                          type="text"
                          class="form-control"
                          maxlength="250"
                        />
                      </div>
                    </div>
                    <div class="row">
                      <div class="mb-3">
                        <label for="" class="form-label"
                          ><b>Descripción *</b></label
                        >
                        <textarea
                          class="form-control"
                          style="height: 150px"
                          maxlength="1000"
                          v-text="datos_edit.description"
                          v-model="datos_edit.description"
                        >
                        </textarea>
                      </div>
                    </div>
                    <div class="row">
                      <div class="mb-3">
                        <label for="" class="form-label"
                          ><b>Departamento *</b></label
                        >
                        <select
                          class="form-select"
                          aria-label="Default select example"
                          v-model="datos_edit.dep_id"
                          v-on:change="changeCity()"
                          id="departamento_id"
                        >
                          <option
                            v-for="(i, index) in departament"
                            :key="index"
                            v-text="i.nombre"
                            :value="i.id"
                          ></option>
                        </select>
                      </div>
                    </div>
                    <div class="row">
                      <div class="mb-3">
                        <label for="" class="form-label"><b>Ciudad *</b></label>
                        <select
                          class="form-select"
                          name="municipality"
                          id="municipio"
                          v-model="datos_edit.ciu_id"
                        >
                          <option>Seleccione ...</option>
                          <option
                            v-for="(i, index) in ciudades"
                            :key="index"
                            :value="i.id"
                          >
                            {{ i.nombre }}
                          </option>
                        </select>
                      </div>
                    </div>
                    <div class="row">
                      <div class="mb-3">
                        <label for="" class="form-label"
                          ><b>Fecha de agendamiento *</b>
                        </label>
                        <div class="input-group">
                          <input
                            type="date"
                            class="form-control"
                            v-model="datos_edit.fecha_realizacion"
                          />
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-5">
                    <div class="row">
                      <label for="" class="form-label"
                        ><b>Tipo de documento *</b>
                      </label>
                      <select class="form-select">
                        <option
                          v-for="(i, index) in type_file"
                          :key="index"
                          :value="i.id"
                          v-text="i.nombre"
                        ></option>
                      </select>
                    </div>
                    <div class="row mt-3">
                      <label for="" class="form-label"
                        ><b>Radicado CNE *</b></label
                      >
                      <input
                        type="text"
                        class="form-control"
                        maxlength="30"
                        v-model="datos_edit.radicado_CNE"
                      />
                    </div>
                    <div class="row mt-5">
                      <div
                        class="form-group files border"
                        role="button"
                        id="box_file"
                      >
                        <div class="row mt-5">
                          <img class="img_file mx-auto d-block" src="" alt="" />
                        </div>
                        <div class="row mt-1 mb-5">
                          <p class="text_file text-center">
                            Edita tus documentos aquí
                          </p>
                        </div>
                      </div>
                      <input
                        id="file"
                        type="file"
                        class="form-control d-none"
                      />
                    </div>
                    <div class="row mt-5">
                      <button class="btn-primary btn">Editar sesión</button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
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
        <tribunales-nuevo></tribunales-nuevo>
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
      pantallaNuevo(){
          this.pantalla = 'nuevo'
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
