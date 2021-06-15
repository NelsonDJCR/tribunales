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
            <li class="breadcrumb-item active">
              <router-link :to="{ name: 'home' }"
                ><span>Home</span></router-link
              >
              /
              <label for="" class="p-2"
                >Tribunales de Garantía / Listado de cuentas de cobro
              </label>
            </li>
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
                <label for="" class="form-label"><b>Funcionario</b></label>
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
            <tr v-for="(i, index) in table" :key="index">
              <td class="aling_btn_options" style="width: 190px">
                <button
                  type="button"
                  @click="editar(i.id)"
                  class="btn btn-info btn-sm"
                >
                  <i
                    class="fa fa-pencil-square-o"
                    style="color: white"
                    aria-hidden="true"
                  ></i>
                </button>
                <button
                  type="button"
                  class="btn btn-secondary btn-sm"
                  @click="view(i.id)"
                >
                  <i class="fa fa-eye" aria-hidden="true"></i>
                </button>
                <button
                  type="button"
                  class="btn btn-success btn-sm"
                  @click="comision(i.id)"
                >
                  <i class="fa fa-money" aria-hidden="true"></i>
                </button>
              </td>
              <td>{{ i.tribunal.nombre }}</td>
              <td>{{ i.magistrado.nombre }}</td>
              <td>{{ i.fecha_inicio }}</td>
              <td>{{ i.fecha_fin }}</td>
              <td>{{ i.valor_honorarios }}</td>
              <td>{{ i.numero_dias }}</td>
              <td>{{ i.neto_pagar }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </template>
    <template v-if="pantalla == 'nuevo'">
      <div>
        <cuentas-cobro-nuevo></cuentas-cobro-nuevo>
      </div>
    </template>
    <template v-if="pantalla == 'editar'">
      <div>
        <cuentas-cobro-editar :id="idrecord"></cuentas-cobro-editar>
      </div>
    </template>
    <template v-if="pantalla == 'ver'">
      <div>
        <cuentas-cobro-ver :id="idrecord"></cuentas-cobro-ver>
      </div>
    </template>
    <template v-if="pantalla == 'comisiones'">
      <div>
        <div class="container mt-5">
          <!-- Breadcrumb -->
          <ol class="breadcrumb">
            <li class="breadcrumb-item active">
              <router-link :to="{ name: 'home' }"
                ><span>Home</span></router-link
              >
              /
              <label for="" class="p-2"
                >Tribunales de Garantía / Listado de cuentas de cobro / Nueva
                cuenta de cobro
              </label>
            </li>
          </ol>
          <div class="row p-2 text-center border shadow rounded-3">
            <div class="row">
              <div class="col-12 col-md-12 col-lg-10 col-xl-10 p-2">
                <h1 class="text-blue"><b>COMISIONES</b></h1>
              </div>
              <div class="col-12 col-md-12 col-lg-2 col-xl-2 p-2">
                <div
                  @click="reload"
                  class="btn btn-danger text-white w-100 mt-2"
                >
                  Cancelar
                </div>
              </div>
            </div>
          </div>

          <form @submit.prevent="newForm">
            <div class="row">
              <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-5">
                <div class="row">
                  <div class="mb-3">
                    <label for="" class="form-label"><b>Tribunal</b></label>
                    <select
                      class="form-select"
                      name="tribu_id"
                      v-model="form.id_tribunal"
                    >
                      <option value="">Selecciona</option>
                      <option
                        v-for="(i, index) in tribunales"
                        :key="index"
                        :value="i.id"
                        v-text="i.nombre"
                      ></option>
                    </select>
                  </div>
                </div>
                <div class="row">
                  <div class="mb-3">
                    <label for="" class="form-label"><b>Magistrado</b></label>
                    <select class="form-select" v-model="form.id_magistrado">
                      <option value="">Selecciona</option>
                      <option
                        v-for="(i, index) in magistrados"
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
                      ><b>Fecha inicio</b>
                    </label>
                    <div class="input-group">
                      <input
                        v-model="form.fecha_inicio"
                        type="date"
                        class="form-control"
                      />
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="mb-3">
                    <label for="" class="form-label"><b>Fecha fin</b> </label>
                    <div class="input-group">
                      <input
                        v-model="form.fecha_fin"
                        type="date"
                        class="form-control"
                      />
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="mb-3">
                    <label for="" class="form-label"
                      ><b>Valor honorarios</b></label
                    >
                    <input
                      type="number"
                      class="form-control"
                      v-model="form.valor_honorarios"
                    />
                  </div>
                </div>
                <div class="row">
                  <div class="mb-3">
                    <label for="" class="form-label"
                      ><b>Valor Conseptos</b></label
                    >
                    <input
                      type="number"
                      class="form-control"
                      v-model="form.valor_honorarios"
                    />
                  </div>
                </div>
                <div class="row">
                  <div class="mb-3">
                    <label for="" class="form-label"
                      ><b>Número de días</b></label
                    >
                    <input
                      type="number"
                      class="form-control"
                      v-model="form.numero_dias"
                    />
                  </div>
                </div>
                <div class="row">
                  <div class="mb-3">
                    <label for="" class="form-label"><b>Valor bruto</b></label>
                    <input
                      type="number"
                      class="form-control"
                      v-model="form.valor_bruto"
                    />
                  </div>
                </div>
                <div class="row">
                  <div class="mb-3">
                    <label for="" class="form-label"
                      ><b>Valor factura</b></label
                    >
                    <input
                      type="number"
                      class="form-control"
                      v-model="form.valor_factura"
                    />
                  </div>
                </div>
              </div>

              <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-5">
                <div class="row">
                  <div class="mb-3">
                    <label for="" class="form-label"
                      ><b>Valor total a pagar</b></label
                    >
                    <input
                      type="number"
                      min="1"
                      step="any"
                      class="form-control"
                      v-model="form.total_pagar"
                    />
                  </div>
                </div>
                <div class="row">
                  <div class="mb-3">
                    <label for="" class="form-label"><b>Rete fuente</b></label>
                    <input
                      type="number"
                      min="1"
                      step="any"
                      class="form-control"
                      v-model="form.rete_fuente"
                    />
                  </div>
                </div>
                <div class="row">
                  <div class="mb-3">
                    <label for="" class="form-label"><b>Rete IVA</b></label>
                    <input
                      type="number"
                      min="1"
                      step="any"
                      class="form-control"
                      v-model="form.rete_iva"
                    />
                  </div>
                </div>
                <div class="row">
                  <div class="mb-3">
                    <label for="" class="form-label"><b>Rete ICA</b></label>
                    <input
                      type="number"
                      min="1"
                      step="any"
                      class="form-control"
                      v-model="form.rete_ica"
                    />
                  </div>
                </div>
                <div class="row">
                  <div class="mb-3">
                    <label for="" class="form-label"><b>Neto a pagar</b></label>
                    <input
                      type="number"
                      min="1"
                      step="any"
                      class="form-control"
                      v-model="form.neto_pagar"
                    />
                  </div>
                </div>
                <div class="row">
                  <div class="mb-3">
                    <label for="" class="form-label"
                      ><b>Tipo de archivo *</b></label
                    >
                    <select class="form-select" name="type_file">
                      <option>Seleccione ...</option>
                      <option
                        v-for="(i, index) in tipo_archivos"
                        :key="index"
                        :value="i.id"
                        v-text="i.nombre"
                      ></option>
                    </select>
                  </div>
                </div>
                <div class="row mt-5">
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
                  <button type="submit" class="btn btn-success">
                    Crear Cuenta de Cobro
                  </button>
                </div>
              </div>
            </div>
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
                    <label class="form-label"
                      >Agrege todos los documentos</label
                    >
                  </div>
                  <div class="col-1">
                    <button
                      class="btn-more btn"
                      id="add_file"
                      @click="add_file()"
                      type="button"
                    >
                      <!-- <i class="fas fa-plus"></i> -->
                      <i
                        class="typcn typcn-document-add"
                        style="color: green"
                      ></i>
                    </button>
                  </div>
                </div>
                <div class="col-12" id="box_files"></div>
              </div>
              <div class="modal-footer">
                <button
                  type="submit"
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
      idrecord: 0,
      datos_edit: {},
      // pantalla: "lista",
      pantalla: "nuevo",
    };
  },
  created() {
    this.getSelect();
    this.getTable();
  },
  methods: {
    fecha_format() {
      var fecha = "";
      var fecha_format = "";
      var array = [];

      for (let index = 0; index < this.table.length; index++) {
        fecha = this.table[index].fecha_inicio;
        array = fecha.split("-");
        fecha_format = array[2] + "-" + array[1] + "-" + array[0];
        this.table[index].fecha_inicio = fecha_format;

        fecha = this.table[index].fecha_final;
        array = fecha.split("-");
        fecha_format = array[2] + "-" + array[1] + "-" + array[0];
        this.table[index].fecha_final = fecha_format;
      }
    },
    getSelect() {
      axios.get("/data-select").then((r) => {
        this.tribunales = r.data.tribunales;
        this.magistrados = r.data.magistrados;
      });
    },
    getTable() {
      axios.post("/tabla-cuentas-cobro").then((r) => {
        this.table = r.data.table;
        this.fecha_format();
        console.log(this.table);
      });
    },
    editar(x) {
      this.idrecord = x;
      this.pantalla = "editar";
    },
    view(x) {
      this.idrecord = x;
      this.pantalla = "ver";
    },
    pantallaNuevo() {
      this.pantalla = "nuevo";
    },
    comision(x) {
      this.idrecord = x;
      this.pantalla = "comisiones";
    },
  },
};
</script>

