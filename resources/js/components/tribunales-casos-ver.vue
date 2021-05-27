<template>
  <div class="main col-12" id="sesion">
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0"
      crossorigin="anonymous"
    />

    <div class="container mt-5">
      <!-- Breadcrumb -->
      <ol class="breadcrumb">
          <li class="breadcrumb-item active"><router-link :to="{ name: 'home'}"><span>Home</span></router-link> / <label for="" class="p-2">Tribunales de Garantia / Listado de casos / Ver caso </label></li>
      </ol>
      <div class="row p-2 text-center border shadow rounded-3">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-10 col-xl-10 p-2">
                <h2 class="text-blue"><b>VISUALIZACIÓN DEL CASO</b></h2>
            </div>
            <div class="col-12 col-md-12 col-lg-2 col-xl-2 p-2">
                <router-link :to='`/tribunales/listado-de-pqrs`' @click.native="$router.go()" class="btn btn-secondary active text-white w-100 mt-2">Volver al listado</router-link>
            </div>
        </div>

      </div>

      <form @submit.prevent="save">
        <section v-if="!loading">
        <div class="row">
          <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-5">
            <h3 class="mb-2 text-secondary"><b>Detalles del caso</b></h3>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Tipo de tramite</b></label>
                <input
                    type="text"
                    class="form-control"
                    id=""
                    name=""
                    :placeholder="dataCaso.data.tramite"
                    disabled
                  />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"
                  ><b>Fecha de elección</b>
                </label>
                <div class="input-group">
                  <input
                    type="date"
                    class="form-control"
                    :value="dataCaso.data.fecha_eleccion"
                    disabled
                  />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Tipo de elección</b></label>
                <input
                    type="text"
                    class="form-control"
                    id=""
                    name=""
                    :placeholder="dataCaso.data.eleccion"
                    disabled
                  />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Prioridad</b></label>
                <input
                    type="text"
                    class="form-control"
                    id=""
                    name=""
                    :placeholder="dataCaso.data.prioridad"
                    disabled
                  />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"
                  ><b>Fecha de recibido</b>
                </label>
                <div class="input-group">
                  <input
                    type="date"
                    class="form-control"
                    :value="dataCaso.data.fecha_recibido"
                    disabled
                  />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Medio de recepción</b></label>
                <input
                    type="text"
                    class="form-control"
                    id=""
                    name=""
                    :placeholder="dataCaso.data.recepcion"
                    disabled
                  />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Correo de notificación</b></label>
                <input
                    type="text"
                    class="form-control"
                    id=""
                    name=""
                    :placeholder="dataCaso.data.correo_notificacion"
                    disabled
                  />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Informante anónimo</b></label>
                <input
                    type="text"
                    class="form-control"
                    id=""
                    name=""
                    :placeholder="[[ dataCaso.data.informante_anonimo === 0 ? 'Anónimo' : dataCaso.data.informante_anonimo ]]"
                    disabled
                  />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Departamento</b></label>
                  <select
                    disabled
                    class="form-select"
                    name="dep_id"
                    id="dep_id"
                  >
                    <option value="" selected>{{ dataCaso.data.departamento }}</option>
                  </select>
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Municipio</b></label>
                  <select
                    disabled
                    class="form-select"
                    name=""
                    id=""
                  >
                    <option value="" selected>{{ dataCaso.data.ciudad }}</option>
                  </select>
              </div>
            </div>

          </div>

          <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-5">
            <div class="row mb-3 hidden-sm">
                <br/>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Dirección</b></label>
                <input
                    type="text"
                    class="form-control"
                    id=""
                    name=""
                    :placeholder="dataCaso.data.direccion"
                    disabled
                  />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Barrio</b></label>
                <input
                    type="text"
                    class="form-control"
                    id=""
                    name=""
                    :placeholder="dataCaso.data.barrio"
                    disabled
                  />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"
                  ><b>Fecha inicio</b>
                </label>
                <div class="input-group">
                  <input
                    type="date"
                    class="form-control"
                    :value="dataCaso.data.fecha_inicio"
                    disabled
                  />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"
                  ><b>Fecha fin</b>
                </label>
                <div class="input-group">
                  <input
                    type="date"
                    class="form-control"
                    :value="dataCaso.data.fecha_fin"
                    disabled
                  />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Puesto de votación</b></label>
                <input
                    type="text"
                    class="form-control"
                    id=""
                    name=""
                    :placeholder="dataCaso.data.puesto_votacion"
                    disabled
                  />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Mesa de votación</b></label>
                <input
                    type="text"
                    class="form-control"
                    id=""
                    name=""
                    :placeholder="dataCaso.data.mesa_votacion"
                    disabled
                  />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Asunto</b></label>
                <input
                    type="text"
                    class="form-control"
                    id=""
                    name=""
                    :placeholder="dataCaso.data.asunto"
                    disabled
                  />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Hechos</b></label>
                <textarea class="form-control" id="" rows="8" :placeholder="dataCaso.data.hechos" disabled></textarea>
              </div>
            </div>

          </div>
        </div>

        <div class="row">

          <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-3">
            <h3 class="mb-2 text-secondary"><b>Datos del solicitante</b></h3>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Nombres y apellidos del solicitante</b></label>
                <input
                    type="text"
                    class="form-control"
                    id=""
                    name=""
                    :placeholder="dataCaso.data.nombres_solicitante+' '+dataCaso.data.apellidos_solicitante"
                    disabled
                  />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Tipo de identificación</b></label>
                  <select
                    disabled
                    class="form-select"
                    name=""
                    id=""
                  >
                    <option value="" selected>{{ dataCaso.data.identification  }}</option>
                  </select>
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Número de Identificacíon</b></label>
                <input
                    type="text"
                    class="form-control"
                    id=""
                    name=""
                    :placeholder="dataCaso.data.num_identificacion"
                    disabled
                  />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Departamento de residencia</b></label>
                <div class="input-group">
                  <select
                    disabled
                    class="form-select"
                    name=""
                    id=""
                  >
                    <option value="" selected>{{ dataCaso.data.departamento_residencia }}</option>
                  </select>
                </div>
              </div>
            </div>

          </div>

          <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-3">
            <div class="row mb-3 hidden-sm">
                <br/>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"
                  ><b>Municipio de residencia</b>
                </label>
                <div class="input-group">
                  <select
                    disabled
                    class="form-select"
                    name=""
                    id=""
                  >
                    <option value="" selected>{{ dataCaso.data.municipio_residencia }}</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Dirección de residencia</b></label>
                <input
                    type="text"
                    class="form-control"
                    id=""
                    name=""
                    :placeholder="dataCaso.data.direccion_residencia"
                    disabled
                  />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Telefóno de residencia</b></label>
                <input
                    type="number"
                    class="form-control"
                    id=""
                    name=""
                    :placeholder="dataCaso.data.telefono"
                    disabled
                  />
              </div>
            </div>
          </div>

        </div>


        <!--div v-for="display in dataCaso.data.caso" :key="display.id">
            <span v-text="display.caso | ifInArray"></span>
        </div-->

        <div class="row" v-if="dataCaso.data.caso.length">

          <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-3">
            <h3 class="mb-2 text-secondary"><b>Gestión</b></h3>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Estado</b></label>
                <input
                    type="text"
                    class="form-control"
                    id=""
                    name=""
                    :placeholder="lastStepInfo.estadocaso"
                    disabled
                  />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Asesor asignado</b></label>
                <input
                    type="text"
                    class="form-control"
                    id=""
                    name=""
                    :placeholder="lastStepInfo.asesor"
                    disabled
                  />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Fecha de asignación</b></label>
                <div class="input-group">
                  <input
                    type="date"
                    class="form-control"
                    :value="lastStepInfo.fecha_gestion"
                    disabled
                  />
                </div>
              </div>
            </div>

          </div>

          <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-3">
            <div class="row mb-3 hidden-sm">
                <br/>
            </div>
            <div class="row">
              <div class="mb-3" v-if="lastStepInfo.updated_at">
                <label for="" class="form-label"
                  ><b>Fecha de respuesta</b>
                </label>
                <div class="input-group">
                  <input
                    type="date"
                    class="form-control"
                    :value="lastStepInfo.updated_at"
                    disabled
                  />
                </div>
              </div>
            </div>

            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Respuesta</b></label>
                <textarea class="form-control" id="" rows="5" :placeholder="lastStepInfo.gestion" disabled></textarea>
              </div>
            </div>
          </div>

        </div>

        <div class="row" v-if="dataCaso.data.caso.length">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-3">
               <h3 class="mb-2 text-secondary"><b>Trazabilidad</b></h3>
               <div class="row">
                   <table class="table table-bordered table-striped table-lg">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">Estado</th>
                                <th scope="col" class="w-50 ">Gestión</th>
                                <th scope="col">Asesor</th>
                                <th scope="col">Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(i, index) in dataCaso.data.caso" :key="index">
                                <th scope="row">{{ i.estadocaso }}</th>
                                <td>{{ i.gestion }}</td>
                                <td>{{ i.asesor }}</td>
                                <td>{{ i.fecha_gestion }}</td>
                            </tr>
                        </tbody>
                    </table>
               </div>
            </div>

        </div>
        </section>
      </form>
    </div>

    <div
      class="modal fade"
      id="modal_file"
      data-bs-backdrop="static"
      data-bs-keyboard="false"
      tabindex="-1"
      aria-labelledby="staticBackdropLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">
              Agregar Documentos
            </h5>
            <button
              type="button"
              class="btn-close"
              @click="closeAddFile()"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <div class="row mb-2">
              <div class="col-11">
                <label class="form-label">Agrege todos los documentos</label>
              </div>
              <div class="col-1">
                <button
                  class="btn-more btn"
                  id="add_file"
                  @click="add_file()"
                  type="button"
                >
                  <!-- <i class="fas fa-plus"></i> -->
                  <i class="typcn typcn-document-add" style="color: green"></i>
                </button>
              </div>
            </div>
            <div class="col-12" id="box_files"></div>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-primary"
              @click="closeAddFile()"
            >
              Aceptar
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
// $('body').on('click', '.delete_file', function() {
//   $(this).parent().parent().remove();
// });
export default {
  props: ['id'],
  data() {
    return {
      idCaso: this.id,
      dataCaso:[],
      type_file: [],
      ciudades: [],
      departament: [],
      data_record: {},
      data: {},
      documentos: [],
      lastStepInfo: {},
      index: 0,
      loading: false
    };
  },
  filters: {

  },
  methods: {
    changeCity() {
      var id = $("#departamento_id").val();
      axios.post("/changeCity", { id: id }).then((r) => {
        this.ciudades = r.data;
      });
    },
    assignedLastStep() {
        var lastPosition = this.dataCaso.data.caso.length - 1;
        if(lastPosition > 0){
            this.lastStepInfo = this.dataCaso.data.caso[lastPosition];
        }else{
            this.lastStepInfo = this.dataCaso.data.caso[0];
        }
        console.log('in' + this.lastStepInfo);
        return this.lastStepInfo;
    },
    ifInArray: function (value) {
            return this.dataCaso.data.indexOf(value) > -1 ? 'Yes' : 'No';
    },
    /*async method function*/
        /*
            this.departament = r.data.departamentos;
            this.ciudades = r.data.ciudades;
            this.type_file = r.data.tipo_archivos;
        */
        /*try {
            // This will wait until promise resolve
            const response = await axios.get('/tribunales/casos-listar/${this.idCaso}');
            this.dataCaso = response.data;
            console.log(this.dataCaso);
        } catch(error) {
            console.log(error)
        }*/

  },
  created() {
      this.loading = true;
        this.idCaso = this.id;

        axios.get(`/tribunales/casos-listar/${this.idCaso}`).then((r) => {
            this.dataCaso = r.data;
            console.log(this.dataCaso);
            this.loading = false;

            /*if(this.dataCaso.includes(r.data.data.caso)){
                alert("Value exists!")
                } else{
                    alert("Value does not exists!")
            }*/

            this.assignedLastStep();
        });

      //this.loadCaso(this.idCaso);
  }
};
</script>
