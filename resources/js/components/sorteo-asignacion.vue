<template>
  <div>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0"
      crossorigin="anonymous"
    />
    <template v-if="pantalla == 'lista'">
      <div class="main col-12">
        <template>
          <div class="container mt-5">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
              <li class="breadcrumb-item active">
                <router-link :to="{ name: 'home' }"
                  ><span>Home</span></router-link
                >
                /
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
                  <button
                    @click="nuevo_sorteo"
                    class="btn btn-warning text-white w-100 mt-2"
                  >
                    Nuevo Sorteo
                  </button>
                </div>
              </div>
            </div>
            <form @submit.prevent="sendFilter">
              <div class="row mt-5">
                <div class="mb-3 col-3">
                  <label for="" class="form-label"><b>Sorteo</b></label>
                  <input
                    type="text"
                    class="form-control"
                    id="nombre_tema"
                    name="nombre_tema"
                    v-model="filter.sorteo"
                  />
                </div>
                <div class="mb-3 col-3">
                  <label for="" class="form-label"><b>Magistrado</b></label>
                  <input
                    type="text"
                    class="form-control"
                    id="nombre_tema"
                    name="nombre_tema"
                    v-model="filter.magistrado"
                  />
                </div>

                            <div class="mb-3 col-3">
                                <label for="" class="form-label"><b>Tribunal</b></label>
                                <input type="text" class="form-control" id="" name="" v-model="filter.tribunal" />
                            </div>

                            <div class="mb-3 col-3">
                                <label for="" class="form-label"><b>Tipo de elección</b></label>

                                <select class="form-select" v-model="filter.id_tipo_eleccion">
                                    <option value="">Seleccione ...</option>
                                    <option v-for="(i, index) in tipo_eleccion" :key="index" v-text="i.nombre" :value="i.id"></option>
                                </select>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-3">
                                    <button type="submit" class="btn-secondary active btn w-80 btn_search w-100">
                                        Buscar
                                    </button>
                                </div>
                                <div class="mb-5 col-9"></div>
                            </div>
                        </div>
                    </form>
                </div>
                <table class="table table-bordered table-striped" id="datos">
                    <thead>
                        <th>Opciones</th>
                        <th>id</th>
                        <th>Sorteo</th>
                        <th>Fecha</th>
                    </thead>
                    <tbody>
                        <tr v-for="(i, index) in tabla" :key="index">
                            <button
                              type="button"
                              @click="editar(i.id)"
                              class="btn btn-info btn-sm"
                            >
                              <i class="typcn typcn-edit" style="color: white"></i>
                            </button>
                            <td>{{ i.nombre }}</td>
                            <td>{{ i.magistrado }}</td>
                            <td>{{ i.tribunal }}</td>
                        </tr>
                    </tbody>
                </table>
            </template>
            <div class="modal fade" id="modal_new" role="dialog" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="staticBackdropLabel">
                                Nuevo sorteo
                            </h3>
                            <button type="button" class="btn-close" @click="closeModalNew()" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row mb-2">
                                <div class="mb-3">
                                    <label for="" class="form-label"><b>Nombre del Sorteo</b></label>
                                    <input type="text" class="form-control" id="" v-model="nuevoSorteo.nombre" name="" />
                                </div>

                <div class="mb-3 col-3">
                  <label for="" class="form-label"
                    ><b>Tipo de elección</b></label
                  >

                  <select class="form-select" v-model="filter.id_tipo_eleccion">
                    <option value="">Seleccione ...</option>
                    <option
                      v-for="(i, index) in tipo_eleccion"
                      :key="index"
                      v-text="i.nombre"
                      :value="i.id"
                    ></option>
                  </select>
                </div>
            </div>
        </div>
    </template>
    <template v-if="pantalla = 'agregar_cantidad'">
        <div class="main col-12" id="sesion">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous" />

            <div class="container mt-5">
                <!-- Breadcrumb -->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active">
                        <router-link :to="{ name: 'home' }"><span>Home</span></router-link>
                        /
                        <label for="" class="p-2">Tribunales de Garantía / Listado de Actividades / Nueva
                            actividad
                        </label>
                    </li>
                </ol>
                <div class="row p-2 text-center border shadow rounded-3 mb-5">
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-10 col-xl-10 p-2">
                            <h1 class="text-blue"><b>ASIGANAR DEPARTAMENTOS</b></h1>
                        </div>
                        <div class="col-12 col-md-12 col-lg-2 col-xl-2 p-2">
                            <router-link :to="`/tribunales/listado-de-actividades`" @click.native="$router.go()" class="btn btn-danger text-white w-100 mt-2">Cancelar</router-link>
                        </div>
                    </div>
                </div>
              </div>
            </form>
          </div>
          <table class="table table-bordered table-striped" id="datos">
            <thead>
              <th>Opciones</th>
              <th>Sorteo</th>
              <th>Tipo de elección</th>
              <th>Usuario</th>
              <th>Fecha de Asignación</th>
            </thead>
            <tbody>
              <tr v-for="(i, index) in tabla" :key="index">
                <td>
                  <button
                    type="button"
                    class="btn btn-success btn-sm"
                    @click="view(i)"
                  >
                    <i class="typcn typcn-eye"></i>
                  </button>
                </td>
                <td>{{ i.nombre }}</td>
                <td>{{ i.nom_eleccion }}</td>
                <td>
                  <select
                    class="form-control bg-transparent text-dark"
                    v-model="i.usuario"
                    disabled
                    style="outline: none"
                  >
                    <option
                      v-for="(item, index) in usuarios"
                      :key="index"
                      :value="item.id"
                      v-text="item.nombre"
                    ></option>
                  </select>
                </td>
                <td>{{ i.fecha }}</td>
              </tr>
            </tbody>
          </table>
        </template>
        <div
          class="modal fade"
          id="modal_new"
          role="dialog"
          data-bs-backdrop="static"
          data-bs-keyboard="false"
          tabindex="-1"
          aria-labelledby="staticBackdropLabel"
          aria-hidden="true"
        >
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h3 class="modal-title" id="staticBackdropLabel">
                  Nuevo sorteo
                </h3>
                <button
                  type="button"
                  class="btn-close"
                  @click="closeModalNew()"
                  data-bs-dismiss="modal"
                  aria-label="Close"
                ></button>
              </div>
              <div class="modal-body">
                <div class="row mb-2">
                  <div class="mb-3">
                    <label for="" class="form-label"
                      ><b>Nombre del Sorteo</b></label
                    >
                    <input
                      type="text"
                      class="form-control"
                      id=""
                      v-model="nuevoSorteo.nombre"
                      name=""
                    />
                  </div>

                  <div class="mb-3">
                    <label for="" class="form-label"
                      ><b>Tipo de elección</b></label
                    >
                    <select
                      class="form-select"
                      v-model="nuevoSorteo.id_tipo_eleccion"
                    >
                      <option value="">Seleccione ...</option>
                      <option
                        v-for="(i, index) in tipo_eleccion"
                        :key="index"
                        v-text="i.nombre"
                        :value="i.id"
                      ></option>
                    </select>
                  </div>
                </div>
                <div class="col-12" id="box_files"></div>
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
                  <button
                    @click="sorteo"
                    type="button"
                    class="btn btn-secondary active"
                  >
                    Sortear
                  </button>
                </div>
              </div>
            </div>
        </div>
    </template>
    <template v-if="pantalla == 'nuevo'">
      <div>
        <nuevo-sorteo />
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
      filter: {},
      nuevoSorteo: {},
      pantalla: "lista",
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
        // console.log(r.data);
      });
    },
    nuevo_sorteo() {
      this.pantalla = "nuevo";
    },
    view(i){

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
        title: "¿Sortear Magistrados?",
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
