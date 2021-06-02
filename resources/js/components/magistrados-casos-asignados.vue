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
                FORM FILTROS
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
            </thead>
            <tbody>
              <!-- v-for="(i, index) in cabildos" :key="index" -->

              <tr v-for="(i, index) in casos" :key="index">
                <td class="aling_btn_options">

                  <button
                    type="button"
                    @click="modalShowAssign(i.id, i.id_estado, i.id_asesor_asignado)"
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

                  <!--button
                    type="button"
                    class="btn btn-warning btn-sm"
                  >
                    <i class="typcn typcn-download cl-white"></i>
                  </button-->
                </td>
                <td>{{ i.tramite }}</td>
                <td>{{ i.prioridad }}</td>
                <td>{{ i.fecha_recibido }}</td>
                <td style="word-wrap: break-word; max-width: 120px;">{{ i.departamento_nombre }}</td>
                <td>{{ i.ciudad_nombre }}</td>
                <td>{{ i.nombres_solicitante }} {{ i.apellidos_solicitante }}</td>
                <td><span class="badge badge-primary badge-outline-secondary">{{ i.estado }}</span></td>
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
            </div>
          </div>
        </div>
      </div>
    </template>

    <template v-if="pantalla == 'ver'">
      <div>
        <magistrados-casos-asignados-ver :id="idCaso" :key="$route.fullPath"></magistrados-casos-asignados-ver>
      </div>
    </template>
  </div>
</template>

<script>
export default {
  data() {
    return {
      departament: [],
      ciudades: [],
      type_file: [],
      casos: [],
      action: 0,
      pantalla: 'lista',
    };
  },
  created() {

  },
  methods: {
    pantallaVer(x){
        this.idCaso = x;
        this.pantalla = 'ver'
    },
    loadCasos(page){

        if (axios == null) {
            console.log(('NULL RESULT'));
            return;
        }

        let queryString = this.objectToQueryString(this.dataFilter), fullStr;

        if(queryString !== null){
            //fullStr = "?page="+page+"&"+queryString+"&buscar="+this.dataFilter.buscar;
            fullStr = "?page="+page;
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

        if(queryString !== null && page !== undefined){
            fullStr = "?page="+page+"&"+queryString+"&buscar="+this.dataFilter.buscar;
        }else{
            fullStr = '';
        }

        axios.get('/tribunales/casos-listar'+fullStr).then((res)=>{

            if(res.status === 200){
                this.casos=res.data.casos.data;
                this.departament = res.data.departamentos;
                this.pagination = res.data.pagination;
            }

        }).catch(err=>{
            console.log(err);
        });
    },

  },
  mounted() {
    this.loadEstados();
    this.loadTipoTramites();
  },
  created() {
    this.loadCasos();
  },
};
</script>
