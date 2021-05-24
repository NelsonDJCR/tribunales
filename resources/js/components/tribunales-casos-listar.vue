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
        <!--template v-if="action == 0"-->
          <div class="container mt-5">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><router-link :to="{ name: 'home'}"><span>Home</span></router-link> / <label for="" class="p-2">Tribunales de Garantía / Listado de casos</label></li>
            </ol>
            <div class="row p-2 text-center border shadow rounded-3">
              <div class="row">
                <div class="col-12 col-md-12 col-lg-12 col-xl-12 p-2">
                  <h1 class="text-blue"><b>LISTADO DE CASOS</b></h1>
                </div>

              </div>
            </div>
            <form @submit.prevent="filter">
              <div class="row mt-5">
                <div class="mb-3 col-3">
                  <label for="" class="form-label"><b>Tipo de Trámite</b></label>
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
                    class="form-select"
                    name=""
                    id=""
                  >
                    <option value="">Selecciona</option>
                    <option>Status</option>
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
          <table class="table table-bordered table-striped table-sm fnt-hd-sm" id="datos">
            <thead class="text-center align-middle">
              <th>Opciones</th>
              <th>Tipo de Trámite</th>
              <th>Prioridad</th>
              <th>Fecha recibido</th>
              <th>Departamento</th>
              <th>Municipio</th>
              <th>Solicitante</th>
              <th>Estado</th>
              <th>Usuario Asignado</th>
            </thead>
            <tbody>
              <!-- v-for="(i, index) in cabildos" :key="index" -->

              <tr v-for="(i, index) in casos" :key="index">
                <td>{{ i.asunto }}</td>
                <td>{{ i.asunto }}</td>
                <td>{{ i.asunto }}</td>
                <td>{{ i.asunto }}</td>
                <td>{{ i.asunto }}</td>
                <td>{{ i.asunto }}</td>
                <td>{{ i.apellidos_solicitante }}</td>
                <td>{{ i.asunto }}</td>
                <td>{{ i.asunto }}</td>
              </tr>
            </tbody>
          </table>
        <!--/template-->

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
              <form><!-- @submit.prevent="exportPdf" v-model="dataPdf.cabildo_id"-->
                <input
                  type="hidden"
                  name=""
                  id="casos_id"

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
                        <!--select
                            class="form-select"
                            name="type_file"
                        >
                            <option
                            v-for="(i, index) in type_file"
                            :key="index"
                            :value="i.id"
                            v-text="i.nombre"
                            ></option>
                        </select-->
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

    <template v-if="pantalla == 'ver'">
      <div>
        <tribunales-casos-ver></tribunales-casos-ver>
      </div>
    </template>
  </div>
</template>

<script>
export default {
  data() {
    return {
      idCaso: 0,
      action: 0,
      pantalla: "lista",
      departament: [],
      ciudades: [],
      type_file: [],
      dataFilter: {},
      tabla: [],
      casos: [],
      idEditar: 0,
      datos_edit: {},
      arrayCaso: [],
      listado: 1,
      tituloFormulario: "",
      tipoAccion: 0,
      errorFormulario: 0,
      errorMensajesFormularios: [],
      pagination: {
        total: 0,
        current_page: 0,
        per_page: 0,
        last_page: 0,
        from: 0,
        to: 0,
      },
    };
  },
  methods: {
    pantallaVer(){
          this.pantalla = 'ver'
    },
    /*changeCity() {
      var id = $("#departamento_id").val();
      axios.post("/changeCity", { id: id }).then((r) => {
        this.ciudades = r.data;
      });
    },*/
    filter() {
      /*let filtros = this.dataFilter;
      axios.post("/filter-list-cabildos", filtros).then((r) => {
        console.log(r.data.cabildos);
        this.cabildos = r.data.cabildos;
      });*/
    },
    loadCasos(){
        //axios.get('/tribunales/casos-listar').then(response => this.casos = response.data);

        /*try {
            // This will wait until promise resolve
            const response = await axios.get('/tribunales/casos-listar');
            this.casos = response.casos.data;
            console.log(this.casos);
        } catch(error) {
            console.log(error)
        }
        */
        if (axios == null) {
            console.log(('NULL RESULT'));
            return;
        }

        axios.get('/tribunales/casos-listar').then((res)=>{
            // alert(res);
            // this.casos=res.casos.data;

            if(res.status === 200){
                // alert('working');
                this.casos=res.data.casos.data;
                console.log('Data = ');
                console.log(res.data.casos.data);
                // alert(this.casos);
            }

        }).catch(err=>{
            // console.log('error');
            console.log(err);
        });

    }
  },
  created() {
      /*  axios.get(`/tribunales/casos-listar`).then((r) => {
            this.casos = r.casos;
            console.log(this.casos);
        });
        */
    this.loadCasos();
  },
};
</script>





