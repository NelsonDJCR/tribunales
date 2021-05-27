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
            <form @submit.prevent="filter(filterid)">
              <div class="row mt-5">
                <div class="mb-3 col-3">
                  <label for="" class="form-label"><b>Tipo de Trámite</b></label>
                  <!--input
                    type="text"
                    class="form-control"
                    id="tipo_tramite"
                    name="tipo_tramite"
                    v-model="dataFilter.nombre_tema"
                  /-->
                  <!--v-model="dataFilter.tramite_id"-->
                  <select
                    class="form-select"
                    name="tramite_id"
                    id="tramite_id"
                    v-model="dataFilter.tramite_id"
                    >
                        <option value="" selected>Selecciona</option>
                        <option
                            v-for="(i, index) in tptramites"
                            :key="index"
                            v-text="i.nombre"
                            :value="i.id"
                        ></option>
                    </select>
                </div>
                <div class="mb-3 col-3">
                  <label for="" class="form-label"><b>Fecha recibido</b></label>
                  <input
                    type="date"
                    class="form-control"
                    id="fecha_realizacion"
                    v-model="dataFilter.fecha_recibido"
                  />
                </div>

                <div class="mb-3 col-3">
                  <label for="" class="form-label"><b>Departamento</b></label>
                  <select
                    v-model="dataFilter.departamento_id"
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
                    v-model="dataFilter.estado_id"
                  >
                    <option value="">Seleccionas</option>
                    <option
                            v-for="(i, index) in estados"
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
                <td class="aling_btn_options">

                  <button
                    type="button"
                    @click="modalShowAssign(i.id, i.id_estado)"
                    class="btn btn-secondary btn-sm"
                  >
                    <i
                      class="typcn typcn-cog cl-white"
                    ></i>
                  </button>
                  <button
                    type="button"
                    class="btn btn-success btn-sm"
                    @click="pantallaVer(i.id)"
                  >
                    <i class="typcn typcn-eye"></i>
                  </button>

                  <button
                    type="button"
                    class="btn btn-warning btn-sm"
                  >
                    <i class="typcn typcn-download cl-white"></i>
                  </button>
                </td>
                <td>{{ i.tramite }}</td>
                <td>{{ i.prioridad }}</td>
                <td>{{ i.fecha_recibido }}</td>
                <td style="word-wrap: break-word; max-width: 120px;">{{ i.departamento_nombre }}</td>
                <td>{{ i.ciudad_nombre }}</td>
                <td>{{ i.nombres_solicitante }} {{ i.apellidos_solicitante }}</td>
                <td><span class="badge badge-primary badge-outline-secondary">{{ i.estado }}</span></td>
                <td>{{ i.asesor_asignado }}</td>
              </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="9">
                        <nav class="mt-3">
                            <ul class="pagination justify-content-center">
                                <li v-if="pagination.current_page > 1" class="page-item">
                                    <a class="page-link btn-secondary active" href="#" @click.prevent="changePage(pagination.current_page - 1)">
                                        <span>Atras</span></a>
                                </li>
                                <li v-for="page in pagesNumber" v-bind:key="page">
                                    <a class="page-link" href="#" @click.prevent="changePage(page)" v-bind:class="[ page == isActived ? 'nav-item text-white btn-secondary active' : 'nav-item text-dark bg-white' ]">
                                        {{ page }}
                                    </a>
                                </li>
                                <li v-if="pagination.current_page < pagination.last_page" class="page-item">
                                    <a class="page-link btn-secondary active" href="#" @click.prevent="changePage(pagination.current_page + 1)">
                                        <span>Siguiente</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </td>
                </tr>
            </tfoot>
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
              <form @submit.prevent="saveAssignement"><!-- v-model="saveAssignement"-->
                <input
                  type="hidden"
                  name="casoID"
                  id="casoAssign_id"
                  v-model="datos_assign.casoID"
                />
                <div class="modal-body">
                  <div class="mb-3 col-12">
                    <label for="" class="form-label"><b>Asignar a:</b></label>
                    <input
                      type="hidden"
                      required
                      class="form-control"
                      id="casoAssignUser_id"

                    />
                    <select name="casoUser_id" v-model="datos_assign.userID"
                        class="form-select"
                    >
                        <option value="1">user 1</option>
                        <option value="2">user 2</option>
                    </select>
                  </div>
                  <div class="mb-3 col-12">
                    <label for="" class="form-label"><b>Estado</b></label>
                    <!--input
                      type="text"
                      required
                      class="form-control"
                      v-model="dataPdf.radicado"
                    /-->
                    <select name="casoAssignEstado_id" v-model="stateCaso"
                        class="form-select" disabled
                    >
                        <option
                            v-for="(i, index) in estados"
                            :key="index"
                            v-text="i.nombre"
                            :value="i.id"
                            :selected="i.id == stateCaso"
                        ></option>
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
                        <textarea class="form-control"  v-model="datos_assign.gestionDetails" id="" rows="5"></textarea>
                    </div>
                    <!--

                    <div class="mb-3 col-12">
                        <label for="" class="form-label"
                            ><b>Tipo de archivo</b></label
                        >
                        select
                            class="form-select"
                            name="type_file"
                        >
                            <option
                            v-for="(i, index) in type_file"
                            :key="index"
                            :value="i.id"
                            v-text="i.nombre"
                            ></option>
                        </select
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

                    -->
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
        <tribunales-casos-ver :id="idCaso"></tribunales-casos-ver>
      </div>
    </template>
  </div>
