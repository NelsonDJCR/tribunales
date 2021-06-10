<template>
  <div class="main col-12">
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x"
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://use.fontawesome.com/releases/v5.15.1/css/all.css"
      integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp"
      crossorigin="anonymous"
    />
    <template v-if="pantalla == 'listado'">
      <div>
        <div
          class="modal fade"
          id="1modal_download"
          aria-hidden="true"
          aria-labelledby="exampleModalToggleLabel"
          tabindex="-1"
        >
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalToggleLabel">
                  Modal 1
                </h5>
                <button
                  type="button"
                  class="btn-close"
                  data-bs-dismiss="modal"
                  aria-label="Close"
                ></button>
              </div>
              <div class="modal-body">
                Show a second modal and hide this one with the button below.
              </div>
              <div class="modal-footer"></div>
            </div>
          </div>
        </div>

        <!-- Inicio modal descargar -->
        <div
          class="modal fade"
          id="modal_download"
          aria-hidden="true"
          aria-labelledby="exampleModalToggleLabel2"
          tabindex="-1"
        >
          <div class="modal-dialog modal-md">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalToggleLabel2">
                  Sistema Uriel
                </h5>
                <button
                  type="button"
                  class="btn-close"
                  data-bs-dismiss="modal"
                  aria-label="Close"
                  @click="cerrar_modal_download"
                ></button>
              </div>
              <div class="modal-body">
                <div
                  v-for="(i, index) in documentos"
                  :key="index"
                  class="row container mb-3"
                >
                  <div class="col-10">
                    <select
                      class="form-select"
                      id="tipo"
                      v-model="i.id_tipo_documento"
                      disabled
                    >
                      <option
                        :value="x.id"
                        v-text="x.nombre"
                        v-for="(x, index2) in tipoArchivo"
                        :key="index2"
                      >
                        Selecciona
                      </option>
                    </select>
                  </div>
                  <div class="col-2">
                    <a
                      class="btn-self btn btn-warning btn-sm"
                      :href="i.ruta"
                      :download="i.ruta"
                    >
                      <i class="typcn typcn-download cl-white"></i>
                    </a>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button
                  class="btn btn-primary"
                  data-bs-target="#exampleModalToggle"
                  data-bs-toggle="modal"
                  data-bs-dismiss="modal"
                  @click="cerrar_modal_download"
                >
                  Cerrar
                </button>
              </div>
            </div>
          </div>
        </div>
        <!-- Fin modal descargar -->

        <div class="container mt-5">
          <label class="p-2">Sistema Uriel/Casos asignados</label>
          <div class="row p-2 text-center border shadow">
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12 col-xl-12 p-2">
                <h1 class="text-blue"><b>CASOS ASIGNADOS</b></h1>
              </div>
            </div>
          </div>
          <form @submit.prevent="filtrar" id="filter_list">
            <div class="row mt-5">
              <div class="mb-3 col-3">
                <label for="" class="form-label"><b>Tipo de trámite</b></label>
                <select
                  class="form-select"
                  name="id_tramite"
                  v-model="caso.tramite"
                >
                  <option value="">Seleccione ...</option>
                  <option
                    v-for="(i, index) in tramites"
                    :key="index"
                    :value="i.id"
                    v-text="i.nombre"
                  ></option>
                </select>
              </div>
              <div class="mb-3 col-3">
                <label for="" class="form-label"><b>Fecha recibido</b></label>
                <input
                  type="date"
                  class="form-control"
                  id=""
                  name="fecha_realizacion"
                  v-model="caso.fecha_realizacion"
                />
              </div>
              <div class="mb-3 col-3">
                <label for="" class="form-label"><b>Departamento</b></label>
                <select
                  class="form-select"
                  name="id_departamento"
                  v-model="caso.departamento"
                >
                  <option value="">Seleccione ...</option>
                  <option
                    v-for="(i, index) in departamentos"
                    :key="index"
                    :value="i.id"
                    v-text="i.nombre"
                  ></option>
                </select>
              </div>
              <div class="mb-3 col-3">
                <label for="" class="form-label"><b>Estado</b></label>
                <select class="form-select" name="estado" v-model="caso.estado">
                  <option value="">Seleccione ...</option>
                  <option
                    v-for="(i, index) in estados"
                    :key="index"
                    :value="i.id"
                    v-text="i.nombre"
                  ></option>
                </select>
              </div>
            </div>
            <div class="row mt-2 col-3">
              <button
                type="submit"
                class="btn btn-secondary active w-80 filtrar"
              >
                Buscar
              </button>
            </div>
          </form>
        </div>

        <table
          class="table-responsive table-bordered mt-4 text-center"
          id="tablecasos"
        >
          <thead>
            <tr>
              <th width="20%">Opciones</th>
              <th>Tipo de trámite</th>
              <th>Prioridad</th>
              <th>Fecha recibido</th>
              <th>Departamento</th>
              <th>Ciudad</th>
              <th>Solicitante</th>
              <th>Estado</th>
              <!-- <th>Usuario asignado</th> -->
            </tr>
          </thead>
          <tbody>
            <tr v-for="(i, index) in casos" :key="index">
              <td class="aling_btn_options w-20">
                <button
                  class="btn btn-secondary btn-sm"
                  @click="abrir_modal_config(i)"
                >
                  <i class="typcn typcn-cog"></i>
                </button>
                <button
                  class="btn btn-success btn-sm"
                  @click="cambiarVer(i.id)"
                >
                  <i class="typcn typcn-eye"></i>
                </button>
                <button
                  class="btn-self btn btn-warning btn-sm"
                  @click="modal_archivos(i)"
                >
                  <i class="typcn typcn-download cl-white"></i>
                </button>
              </td>
              <td>{{ i.tramite_nombre }}</td>
              <td>{{ i.prioridad_nombre }}</td>
              <td>{{ i.fecha_recibido }}</td>
              <td>{{ i.dep_nombre }}</td>
              <td>{{ i.ciu_nombre }}</td>
              <td>{{ i.nombres_solicitante }}</td>
              <td>{{ i.estado_nombre }}</td>
              <!-- <td>{{ i.id_asesor_asignado }}</td> -->
            </tr>
          </tbody>
        </table>

        <!-- Inicio modal gestionar -->
        <div
          class="modal fade"
          id="gestion-caso"
          tabindex="-1"
          aria-hidden="true"
        >
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title"><b>Gestionar caso</b></h5>
                <button
                  type="button"
                  class="btn-close"
                  data-bs-dismiss="modal"
                  aria-label="Close"
                  @click="gestionar_caso_modal_cerrar"
                ></button>
              </div>
              <div class="modal-body">
                <input type="hidden" v-model="gestion.id" id="idgestion" />
                <div class="mb-3 col-12">
                  <label for="" class="form-label"><b>Observaciones</b></label>
                  <textarea
                    class="form-control"
                    v-model="gestion.observacion"
                    style="height: 150px"
                    cols="30"
                    rows="10"
                    maxlength="499"
                  ></textarea>
                </div>
                <div class="mb-3 col-12">
                  <label for="" class="form-label"
                    ><b>Tipo de archivo</b></label
                  >
                  <select
                    name=""
                    id=""
                    class="form-select"
                    v-model="gestion.tipoArchivo"
                  >
                    <option value="">Seleccione</option>
                    <option
                      v-for="(i, index) in tipoArchivo"
                      :key="index"
                      :value="i.id"
                      v-text="i.nombre"
                    ></option>
                  </select>
                </div>
                <div class="mb-3 col-12">
                  <div class="row mt-5">
                    <div
                      class="form-group files border"
                      role="button"
                      id="box_file"
                      @click="box_file()"
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
                  <input
                    type="file"
                    class="d-none"
                    @change="uploadFile($event)"
                    id="file"
                  />
                </div>
                <table>
                  <tbody>
                    <tr v-if="archivo.name != ''">
                      <td>{{ archivo.name }}</td>
                      <td>
                        <button
                          class="btn btn-danger btn-sm"
                          @click="eliminar_archivo"
                        >
                          <i class="fas fa-trash"></i>
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <div class="mb-3 col-12">
                  <label for="" class="form-label"><b>Respuesta</b></label>
                  <textarea
                    name="observacion"
                    id="observacion"
                    class="form-control obliGesCaso"
                    data-label="Las observaciones son requeridas"
                    v-model="gestion.respuesta"
                    style="height: 150px"
                    maxlength="499"
                  ></textarea>
                </div>
              </div>
              <div class="modal-footer">
                <div class="row mt-2 col-12">
                  <button
                    class="btn btn-secondary active w-50 ml-25"
                    id="guardarGestionar"
                    @click="guardarCasoFile()"
                  >
                    Guardar
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Fin modal gestionar -->
      </div>
    </template>
    <template v-if="pantalla == 'ver'">
      <div>
        <tribunales-casos-ver @pantalla="pantalla = $event" :id="id" />
      </div>
    </template>
  </div>
