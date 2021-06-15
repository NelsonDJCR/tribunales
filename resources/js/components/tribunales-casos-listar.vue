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
              <div class="col-8 col-md-8 col-lg-8 col-xl-8 p-2">
                <h1 class="text-blue"><b>LISTADO DE CASOS</b></h1>
              </div>
              <div class="col-4 p-3">
                <button
                  @click="nuevocaso"
                  class="btn-general btn-warning btn w-80 btn_search text-white"
                >
                  Nuevo Caso
                </button>
                <!-- </a> -->
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
              <td>{{ i.estado_nombre }}</td>
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
                  @click="cerrar_modal_g"
                ></button>
              </div>
              <div class="modal-body">
                <input type="hidden" v-model="gestion.id" id="idgestion" />
                <div class="mb-3 col-12">
                  <label for="" class="form-label"><b>Estado</b></label>
                  <select
                    class="form-select obliGes"
                    name=""
                    data-label="El estado es requerido"
                    id="estado"
                    disabled
                  >
                    <option value="">Asignado</option>
                  </select>
                </div>
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
                <div class="mb-3 col-12">
                  <label for="" class="form-label"
                    ><b
                      >Observación
                      <nav></nav></b
                  ></label>
                  <textarea
                    maxlength="499"
                    cols="30"
                    rows="10"
                    class="form-control"
                    style="height: 150px"
                    v-model="gestion.observacion"
                  ></textarea>
                </div>
                <div class="mt-4 col-12">
                  <center>
                    <button
                      class="btn btn-secondary active w-50 ml-25"
                      id="guardarGestionar"
                      @click="gestionarCaso"
                    >
                      Guardar
                    </button>
                  </center>
                </div>
              </div>
              <div class="modal-footer"></div>
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
    <template v-if="pantalla == 'nuevo'">
      <div>
        <nuevo-caso />
      </div>
    </template>
  </div>
</template>

<script>
export default {
  data() {
    return {
      departamentos: [],
      documentos: [],
      estados: [],
      tramites: [],
      tipoArchivo: [],
      tribunales: [],
      estado1: [],
      usuarios: [],
      magistrados: [],
      casos: [],
      caso: {},
      posicion: -1,
      gestion: {
        id: 0,
        estado: "",
        asesor: "",
        msg: "",
        observacion: "",
        tribunal: "",
        id_magistrado: "",
      },
      id: 0,
      pantalla: "",
    };
  },
  mounted() {
    this.pantalla = "listado";
  },
  created() {
    let url = "/listado-casos-data";
    axios.post(url).then((res) => {
      this.departamentos = res.data.departamento;
      this.estados = res.data.estado;
      this.tramites = res.data.tramite;
      this.casos = res.data.casos;
      this.estado1 = res.data.estado1;
      this.tipoArchivo = res.data.tipoArchivo;
      this.usuarios = res.data.usuarios;
      this.tribunales = res.data.tribunales;
      console.log(this.usuarios);
      this.formatearFecha();
    });
  },
  methods: {
    abrir_modal_config(caso, index) {
      (this.gestion = {
        id: 0,
        estado: "",
        asesor: "",
        msg: "",
        observacion: "",
      }),
        (this.gestion.id = caso.id);
      this.gestion.estado = caso.id_estado;
      //   this.gestion.asesor = caso.id_asesor_asignado;
      this.posicion = index;
      $("#gestion-caso").modal("show");
    },
    magistradoxdepartamento(id) {
      let url = "/magistradoxdepartamento/" + id;
      axios.get(url).then((res) => {
        this.magistrados = res.data.magistrados;
        // console.log(this.magistrados);
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
    //   return
      if (
        this.gestion.id != 0 &&
        this.gestion.observacion != "" &&
        this.gestion.tribunal != '' &&
        this.gestion.id_magistrado != ''
      ) {
        let url = "/asignar-caso";
        let gestion = this.gestion;
        axios.post(url, gestion).then((res) => {
          // console.log(res.data);
          this.casos.splice(this.posicion, 1);
          Swal.fire("¡Editado!", res.data.msg, "success");
          setTimeout(function () {
            $("#gestion-caso").modal("hide");
          }, 500);
        });
      } else {
        Swal.fire("¡Advertencia!", "Completa todos los campos.", "warning");
      }
    },
    cambiarVer(id) {
      this.id = id;
      this.pantalla = "ver";
    },
    filtrar() {
      let url = "filtrar-casos";
      let filtros = this.caso;
      axios.post(url, filtros).then((res) => {
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
      //   window.location.href = "nuevo-caso";
      this.pantalla = "nuevo";
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