</template>

<script>
export default {
  data() {
    return {
      idCaso: 0,
      idCasoAssign: 0,
      action: 0,
      pantalla: "lista",
      departament: [],
      ciudades: [],
      type_file: [],
      dataFilter: {},
      filterid : 0,
      tabla: [],
      casos: [],
      estados: [],
      tptramites: [],
      stateCaso: 0,
      datos_assign: {},
      listado: 1,
      tituloFormulario: "",
      tipoAccion: 0,
      errorFormulario: 0,
      errorMensajesFormularios: [],
      page: 0,
      offset: 3,
      pagination: {
        total: 0,
        current_page: 0,
        per_page: 0,
        last_page: 0,
        from: 0,
        to: 0
        },
    };
  },
  methods: {
    pantallaVer(x){
        this.idCaso = x;
          this.pantalla = 'ver'
    },
    changeCity() {
      var id = $("#departamento_id").val();
      axios.post("/changeCity", { id: id }).then((r) => {
        this.ciudades = r.data;
      });
    },
    objectToQueryString(obj) {
        var str = [];
        for (var p in obj)
            if (obj.hasOwnProperty(p)) {
            str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
            }
        return str.join("&");
    },
    filter(filt) {
      let filtros = this.dataFilter;
      filtros.buscar = filt;

      //let queryString = this.objectToQueryString(filtros);

        this.loadCasos(1);
        /*axios.get("/tribunales/casos-listar?"+queryString+"&buscar="+filt).then((res) => {
        //axios.post("/tribunales/casos-listar", filtros).then((res) => {
            this.casos=res.data.casos.data;
            this.pagination = res.data.pagination;
            //console.log(this.casos);
        });*/
    },
    modalShowAssign(id, state) {
      this.idCasoAssign = id;
      this.stateCaso = state;
      $("#casoAssign_id").val(id);
      this.datos_assign.casoID = this.idCasoAssign;
      //console.log('caso '+ this.idCasoAssign + 'estado'+ this.stateCaso  );
      $("#modal_export").modal("show");
    },
    saveAssignement(){
        //let datos = this.datos_assign;
        let url = "/tribunales/casos-asignar/"+this.idCasoAssign;
        this.datos_assign.estadoID = this.stateCaso;

        var datos = new  FormData();

        datos.append('caso', this.idCasoAssign);
        datos.append('estado_caso', this.datos_assign.estadoID);
        datos.append('asesor_asignado', this.datos_assign.userID);
        datos.append('gestion', this.datos_assign.gestionDetails);


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
    loadEstados(){
        const url = "/resources/estados/";
        axios.get(url).then((r) => {
            this.estados = r.data.data;
        });
    },
    loadTipoTramites(){
        const url = "/resources/tipotramites/";
        axios.get(url).then((r) => {
            this.tptramites = r.data.data;
        });
    },
    loadCasos(page){

        if (axios == null) {
            console.log(('NULL RESULT'));
            return;
        }

        let queryString = this.objectToQueryString(this.dataFilter), fullStr;

        if(queryString !== null){
            fullStr = "?page="+page+"&"+queryString+"&buscar="+this.dataFilter.buscar;
        }else{
            fullStr = '?page='+page;
        }

        axios.get('/tribunales/casos-listar?page='+page+'&'+queryString).then((res)=>{

            if(res.status === 200){
                this.casos=res.data.casos.data;
                //console.log('Data = ');
                console.log(res.data);
                this.departament = res.data.departamentos;
                this.pagination = res.data.pagination;
            }

        }).catch(err=>{
            console.log(err);
        });

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

    },
    changePage: function(page) {
        this.pagination.current_page = page;
        this.loadCasos(page);
        //console.log('changed page: '+page)
    }
  },
  mounted() {
    this.loadEstados();
    this.loadTipoTramites();
  },
  created() {
    this.loadCasos();
  },
  computed: {
    isActived: function() {
        console.log(this.pagination);
        console.log('isActived called');
        return this.pagination.current_page;
    },
    pagesNumber: function() {
        if(!this.pagination.to){
            return [];
        }

        var from = this.pagination.current_page - this.offset;
        if(from < 1){
            from = 1;
        }

        var to = from + (this.offset * 2);
        if(to >= this.pagination.last_page){
            to = this.pagination.last_page;
        }

        var pagesArray = [];
        while(from <= to){
            pagesArray.push(from);
            from++;
        }
        return pagesArray;
    }
  },
  watch: {
        'dataFilter.tramite_id': function() {
            //console.log('called change tramite');
            this.filterid = 1;
        },
        'dataFilter.estado_id': function() {
            //console.log('called change estado');
            this.filterid = 4;
        },
        'dataFilter.fecha_recibido': function() {
            //console.log('called change fecha');
            this.filterid = 2;
        },
        'dataFilter.departamento_id': function() {
            //console.log('called change dpartamento');
            this.filterid = 3;
        },
    }
};
</script>
