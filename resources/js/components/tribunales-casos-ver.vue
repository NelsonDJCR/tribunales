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
    <div class="container mt-5">
      <label for="" class="p-2"
        >Sistema Uriel/Listado de casos/Visualizar caso</label
      >
      <div class="row p-2 text-center border shadow mb-2">
        <div class="row">
          <h1 class="text-blue"><b>VISUALIZACIÓN DE CASO</b></h1>
        </div>
      </div>

      <div class="row mt-5">
        <h4><b>Detalles del caso</b></h4>
      </div>
      <div class="row">
        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-2">
          <div class="row">
            <div class="mb-3">
              <label for="tramite" class="form-label"
                ><b>Tipo de trámite</b></label
              >
              <input
                id="tramite"
                class="form-control bg-white"
                v-model="caso.tramite_nombre"
                readonly
              />
            </div>
          </div>
          <div class="row">
            <div class="mb-3">
              <label for="fechaelec" class="form-label"
                ><b>Fecha de elección</b></label
              >
              <input
                id="fechaelec"
                class="form-control bg-white"
                v-model="caso.fecha_eleccion"
                readonly
              />
            </div>
          </div>
          <div class="row">
            <div class="mb-3">
              <label for="tipoelec" class="form-label"
                ><b>Tipo de elección</b></label
              >
              <input
                id="tipoelec"
                class="form-control bg-white"
                v-model="caso.eleccion_nombre"
                readonly
              />
            </div>
          </div>
          <div class="row">
            <div class="mb-3">
              <label for="prioridad" class="form-label"><b>Prioridad</b></label>
              <input
                id="prioridad"
                class="form-control bg-white"
                v-model="caso.prioridad_nombre"
                readonly
              />
            </div>
          </div>
          <div class="row">
            <div class="mb-3">
              <label for="fechareci" class="form-label"
                ><b>Fecha de recibido</b>
              </label>
              <input
                id="fechareci"
                class="form-control bg-white"
                v-model="caso.fecha_recibido"
                readonly
              />
            </div>
          </div>
          <div class="row">
            <div class="mb-3">
              <label for="recepcion" class="form-label"
                ><b>Medio de recepción</b></label
              >
              <input
                id="recepcion"
                class="form-control bg-white"
                v-model="caso.recepcion_nombre"
                readonly
              />
            </div>
          </div>
          <div class="row">
            <div class="mb-3">
              <label for="correo" class="form-label"
                ><b>Correo de notificación</b></label
              >
              <input
                id="correo"
                class="form-control bg-white"
                v-model="caso.correo_notificacion"
                readonly
              />
            </div>
          </div>
          <div class="row">
            <div class="mb-3">
              <label for="anonimo" class="form-label"
                ><b>Informante anónimo</b></label
              >
              <input
                id="anonimo"
                class="form-control bg-white"
                v-model="caso.informante_anonimo"
                readonly
              />
            </div>
          </div>
          <div class="row">
            <div class="mb-3">
              <label for="depa" class="form-label"><b>Departamento</b></label>
              <input
                id="depa"
                class="form-control bg-white"
                v-model="caso.dep_nombre"
                readonly
              />
            </div>
          </div>
          <div class="row">
            <div class="mb-3">
              <label for="ciudad" class="form-label"><b>Ciudad</b></label>
              <input
                id="ciudad"
                class="form-control bg-white"
                v-model="caso.ciu_nombre"
                readonly
              />
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-2">
          <div class="row">
            <label for="dire" class="form-label"><b>Dirección</b></label>
            <input
              id="dire"
              class="form-control bg-white"
              v-model="caso.direccion"
              readonly
            />
          </div>
          <div class="row mt-3">
            <label for="barrio" class="form-label"><b>Barrio</b></label>
            <input
              id="barrio"
              class="form-control bg-white"
              v-model="caso.barrio"
              readonly
            />
          </div>
          <div class="row mt-3">
            <label for="fecha_inicio" class="form-label"
              ><b>Fecha inicio</b></label
            >
            <input
              id="fecha_inicio"
              class="form-control bg-white"
              v-model="caso.fecha_inicio"
              readonly
            />
          </div>
          <div class="row mt-3">
            <label for="fecha_fin" class="form-label"><b>Fecha fin</b></label>
            <input
              id="fecha_fin"
              class="form-control bg-white"
              v-model="caso.fecha_fin"
              readonly
            />
          </div>
          <div class="row mt-3">
            <label for="puesto_votacion" class="form-label"
              ><b>Puesto de votación</b></label
            >
            <input
              id="puesto_votacion"
              class="form-control bg-white"
              v-model="caso.puesto_votacion"
              readonly
            />
          </div>
          <div class="row mt-3">
            <label for="mesa_votacion" class="form-label"
              ><b>Mesa de votación</b></label
            >
            <input
              id="mesa_votacion"
              class="form-control bg-white"
              v-model="caso.mesa_votacion"
              readonly
            />
          </div>
          <div class="row mt-3">
            <label for="asunto" class="form-label"><b>Asunto</b></label>
            <input
              id="asunto"
              class="form-control bg-white"
              v-model="caso.asunto"
              readonly
            />
          </div>
          <div class="row mb-3">
            <label for="hechos" class="form-label mt-3"><b>Hechos</b></label>
            <textarea
              class="form-control bg-white"
              id="hechos"
              readonly
              style="height: 210px"
              v-text="caso.hechos"
            ></textarea>
          </div>
        </div>
        <div class="row mt-5 mb-3">
          <h4><b>Datos del solicitante</b></h4>
        </div>
        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-2">
          <div class="row">
            <div class="mb-3">
              <label for="nombres_solicitante" class="form-label"
                ><b>Nombres y apellidos del solicitante</b></label
              >
              <input
                id="nombres_solicitante"
                class="form-control bg-white"
                v-model="caso.nombres_solicitante"
                readonly
              />
            </div>
          </div>
          <div class="row">
            <div class="mb-3">
              <label for="iden" class="form-label"
                ><b>Tipo de identificación</b></label
              >
              <input
                id="iden"
                class="form-control bg-white"
                v-model="caso.tipo_identificacion_nombre"
                readonly
              />
            </div>
          </div>
          <div class="row">
            <div class="mb-3">
              <label for="numero_identificacion" class="form-label"
                ><b>Número de identificación</b></label
              >
              <input
                id="numero_identificacion"
                class="form-control bg-white"
                v-model="caso.numero_identificacion"
                readonly
              />
            </div>
          </div>
          <div class="row">
            <div class="mb-3">
              <label for="depa_resi" class="form-label"
                ><b>Departamento de recidencia</b></label
              >
              <input
                id="depa_resi"
                class="form-control bg-white"
                v-model="caso.dep_nombre_residencia"
                readonly
              />
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-2">
          <div class="row">
            <div class="mb-3">
              <label for="ciu_resi" class="form-label"
                ><b>Ciudad de recidencia</b></label
              >
              <input
                id="ciu_resi"
                class="form-control bg-white"
                v-model="caso.ciu_nombre_residencia"
                readonly
              />
            </div>
          </div>
          <div class="row">
            <div class="mb-3">
              <label for="direccion_recidencia" class="form-label"
                ><b>Dirección de recidencia</b></label
              >
              <input
                id="direccion_recidencia"
                class="form-control bg-white"
                v-model="caso.direccion_recidencia"
                readonly
              />
            </div>
          </div>
          <div class="row">
            <div class="mb-3">
              <label for="telefono" class="form-label"
                ><b>Teléfono de recidencia</b></label
              >
              <input
                id="telefono"
                class="form-control bg-white"
                v-model="caso.telefono"
                readonly
              />
            </div>
          </div>
        </div>

        <div class="row mt-5 mb-3">
          <h4><b>Gestión</b></h4>
        </div>

        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-4">
          <div class="row">
            <div class="mb-3">
              <label for="ciu_resi" class="form-label"><b>Estado</b></label>
              <input
                id="ciu_resi"
                class="form-control bg-white"
                v-model="caso.estado_nombre"
                readonly
              />
            </div>
          </div>
          <div class="row">
            <div class="mb-3">
              <label for="direccion_recidencia" class="form-label"
                ><b>Asesor asignado</b></label
              >
              <input
                id="direccion_recidencia"
                class="form-control bg-white"
                v-model="caso.id_asesor_asignado"
                readonly
              />
            </div>
          </div>
          <div class="row">
            <div class="mb-3">
              <label for="telefono" class="form-label"
                ><b>Fecha de asignación</b></label
              >
              <input
                type="date"
                id="telefono"
                class="form-control bg-white"
                v-model="caso.fecha_gestion"
                readonly
              />
            </div>
          </div>
        </div>

        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-2">
          <div class="row mt-3">
            <label for="fecha_inicio" class="form-label"
              ><b>Fecha de respuesta</b></label
            >
            <input
              type="date"
              id="fecha_inicio"
              class="form-control bg-white"
              v-model="caso.fecha_respuesta"
              readonly
            />
          </div>
          <div class="row mb-3">
            <label for="hechos" class="form-label mt-3"><b>Respuesta</b></label>
            <textarea
              class="form-control bg-white"
              id="hechos"
              readonly
              maxlength="5000"
              style="height: 210px"
              v-text="caso.gestion"
            ></textarea>
          </div>
        </div>
        <div class="mt-5">
          <table
            class="table table-striped table-hover text-center table-bordered"
          >
            <thead>
              <tr>
                <th>Estado</th>
                <th>Gestión</th>
                <th>Asesor</th>
                <th>Fecha</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(i, index) in trazabilidad" :key="index">
                <td>{{ i.estado_nombre }}</td>
                <td>{{ i.gestion }}</td>
                <td>{{ i.id_asesor_asignado }}</td>
                <td>{{ i.fecha_gestion }}</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="col-3">
          <button
            @click="enviarData"
            class="btn btn-secondary active btn-block"
          >
            Regresar
          </button>
        </div>
        <div class="col-9"></div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: ["id"],
  data() {
    return {
      caso: {},
      pantalla: "listado",
      trazabilidad: [],
    };
  },
  created() {
    let data = this.id;
    let url = "/ver-caso/" + data;
    axios.get(url).then((res) => {
      this.caso = res.data.caso[0];
      this.trazabilidad = res.data.trazabilidad;
      this.formatearFecha();
      console.log(this.caso);
    });
  },
  methods: {
    enviarData() {
      this.$emit("pantalla", this.pantalla);
    },
    formatearFecha() {
      var fechas = "";
      var fecha_format = "";
      var array = [];
      for (let index = 0; index < this.trazabilidad.length; index++) {
        fechas = this.trazabilidad[index].fechaGestion;
        array = fechas.split("-");
        array[2] = array[2].split(" ")[0];
        fecha_format = array[2] + "-" + array[1] + "-" + array[0];
        this.trazabilidad[index].fechaGestion = fecha_format;
      }
    },
  },
};
</script>
