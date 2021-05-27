<template>
  <div>
    <template>
      <div class="main col-12">
        <link
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css"
          rel="stylesheet"
          integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0"
          crossorigin="anonymous"
        />
        <template>
          <div class="container mt-5">
              <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><router-link :to="{ name: 'home'}"><span>Home</span></router-link> / <label for="" class="p-2">Tribunales de Garantía / Sorteo de Asignación  </label></li>
            </ol>
            <div class="row p-2 text-center border shadow rounded-3">
              <div class="row">
                <div class="col-12 col-md-12 col-lg-10 col-xl-10 p-2">
                  <h1 class="text-blue"><b>SORTEO DE ASIGNACIÓN</b></h1>
                </div>
                <div class="col-12 col-md-12 col-lg-2 col-xl-2 p-2">
                  <button
                  @click="openModalNew"
                    class="btn btn-warning text-white w-100 mt-2"
                    >Nuevo Sorteo</button
                  >
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
                  <input
                    type="text"
                    class="form-control"
                    id=""
                    name=""
                    v-model="filter.tribunal"
                  />
                </div>

                <div class="mb-3 col-3">
                  <label for="" class="form-label"><b>Tipo de elección</b></label>
                  
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
                </div>
              </div>
            </form>
          </div>
          <table class="table table-bordered table-striped" id="datos">
            <thead>
              <th>Sorteo</th>
              <th>Nombre de magistrado</th>
              <th>Tribunal</th>
              <th>Tipo de elección</th>
              <th>Fecha de Asignación</th>
            </thead>
            <tbody>
              <tr v-for="(i, index) in tabla" :key="index">
                <td>{{ i.nombre }}</td>
                <td>{{ i.magistrado }}</td>
                <td>{{ i.tribunal }}</td>
                <td>{{ i.tipo_eleccion }}</td>
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
                    <label for="" class="form-label"><b>Nombre del Sorteo</b></label>
                    <input
                        type="text"
                        class="form-control"
                        id=""
                        v-model="nuevoSorteo.nombre"
                        name=""
                    />
                  </div>

                  <div class="mb-3">
                    <label for="" class="form-label"><b>Tipo de elección</b></label>
                    <select class="form-select" v-model="nuevoSorteo.id_tipo_eleccion">
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
                        <button  @click="sorteo" type="button" class="btn btn-secondary active">
                            Sortear
                        </button>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </template>

   
  </div>
</template>

<script>



export default {
  data() {
    return {
      tabla: [],
      tipo_eleccion: [],
      filter: {},
      nuevoSorteo: {},
    };
  },
  created() {
    this.tablaReload()
  },
  methods: {
    tablaReload(){
        axios.get('/listar-sorteos').then((r) => {
        this.tabla = r.data.tabla;
        this.tipo_eleccion = r.data.tipo_eleccion;
      });
    },
    openModalNew() {
      $("#modal_new").modal("show");
    },
    closeModalNew() {
      $("#modal_new").modal("hide");
      this.nuevoSorteo.nombre = ""
      this.nuevoSorteo.id_tipo_eleccion = ""
    },
    sendFilter(){
      axios.post('/filtro-sorteo', this.filter).then((r)=>{
        this.tabla=r.data.tabla;
      })
    },
    sorteo(){
      Swal.fire({
      title: '¿Sortear Magistrados?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Aceptar',
      cancelButtonText: 'Cancelar'
      }).then((result) => {
      if (result.value) {
        axios.post('/nuevo-sorteo', this.nuevoSorteo).then((r) => {
          if(r.data.code == 200){
            Swal.fire(r.data.msg, '', 'success');
            this.tablaReload()
            this.closeModalNew()
          }else if (r.data.code == 406){
            Swal.fire(r.data.msg, '', 'warning');
          }else if (r.data.code == 407){
            Swal.fire(r.data.msg, '', 'warning');
            this.closeModalNew()
          }
        });
      }
      });
    }
  },
};
</script>
