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
    <div class="container mt-5">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active">
          <router-link :to="{ name: 'home' }"><span>Home</span></router-link> /
          <label for="" class="p-2">Sistema Uriel / Nuevo caso </label>
        </li>
      </ol>
      <div class="row p-2 text-center border shadow mb-2 rounded-3">
        <div class="col-sm-10">
          <h1 class="text-blue"><b>NUEVO DE CASO</b></h1>
        </div>
        <div class="col-sm-2">
          <button
            class="btn btn-warning btn-block text-white mt-2"
            @click="regresar"
          >
            Regresar
          </button>
        </div>
      </div>

      <form @submit.prevent="crearCaso" method="POST" id="frmCaso">
        <div class="row mt-5">
          <h4><b>Detalles del caso</b></h4>
        </div>
        <div class="row">
          <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-2">
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Tipo de trámite</b></label>
                <select
                  class="form-select obliCaso"
                  name="id_tipo_tramite"
                  v-model="caso.id_tipo_tramite"
                  data-label="El tipo de trámite es requerido"
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
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"
                  ><b>Fecha de elección</b></label
                >
                <input
                  type="date"
                  class="form-control obliCaso"
                  name="fecha_eleccion"
                  data-label="La fecha de elección es requerida"
                  v-model="caso.fecha_eleccion"
                />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Tipo de elección</b></label>
                <select
                  class="form-select obliCaso"
                  name="id_tipo_eleccion"
                  v-model="caso.id_tipo_eleccion"
                  data-label="El tipo de elección es requerido"
                >
                  <option value="">Seleccione ...</option>
                  <option
                    v-for="(i, index) in eleccion"
                    :key="index"
                    :value="i.id"
                    v-text="i.nombre"
                  ></option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Prioridad</b></label>
                <select
                  class="form-select obliCaso"
                  name="id_prioridad"
                  data-label="la prioridad es requerida"
                  v-model="caso.id_prioridad"
                >
                  <option value="">Seleccione ...</option>
                  <option
                    v-for="(i, index) in prioridad"
                    :key="index"
                    :value="i.id"
                    v-text="i.nombre"
                  ></option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"
                  ><b>Fecha de recibido</b>
                </label>
                <div class="input-group">
                  <input
                    id="date"
                    type="date"
                    name="fecha_recibido"
                    class="form-control obliCaso"
                    data-label="La fecha de recibido es requerida"
                    v-model="caso.fecha_recibido"
                  />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"
                  ><b>Medio de recepción</b></label
                >
                <select
                  class="form-select obliCaso"
                  name="id_medio_recepcion"
                  v-model="caso.id_medio_recepcion"
                  data-label="El medio de recepción es requerido"
                >
                  <option value="">Seleccione ...</option>
                  <option
                    v-for="(i, index) in recepcion"
                    :key="index"
                    :value="i.id"
                    v-text="i.nombre"
                  ></option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"
                  ><b>Correo de notificación</b></label
                >
                <input
                  type="email"
                  class="form-control obliCaso"
                  id=""
                  maxlength="80"
                  name="correo_notificacion"
                  data-label="El correo de notificación es requerido"
                  v-model="caso.correo_notificacion"
                />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"
                  ><b>Informante anónimo</b></label
                >
                <select
                  class="form-select obliCaso"
                  name="informante_anonimo"
                  data-label="El informante anónimo es requerido"
                  v-model="caso.informante_anonimo"
                >
                  <option value="">Seleccione ...</option>
                  <option value="Si">Si</option>
                  <option value="No">No</option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Departamento</b></label>
                <select
                  class="form-select obliCaso"
                  name="id_departamento"
                  v-model="caso.id_departamento"
                  @change="ciudadxdepartamento(1)"
                  data-label="El departamento es requerido"
                >
                  <option value="">Seleccione ...</option>
                  <option
                    v-for="(i, index) in departamento"
                    :key="index"
                    :value="i.id"
                    v-text="i.nombre"
                  ></option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Ciudad</b></label>
                <select
                  class="form-select obliCaso"
                  name="id_ciudad"
                  data-label="La ciudad es requerida"
                  v-model="caso.id_ciudad"
                >
                  <option value="">Seleccione ...</option>
                  <option
                    v-for="(i, index) in ciudad"
                    :key="index"
                    :value="i.id"
                    v-text="i.nombre"
                  ></option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"
                  ><b>Abono asunto anterior</b></label
                >
                <input
                  type="text"
                  class="form-control"
                  v-model="caso.abono_asunto_anterior"
                  max="2500"
                />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"
                  ><b>Entidades informadas</b></label
                >
                <input
                  type="text"
                  class="form-control"
                  v-model="caso.entidades_informadas"
                  max="2500"
                />
              </div>
            </div>
            <div class="row mb-3">
              <label for="" class="form-label mt-3"
                ><b>Link de soporte</b></label
              >
              <input
                type="text"
                class="form-control"
                v-model="caso.link_soporte"
                max="5000"
              />
            </div>
          </div>
          <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-2">
            <div class="row">
              <label for="" class="form-label"><b>Dirección</b></label>
              <input
                type="text"
                class="form-control obliCaso"
                id=""
                name="direccion"
                data-label="la dirección es requerida"
                v-model="caso.direccion"
                maxlength="190"
              />
            </div>
            <div class="row mt-3">
              <label for="" class="form-label"><b>Barrio</b></label>
              <input
                type="text"
                class="form-control obliCaso"
                id=""
                name="barrio"
                data-label="El barrio es requerido"
                maxlength="190"
                v-model="caso.barrio"
              />
            </div>
            <div class="row mt-3">
              <label for="" class="form-label"><b>Fecha inicio</b></label>
              <input
                type="date"
                class="form-control obliCaso"
                id=""
                name="fecha_inicio"
                data-label="La fecha inicio es requerida"
                v-model="caso.fecha_inicio"
              />
            </div>
            <div class="row mt-3">
              <label for="" class="form-label"><b>Fecha fin</b></label>
              <input
                type="date"
                class="form-control obliCaso"
                id=""
                name="fecha_fin"
                data-label="la fecha fin es requerida"
                v-model="caso.fecha_fin"
              />
            </div>
            <div class="row mt-3">
              <label for="" class="form-label"><b>Puesto de votación</b></label>
              <input
                type="text"
                class="form-control obliCaso"
                id=""
                name="puesto_votacion"
                maxlength="190"
                data-label="El puesto de votación es requerido"
                v-model="caso.puesto_votacion"
              />
            </div>
            <div class="row mt-3">
              <label for="" class="form-label"><b>Mesa de votación</b></label>
              <input
                type="text"
                class="form-control obliCaso"
                id=""
                name="mesa_votacion"
                data-label="la mesa de votación es requerida"
                v-model="caso.mesa_votacion"
                maxlength="190"
              />
            </div>
            <div class="row mt-3">
              <label for="" class="form-label"><b>Asunto</b></label>
              <input
                type="text"
                class="form-control obliCaso"
                id=""
                name="asunto"
                data-label="El asunto es requerido"
                v-model="caso.asunto"
                maxlength="190"
              />
            </div>
            <div class="row mb-3">
              <label for="" class="form-label mt-3"><b>Hechos</b></label>
              <textarea
                class="form-control obliCaso"
                placeholder=""
                id=""
                name="hechos"
                data-label="Los hechos son requeridos"
                style="height: 210px"
                v-model="caso.hechos"
                maxlength="190"
              ></textarea>
            </div>
          </div>
          <div class="row mt-5 mb-3">
            <h4><b>Datos del solicitante</b></h4>
          </div>
          <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-2">
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"
                  ><b>Nombres y apellidos del solicitante</b></label
                >
                <input
                  type="text"
                  class="form-control obliCaso"
                  id=""
                  maxlength="190"
                  name="nombres_solicitante"
                  data-label="Los nombres y apellidos son requeridos"
                  v-model="caso.nombres_solicitante"
                />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"
                  ><b>Tipo de identificación</b></label
                >
                <select
                  class="form-select obliCaso"
                  name="id_tipo_identificacion"
                  v-model="caso.id_tipo_identificacion"
                  data-label="El tipo de identificación es requerida"
                >
                  <option value="">Seleccione ...</option>
                  <option
                    v-for="(i, index) in identificacion"
                    :key="index"
                    :value="i.id"
                    v-text="i.nombre"
                  ></option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"
                  ><b>Número de identificación</b></label
                >
                <input
                  type="text"
                  class="form-control obliCaso"
                  id=""
                  maxlength="50"
                  name="numero_identificacion"
                  data-label="El número de identificación es requerida"
                  v-model="caso.numero_identificacion"
                />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"
                  ><b>Departamento de residencia</b></label
                >
                <select
                  class="form-select obliCaso"
                  name="id_departamento_recidencia"
                  v-model="caso.id_departamento_recidencia"
                  data-label="El departamento es requerido"
                  @change="ciudadxdepartamento(2)"
                >
                  <option value="">Seleccione ...</option>
                  <option
                    v-for="(i, index) in departamento"
                    :key="index"
                    :value="i.id"
                    v-text="i.nombre"
                  ></option>
                </select>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-2">
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"
                  ><b>Ciudad de residencia</b></label
                >
                <select
                  class="form-select obliCaso"
                  name="id_ciudad_recidencia"
                  v-model="caso.id_ciudad_recidencia"
                  data-label="La ciudad es requerida"
                >
                  <option value="">Seleccione ...</option>
                  <option
                    v-for="(i, index) in ciudad_solicitante"
                    :key="index"
                    :value="i.id"
                    v-text="i.nombre"
                  ></option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"
                  ><b>Dirección de residencia</b></label
                >
                <input
                  type="text"
                  class="form-control obliCaso"
                  id=""
                  name="direccion_recidencia"
                  data-label="La dirección es requerida"
                  v-model="caso.direccion_recidencia"
                  maxlength="190"
                />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"
                  ><b>Teléfono de residencia</b></label
                >
                <input
                  type="text"
                  class="form-control obliCaso"
                  id=""
                  name="telefono"
                  data-label="El teléfono es requerido"
                  v-model="caso.telefono"
                  maxlength="30"
                />
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <button
            class="btn btn-secondary active w-25"
            type="submit"
            id="guardarCaso"
          >
            Guardar Caso
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      caso: {},
      tramites: [],
      eleccion: [],
      prioridad: [],
      recepcion: [],
      departamento: [],
      ciudad: [],
      ciudad_solicitante: [],
      identificacion: [],
      pantalla: 'listado',
    };
  },
  created() {
    let url = "/nuevo-caso-data";
    axios.post(url).then((res) => {
      this.tramites = res.data.tramite;
      this.eleccion = res.data.eleccion;
      this.prioridad = res.data.prioridad;
      this.recepcion = res.data.recepcion;
      this.departamento = res.data.departamento;
      this.identificacion = res.data.identificacion;
    });
  },
  methods: {
    regresar() {
        // alert('llego')
      this.$emit("pantalla", this.pantalla);
    },
    ciudadxdepartamento(option) {
      if (option == 1) {
        let id = this.caso.id_departamento;
        let url = "ciudadxdepartamento/" + id;
        axios.post(url).then((res) => {
          this.ciudad = res.data;
        });
      } else {
        let id = this.caso.id_departamento_recidencia;
        let url = "ciudadxdepartamento/" + id;
        axios.post(url).then((res) => {
          this.ciudad_solicitante = res.data;
        });
      }
    },
    crearCaso() {
      let url = "guardar-caso";
      let caso = this.caso;
      axios
        .post(url, caso)
        .then((res) => {
          if (res.data.status == 200) {
            let url2 = "guardar-trazabilidad/" + res.data.id;
            axios.post(url2, caso).then((res) => {});
            Swal.fire("¡Agregado!", res.data.msg, "success").then(function () {
              location.reload();
            });
          } else {
            Swal.fire("¡Error!", res.data.msg, "error");
          }
        })
        .catch((error) => {
          let object = error.response.data.errors;
          console.log(object);
          for (const property in object) {
            console.log(object[property][0]);
            Swal.fire("¡Error!", object[property][0], "error");
            return;
          }
        });
    },
  },
};
</script>