</template>

<script>
export default {
  data() {
    return {
      departamentos: [],
      estados: [],
      tramites: [],
      estado1: [],
      documentos: [],
      casos: [],
      tipoArchivo: [],
      caso: {},
      archivos: {},
      tipoArchivoFiltrado: [],
      gestion: {
        id: 0,
        estado: "",
        asesor: "",
        observacion: "",
        respuesta: "",
        tipoArchivo: "",
      },
      id: 0,
      archivo: { name: "" },
      pantalla: "listado",
      existe: "",
    };
  },
  created() {
    let url = "/casos-asignados-data";
    axios.post(url).then((res) => {
      this.departamentos = res.data.departamento;
      this.estados = res.data.estado;
      this.tramites = res.data.tramite;
      this.casos = res.data.casos;
      this.estado1 = res.data.estado1;
      this.tipoArchivo = res.data.tipoArchivo;
      this.formatearFecha();
    });
  },
  methods: {
    box_file() {
        if(this.gestion.tipoArchivo != ''){
            $("#file").trigger("click");
        }else{
            Swal.fire('¡Error!','Primero selecciona un tipo de archivo','error')
        }
    },
    abrir_modal_config(caso) {
      (this.gestion = {
        id: 0,
        estado: "",
        asesor: "",
        tipoArchivo: "",
        observacion: "",
        respuesta: "",
      }),
        (this.gestion.id = caso.id);
      this.gestion.estado = caso.id_estado;
      this.existe = "";
      $("#gestion-caso").modal("show");
    },
    cambioEstado(estado) {
      if (estado == 3) {
        this.gestion.estado = 3;
        $("#gestion-caso").modal("hide");
        $("#caso-asignado").modal("show");
      } else {
        this.gestion.estado = estado;
        $("#caso-asignado").modal("hide");
        $("#gestion-caso").modal("show");
      }
    },
    uploadFile(event) {
      this.existe = "1";
      if (event.target.files[0].size > 3000000) {
        Swal.fire(
          "¡Advertencia!",
          "El peso de los archivos deben ser menor a 3MB",
          "warning"
        );
        event.target.files[0] = "";
        this.files[0] = "";
        $(".archivo_fin").text("");
      } else {
        this.archivo = event.target.files[0];
      }
    },
    modal_archivos(caso) {
      let url = "/documentos-x-casos/" + caso.id;
      axios.post(url).then((res) => {
        this.documentos = res.data;
        console.log(this.documentos);
        if (this.documentos.length == 0) {
          Swal.fire(
            "¡Advertencia!",
            "Este caso no tiene archivos cargados",
            "warning"
          );
        } else {
          $("#modal_download").modal("show");
        }
      });
    },
    cerrar_modal_download() {
      $("#modal_download").modal("hide");
    },
    guardarCasoFile() {
    //   console.log(this.gestion);
      var datos = new FormData();
      datos.append("archivo", this.archivo);
      datos.append("_method", "PUT");
      datos.append("id", this.gestion.id);
      datos.append("estado", this.gestion.estado);
      datos.append("observacion", this.gestion.observacion);
      datos.append("tipo_archivo", this.gestion.tipoArchivo);
      datos.append("respuesta", this.gestion.respuesta);
      if (this.gestion.observacion == "" && this.gestion.respuesta == "") {
        Swal.fire("Advertencia", "Debes ingresar al menos un campo", "warning");
        return false;
      }
      if (this.gestion.observacion != "" && this.gestion.respuesta == "") {
          if(this.existe == '1' && this.gestion.tipoArchivo == ''){
              Swal.fire('¡Error!','Selecciona un tipo de archivo','error')
              return
          }
        let url = "/gestion_en_tramite";
        axios.post(url, datos).then((res) => {
            console.log(res.data);
          this.casos = res.data.casos;
          setTimeout(function () {
            $("#gestion-caso").modal("hide");
          }, 500);
          Swal.fire("¡Éxito!", "Caso gestionado con éxito", "success");
        });
        return false;
      }
      if (this.gestion.tipoArchivo == "") {
        Swal.fire("Advertencia", "Ingresa un tipo de archivo", "warning");
        return false;
      }
      if (this.existe == "") {
        Swal.fire("Advertencia", "Carga un archivo", "warning");
        return;
      }
      if (this.gestion.observacion == "" && this.gestion.respuesta != "") {
        let url = "/gestion_en_finalizado";
        axios.post(url, datos).then((res) => {
            console.log(res.data);
          this.casos = res.data.casos;
          setTimeout(function () {
            $("#gestion-caso").modal("hide");
          }, 500);
          Swal.fire("¡Éxito!", "Caso gestionado con éxito", "success");
        });
      }
      if (this.gestion.observacion != "" && this.gestion.respuesta != "") {
        let url = "gestion_en_finalizado";
        axios.post(url, datos).then((res) => {
          this.casos = res.data.casos;
          setTimeout(function () {
            $("#gestion-caso").modal("hide");
          }, 500);
          Swal.fire("¡Éxito!", "Caso gestionado con éxito", "success");
        });
      }
    },
    cambiarVer(id) {
      this.id = id;
      this.pantalla = "ver";
    },
    eliminar_archivo() {
      this.archivo = { name: "" };
      this.existe = "";
    },
    filtrar() {
      let url = "/filtrar-casos-asignados";
      let filtros = this.caso;
      axios.post(url, filtros).then((res) => {
        console.log(res.data);
        this.casos = res.data;
        this.formatearFecha();
      });
    },
    formatearFecha() {
      var fechas = "";
      var fecha_format = "";
      var array = [];
      for (let index = 0; index < this.casos.length; index++) {
        fechas = this.casos[index].fecha_recibido;
        array = fechas.split("-");
        fecha_format = array[2] + "-" + array[1] + "-" + array[0];
        this.casos[index].fecha_recibido = fecha_format;
      }
    },
    nuevocaso() {
      window.location.href = "nuevo-caso";
    },
    cerrar_caso_asignado() {
      $("#caso-asignado").modal("hide");
    },
    gestionar_caso_modal_cerrar() {
      $("#gestion-caso").modal("hide");
    },
  },
};
</script>
