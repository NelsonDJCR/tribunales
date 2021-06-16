<template>
  <div>
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
              <h5 class="modal-title" id="exampleModalToggleLabel">Modal 1</h5>
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

      <!-- Inicio modal descargar archivos -->

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
                Sistema uriel
              </h5>
              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
                @click="cerrar_modal_s"
              ></button>
            </div>
            <div class="modal-body">
              <div
                v-for="(i, index) in documentos"
                :key="index"
                class="row container mb-2"
              >
                <div class="col-10">
                  <select
                    class="form-select"
                    id="tipo"
                    disabled
                    v-model="i.id_tipo_documento"
                  >
                    <option
                      v-for="(i, index) in tipoArchivo"
                      :key="index"
                      :value="i.id"
                      v-text="i.nombre"
                    ></option>
                  </select>
                </div>
                <div class="col-2">
                  <a
                    class="btn-self btn btn-warning text-white"
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
                @click="cerrar_modal_s"
              >
                Cerrar
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Fin modal descargar archivos -->

      <div class="main col-12">
        <div class="container mt-5">
          <!-- <label class="p-2">Sistema Uriel/Listado de casos</label> -->
          <ol class="breadcrumb">
            <li class="breadcrumb-item active">
              <router-link :to="{ name: 'home' }"
                ><span>Home</span></router-link
              >
              /
              <label for="" class="p-2"
                >Sistema Uriel / Listado de casos
              </label>
            </li>
          </ol>
          <div class="row p-2 text-center border shadow rounded-3">
            <div class="row">
              <div class="col-12">
                <h1 class="text-blue"><b>HISTÓRICO DE CASOS</b></h1>
              </div>
            </div>
          </div>
          <form id="filter_list">
            <div class="row mt-5">
              <div class="mb-3 col-3">
                <label for="" class="form-label"><b>Tipo de trámite</b></label>
                <select
                  class="form-select"
                  name="id_tramite"
                  v-model="filtros.tramite"
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
                  v-model="filtros.fecha_recibido"
                />
              </div>
              <div class="mb-3 col-3">
                <label for="" class="form-label"><b>Departamento</b></label>
                <select
                  class="form-select"
                  name="id_departamento"
                  v-model="filtros.departamento"
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
                <select
                  class="form-select"
                  name="estado"
                  v-model="filtros.estado"
                >
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
                type="button"
                @click="filtrar"
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
              <th>Usuario asignado</th>
              <th>Estado</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(i, index) in casos" :key="index">
              <td class="aling_btn_options w-20">
                <button
                  class="btn btn-secondary btn-sm"
                  @click="abrir_modal_config(i, index)"
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
              <td>
                <select
                  class="form-control text-dark bg-transparent"
                  disabled
                  v-model="i.id_magistrado"
                  style="outline: none;"
                >
                  <option
                    v-for="(item, index) in magistrados1"
                    :key="index"
                    :value="item.id"
                    v-text="item.nombre"
                  ></option>
                </select>
              </td>
              <td>{{ i.estado_nombre }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </template>
    <template v-if="pantalla == 'ver'">
      <div>
        <tribunales-casos-ver @pantalla="pantalla = $event" :id="id" />
      </div>
    </template>
    <!-- Inicio modal gestionar con archivo -->
    <div
      class="modal fade"
      id="gestion-caso-file"
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
              @click="cerrar_modal_gestionar_caso_admin"
            ></button>
          </div>
          <div class="modal-body">
            <input type="hidden" id="idgestion" />
            <div class="mb-3 col-12">
              <label for="" class="form-label"><b>Estado</b></label>
              <select
                name=""
                id=""
                class="form-select"
                v-model="gestion.estado"
              >
                <option value="">Seleccione</option>
                <option
                  v-for="(i, index) in estados"
                  :key="index"
                  :value="i.id"
                  v-text="i.nombre"
                ></option>
              </select>
            </div>
            <!-- <div class="mb-3 col-12" v-if="gestion.estado == 2">
              <label for="" class="form-label"><b>Asesor</b></label>
              <select
                name=""
                id=""
                class="form-select"
                v-model="gestion.asesor"
              >
                <option value="">Seleccione</option>
                <option v-for="(i,index) in personas" :key="index" :value="i.id" v-text="i.nombre"></option>
              </select>
            </div> -->
            <div class="mb-3 col-12">
              <label for="" class="form-label"><b>Tribunales</b></label>
              <select
                class="form-select obliGes"
                name=""
                data-label="El asesor es requerido"
                id="asesor"
                v-model="gestion.tribunal"
                @click="magistradoxdepartamento(gestion.tribunal)"
              >
                <option value="">Seleccione ...</option>
                <option
                  v-for="(i, index) in tribunales"
                  :key="index"
                  :value="i.id"
                  v-text="i.nombre"
                ></option>
              </select>
              <!-- <span style="color: red" v-text="gestion.msg"></span> -->
            </div>

            <div class="mb-3 col-12">
              <label for="" class="form-label"><b>Magistrados</b></label>
              <select
                class="form-select obliGes"
                name=""
                data-label="El asesor es requerido"
                id="asesor"
                v-model="gestion.magistrado"
              >
                <option value="">Seleccione ...</option>
                <option
                  v-for="(i, index) in magistrados"
                  :key="index"
                  :value="i.id"
                  v-text="i.nombre"
                ></option>
              </select>
              <!-- <span style="color: red" v-text="gestion.msg"></span> -->
            </div>
            <div
              class="mb-3 col-12"
              v-if="gestion.estado == 3 || gestion.estado == 4"
            >
              <label for="" class="form-label"><b>Tipo de archivo</b></label>
              <select
                name=""
                id=""
                class="form-select"
                v-model="gestion.tipoArchivo"
              >
                <option value="">Seleccione</option>
                <option
                  :value="i.id"
                  v-text="i.nombre"
                  v-for="(i, index) in tipoArchivo"
                  :key="index"
                ></option>
              </select>
            </div>
            <div
              class="mb-3 col-12"
              v-if="gestion.estado == 3 || gestion.estado == 4"
            >
              <div class="row mt-5">
                <div
                  class="form-group files border"
                  role="button"
                  @click="box_file"
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
                id="file"
                @change="upload_file"
              />
              <div class="row mb-3">
                <div class="row">
                  <div class="col-10">{{ archivo.name }}</div>
                  <div class="col-2">
                    <button
                      v-if="archivo.name != ''"
                      class="btn btn-danger btn-sm"
                      @click="eliminar_archivo()"
                    >
                      <i class="fas fa-trash"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>
            <div class="mb-3 col-12">
              <label for="" class="form-label" v-if="gestion.estado != 4"
                ><b>Observaciones</b></label
              >
              <label for="" class="form-label" v-else><b>Respuesta</b></label>
              <textarea
                name="observacion"
                id="observacion"
                class="form-control obliGesCaso"
                data-label="Las observaciones son requeridas"
                style="height: 150px"
                v-model="gestion.observacion"
              ></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <div class="row mt-2 col-12">
              <button
                class="btn btn-secondary active w-50 ml-25"
                id="guardarGestionar"
                @click="gestionar_caso"
              >
                Guardar
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Fin modal gestionar con archivo -->
  </div>
</template>

<script>
export default {
  data() {
    return {
      departamentos: [],
      documentos: [],
      estados: [],
      personas: [],
      tribunales: [],
      tramites: [],
      magistrados: [],
      filtros: {
        tramite: "",
        fecha_recibido: "",
        departamento: "",
        estado: "",
      },
      tipoArchivo: [],
      estado1: [],
      magistrados1: [],
      archivo: { name: "" },
      casos: [],
      caso: {},
      gestion: {
        id: 0,
        estado: "",
        asesor: "",
        msg: "",
        index: 0,
        observacion: "",
        tipoArchivo: "",
        tribunal: "",
        magistrado: '',
      },
      id: 0,
      pantalla: "",
    };
  },
  mounted() {
    this.pantalla = "listado";
  },
  created() {
    let url = "/listado-historico-casos-data";
    axios.post(url).then((res) => {
      this.departamentos = res.data.departamento;
      this.estados = res.data.estado;
      this.tramites = res.data.tramite;
      this.casos = res.data.casos;
      this.estado1 = res.data.estado1;
      this.tipoArchivo = res.data.tipoArchivo;
      this.magistrados1 = res.data.magistrados;
      this.tribunales = res.data.tribunales;
    //   console.log(res.data);
      this.formatearFecha();
    });
  },
  methods: {
    cerrar_modal_gestionar_caso_admin() {
      $("#gestion-caso-file").modal("hide");
    },
    eliminar_archivo() {
      this.archivo = { name: "" };
    },
    upload_file(event) {
      this.archivo = event.target.files[0];
      console.log(this.archivo);
    },
    abrir_modal_config(caso, index) {
      this.gestion.id = caso.id;
      this.gestion.estado = caso.id_estado;
      this.gestion.asesor = caso.id_asesor_asignado;
      this.gestion.index = index;
      this.gestion.tipoArchivo = caso.tipoArchivo;
      $("#gestion-caso-file").modal("show");
    },
    gestionar_caso() {
      let url = "/gestionar_caso_estados";
      if (this.gestion.estado == 3 || this.gestion.estado == 4) {
        var formulario = new FormData();
        formulario.append("id", this.gestion.id);
        formulario.append("estado", this.gestion.estado);
        formulario.append("tipoArchivo", this.gestion.tipoArchivo);
        formulario.append("archivo", this.archivo);
        formulario.append("observacion", this.gestion.observacion);
        if (this.gestion.estado == "3" && this.gestion.observacion == "") {
          Swal.fire(
            "¡Advertencia!",
            "Completa todos los campos requeridos",
            "warning"
          );
          return;
        }
        if (
          this.gestion.estado == "4" &&
          (this.gestion.observacion == "" ||
            this.gestion.tipoArchivo == "" ||
            this.archivo.name == "" ||
            this.gestion.observacion == "")
        ) {
          Swal.fire("¡Advertencia!", "Completa todos los campos", "warning");
          return;
        }
        axios.post(url, formulario).then((res) => {
          if (this.gestion.estado == 3) {
            this.casos[this.gestion.index].estado_nombre = "En trámite";
          } else {
            this.casos[this.gestion.index].estado_nombre = "Finalizado";
          }
          setTimeout(function () {
            $("#gestion-caso-file").modal("hide");
          }, 500);
          Swal.fire("¡Agregado!", res.data.msg, "success");
        });
        return;
      }
      if (this.gestion.estado == "1" && this.gestion.observacion == "") {
        Swal.fire("¡Advertencia!", "Completa todos los campos", "warning");
        return;
      }
      if (
        this.gestion.estado == "2" &&
        (this.gestion.observacion == "" || this.gestion.tribunal == "" && this.gestion.magistrado)
      ) {
        Swal.fire("¡Advertencia!", "Completa todos los campos", "warning");
        return;
      }
      axios.post(url, this.gestion).then((res) => {
        if (res.data.caso.id_estado == 1) {
          this.casos[this.gestion.index].estado_nombre = "Recibido";
          setTimeout(function () {
            $("#gestion-caso-file").modal("hide");
          }, 500);
          Swal.fire("¡Agregado!", res.data.msg, "success");
        }
        if (res.data.caso.id_estado == 2) {
          this.casos[this.gestion.index].estado_nombre = "Asignado";
          this.casos[this.gestion.index].id_asesor_asignado =
          this.casos[this.gestion.index].id_magistrado = this.gestion.magistrado
            res.data.caso.id_asesor_asignado;
          setTimeout(function () {
            $("#gestion-caso-file").modal("hide");
          }, 500);
          Swal.fire("¡Agregado!", res.data.msg, "success");
        }
        // if(res.data.caso.id_estado == 3){

        // }
      });
    },
    modal_archivos(caso) {
      let url = "/documentos-x-casos/" + caso.id;
      axios.post(url).then((res) => {
        this.documentos = res.data;
        if (this.documentos.length == 0) {
          Swal.fire(
            "¡Advertencia!",
            "Este caso no tiene archivos cargados",
            "warning"
          );
        } else {
          $("#modal_download").modal("show");
        }
        // $("#modal_download").modal("show");
      });
    },
    gestionarCaso() {
      console.log(this.gestion);
      if (
        this.gestion.asesor != "" &&
        this.gestion.id != 0 &&
        this.gestion.observacion != ""
      ) {
        let url = "/asignar-caso";
        let gestion = this.gestion;
        axios.post(url, gestion).then((res) => {
          this.casos = res.data.casos;
          Swal.fire("¡Editado!", res.data.msg, "success");
          setTimeout(function () {
            $("#gestion-caso").modal("hide");
          }, 500);
        });
      } else {
        Swal.fire("¡Advertencia!", "Completa todos los campos.", "warning");
      }
    },
    box_file() {
      $("#file").trigger("click");
    },
    cambiarVer(id) {
      this.id = id;
      this.pantalla = "ver";
    },
    filtrar() {
      let url = "/filtros_historico_casos";
      axios.post(url, this.filtros).then((res) => {
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
    magistradoxdepartamento(id) {
      let url = "/magistradoxdepartamento/" + id;
      axios.get(url).then((res) => {
        this.magistrados = res.data.magistrados;
        // console.log(this.magistrados);
      });
    },
    cerrar_modal_g() {
      $("#gestion-caso").modal("hide");
    },
    cerrar_modal_s() {
      $("#modal_download").modal("hide");
    },
  },
};
</script>

