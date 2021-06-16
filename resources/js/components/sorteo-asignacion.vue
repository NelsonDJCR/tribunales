<template>
  <div class="main col-12">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet"
     integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous" />

     <template v-if="pantalla == 'lista'">
         <div>
             <ol class="breadcrumb">
                <li class="breadcrumb-item active">
                    <router-link :to="{ name: 'home' }"><span>Home</span></router-link> /
                    <label for="" class="p-2"
                    >Tribunales de Garantía / Sorteo de Asignación
                    </label>
                </li>
            </ol>

                <div class="row p-2 text-center border shadow rounded-3">
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-10 col-xl-10 p-2">
                            <h1 class="text-blue"><b>SORTEO DE ASIGNACIÓN</b></h1>
                        </div>
                        <div class="col-12 col-md-12 col-lg-2 col-xl-2 p-2">
                            <button class="btn btn-warning btn-block text-white" @click="nuevo_sorteo"> Nuevo sorteo </button>
                        </div>
                    </div>
            </div>


            <div class="row mt-4 mb-3">
                <div class="col-3">
                    <label class="form-label" for="">Sorteo</label>
                    <input type="text" class="form-control" v-model="filter.sorteo">
                </div>
                <div class="col-3">
                    <label class="form-label" for="">Tipo de elección</label>
                    <select class="form-select" v-model="filter.id_tipo_eleccion">
                        <option value="">Selecciona</option>
                        <option v-for="(i,index) in tipo_eleccion" :key="index" :value="i.id" v-text="i.nombre"></option>
                    </select>
                </div>
                <div class="col-3">
                    <label class="form-label" for="">Fecha inicio</label>
                    <input type="date" class="form-control" v-model="filter.fecha_inicio">
                </div>
                <div class="col-3">
                    <label class="form-label" for="">Fecha fin</label>
                    <input type="date" class="form-control" v-model="filter.fecha_fin">
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <button class="btn btn-secondary btn-block active" @click="sendFilter()">Buscar</button>
                </div>
            </div>

            <div class="mt-5">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td class="p-2">Opciones</td>
                            <td>Sorteo</td>
                            <td>Tipo de elección</td>
                            <td>Usuario</td>
                            <td>Fecha de asignación</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(i,index) in tabla" :key="index">
                            <td>
                                <button
                                    type="button"
                                    class="btn btn-success btn-sm"
                                    @click="view(i)"
                                >
                    <i class="typcn typcn-eye"></i>
                  </button>
                            </td>
                            <td> {{ i.nombre }}</td>
                            <td> {{ i.nom_eleccion }}</td>
                            <td>
                                <select class="form-control bg-transparent text-dark" style="outline: none;" v-model="i.usuario" disabled>
                                    <option v-for="(i,index) in usuarios" :key="index" :value="i.id" v-text="i.nombre"></option>
                                </select>
                            </td>
                            <td> {{ i.fecha }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
     </template>

<template v-if="pantalla == 'nuevo'">
    <div>
        <nuevo-sorteo />
    </div>
</template>

<template v-if="pantalla == 'ver'">
    <div>
        <ver-sorteo @pantalla="pantalla = $event" :id="id" />
    </div>
</template>
  </div>
</template>

<script>
export default {
  data() {
    return {
      tabla: [],
      usuarios: [],
      tipo_eleccion: [],
      filter: {sorteo: '', id_tipo_eleccion: '', fecha_inicio:'', fecha_fin:''},
      nuevoSorteo: {},
      pantalla: "lista",
      id: 0,
    //   pantalla: "nuevo",
    };
  },
  created() {
    this.tablaReload();
  },
  methods: {
    tablaReload() {
      axios.get("/listar-sorteos").then((r) => {
        this.tabla = r.data.tabla;
        this.tipo_eleccion = r.data.tipo_eleccion;
        this.usuarios = r.data.usuarios;
        this.formatear_fecha();
        console.log(r.data);
        // console.log(r.data);
      });
    },
    nuevo_sorteo() {
      this.pantalla = "nuevo";
    },
    view(i) {
      this.id = i.id;
      this.pantalla = "ver";
    },
    openModalNew() {
      $("#modal_new").modal("show");
    },
    closeModalNew() {
      $("#modal_new").modal("hide");
      this.nuevoSorteo.nombre = "";
      this.nuevoSorteo.id_tipo_eleccion = "";
    },
    sendFilter() {
      axios.post("/filtro-sorteo", this.filter).then((r) => {
        this.tabla = r.data.tabla;
        this.formatear_fecha()
      });
    },
    formatear_fecha() {
      let fecha = "";
      let fecha_format = "";
      let array = [];
      for (let index = 0; index < this.tabla.length; index++) {
        fecha = this.tabla[index].fecha;
        array = fecha.split("-");
        fecha_format = array[2] + "-" + array[1] + "-" + array[0];
        this.tabla[index].fecha = fecha_format;
      }
    },
    sorteo() {
      Swal.fire({
        title: "¿Sortear Funcionarios?",
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "Aceptar",
        cancelButtonText: "Cancelar",
      }).then((result) => {
        if (result.value) {
          axios.post("/nuevo-sorteo", this.nuevoSorteo).then((r) => {
            if (r.data.code == 200) {
              Swal.fire(r.data.msg, "", "success");
              this.tablaReload();
              this.closeModalNew();
            } else if (r.data.code == 406) {
              Swal.fire(r.data.msg, "", "warning");
            } else if (r.data.code == 407) {
              Swal.fire(r.data.msg, "", "warning");
              this.closeModalNew();
            }
          });
        }
      });
    },
  },
};
</script>
