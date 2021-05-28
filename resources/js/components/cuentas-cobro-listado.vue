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
        <!-- <template v-if="action == 0"> -->
          <div class="container mt-5">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><router-link :to="{ name: 'home'}"><span>Home</span></router-link> / <label for="" class="p-2">Tribunales de Garantía / Listado de cuentas de cobro </label></li>
            </ol>
            <div class="row p-2 text-center border shadow rounded-3">
              <div class="row">
                <div class="col-12 col-md-12 col-lg-10 col-xl-10 p-2">
                  <h1 class="text-blue"><b>LISTADO DE CUENTAS DE COBRO</b></h1>
                </div>
                <div class="col-12 col-md-12 col-lg-2 col-xl-2 p-2">
                  <button
                    @click="pantallaNuevo"
                    class="btn btn-warning text-white w-100 mt-2"
                  >
                    Nueva cuenta
                  </button>
                </div>
              </div>
            </div>
            <form @submit.prevent="filter">
              <div class="row mt-5">
                <div class="mb-3 col-3">
                  <label for="" class="form-label"><b>Tema</b></label>
                  <input
                    type="text"
                    class="form-control"
                    id="nombre_tema"
                    name="nombre_tema"
                    v-model="dataFilter.nombre_tema"
                  />
                </div>
                <div class="mb-3 col-3">
                  <label for="" class="form-label"><b>Fecha</b></label>
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
                  <label for="" class="form-label"><b>Magistrado</b></label>
                  <input
                    type="text"
                    class="form-control"
                    id=""
                    name=""
                    v-model="dataFilter.nombre_tema"
                  />
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
          <table class="table table-bordered table-striped table-sm" id="datos">
            <thead>
              <th>Opciones</th>
              <th>Tribunal</th>
              <th>Magistrado</th>
              <th>Fecha inicio</th>
              <th>Fecha fin</th>
              <th>Valor Honorario</th>
              <th>N° de días</th>
              <th>Neto a pagar</th>
            </thead>
            <tbody>
              <!--  -->
              <tr v-for="(i, index) in table" :key="index">
                <td class="aling_btn_options" style="width:190px;">

                  <button
                    type="button"
                    @click="editar()"
                    class="btn btn-info btn-sm"
                  >
                    <i class="fa fa-pencil-square-o" style="color:white;" aria-hidden="true"></i>

                  </button>

                  <button
                    type="button"
                    class="btn btn-secondary btn-sm"
                    @click="view()"
                  >
                    <i class="fa fa-eye" aria-hidden="true"></i>

                  </button>
                  
                  <button
                    type="button"
                    class="btn btn-warning btn-sm"
                    @click="openModalFile()"
                  >
                    <i class="fa fa-download" style="color:white;" aria-hidden="true"></i>

                  </button>
                  <button
                    type="button"
                    class="btn btn-success btn-sm"
                    @click="deleteSesion()"
                  >
                    <i class="fa fa-money" aria-hidden="true"></i>

                  </button>
                </td>
                <td>Tribunal</td>
                <td>Magister</td>
                <td>20/20/2020</td>
                <td>20/20/2020</td>
                <td>100</td>
                <td>1</td>
                <td>100</td>
              </tr>
            </tbody>
          </table>
        <!-- </template> -->

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
                  Cargue soporte de pago
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

                  <div class="mb-3">
                    <label for="" class="form-label"
                      ><b>Tipo de archivo *</b></label
                    >
                    <select
                      class="form-select"
                      name="type_file"
                    >
                      <option
                        v-for="(i, index) in type_file"
                        :key="index"
                        :value="i.id"
                        v-text="i.nombre"
                      ></option>
                    </select>
                  </div>
                  <div class="row">
                  <div
                    class="form-group files border opacity-2 opacity-2h"
                    role="button"
                    id="box_file"
                    @click="openModalFile()"
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
                <div class="d-grid gap-2 col-6 mx-auto">
                    <button type="submit"  class="btn btn-primary">Guardar</button>
                </div>

                </div>
                <div class="col-12" id="box_files"></div>
              </div>
              <!--div class="modal-footer">
                <button
                  type="button"
                  class="btn btn-primary"
                  @click="closeAddFile()"
                >
                  Aceptar
                </button>
              </div-->
            </div>
          </div>
        </div>

      </div>
    </template>
    <template v-if="pantalla == 'nuevo'">
      <div>
        <cuentas-cobro-nuevo></cuentas-cobro-nuevo>
      </div>
    </template>
    <template v-if="pantalla == 'editar'">
      <div>
        <cuentas-cobro-editar></cuentas-cobro-editar>
      </div>
    </template>
    <template v-if="pantalla == 'ver'">
      <div>
        <cuentas-cobro-ver></cuentas-cobro-ver>
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
      table: [],
      dataFilter: {},
      action: 0,
      idEditar: 0,
      datos_edit: {},
      pantalla: "lista",
    };
  },
  created() {
    this.select();
    this.table();
  },
  methods: {
    select(){
      axios.get("/data-select").then((r) => {
        this.tribunales = r.data.tribunales;
        this.magistrados = r.data.magistrados;
      });
    },
    table(){
      axios.post("/tabla-cuentas-cobro").then((r) => {
        this.table = r.data.table;
      });
    },
    editar() {
      this.pantalla = "editar";
    },
    view() {
      this.pantalla = "ver";
    },
    pantallaNuevo(){
      this.pantalla = "nuevo";
    },
    
  },
};
</script>

