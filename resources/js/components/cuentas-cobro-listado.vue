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
            <tr v-for="(i, index) in table" :key="index">
              <td class="aling_btn_options" style="width: 190px">
                <button
                  type="button"
                  @click="editarRecord(i.id)"
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
        <cuentas-cobro-nuevo
          @pantalla="pantalla = $event"
        ></cuentas-cobro-nuevo>
      </div>
    </template>
    <template v-if="pantalla == 'editar'">
      <div>
        <cuentas-cobro-editar
          @pantalla="pantalla = $event"
          :id="idrecord"
        ></cuentas-cobro-editar>
      </div>
    </template>
    <template v-if="pantalla == 'ver'">
      <div>
        <cuentas-cobro-ver
          @pantalla="pantalla = $event"
          :id="idrecord"
        ></cuentas-cobro-ver>
      </div>
    </template>

    <template v-if="pantalla == 'comisiones'">
      <div>
        <link
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css"
          rel="stylesheet"
          integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0"
          crossorigin="anonymous"
        />
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
                <h1 class="text-blue"><b>NUEVA CUENTA DE COBRO</b></h1>
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

          <form @submit.prevent="newComision">
            <div class="row">
              <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-5">
                <div class="row">
                  <div class="mb-3">
                    <label for="" class="form-label"><b>Concepto</b></label>
                    <input
                      type="text"
                      class="form-control"
                      v-model="new_com.consepto"
                    />
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
                      v-model="new_com.valor_honorarios"
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
                      v-model="new_com.numero_dias"
                    />
                  </div>
                </div>
                <input
                  type="hidden"
                  class="form-control"
                  v-model="new_com.cuentas_cobro_id"
                />
                <div class="row">
                  <div class="mb-3">
                    <label for="" class="form-label"><b>Valor bruto</b></label>
                    <input
                      type="number"
                      class="form-control"
                      v-model="new_com.valor_bruto"
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
                      v-model="new_com.valor_factura"
                    />
                  </div>
                </div>
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
                      v-model="new_com.total_pagar"
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
                      v-model="new_com.retefuente"
                    />
                  </div>
                </div>
              </div>

              <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-5">
                <div class="row">
                  <div class="mb-3">
                    <label for="" class="form-label"><b>Rete IVA</b></label>
                    <input
                      type="number"
                      min="1"
                      step="any"
                      class="form-control"
                      v-model="new_com.rete_iva"
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
                      v-model="new_com.rete_ica"
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
                      v-model="new_com.neto_pagar"
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

                <div v-if="editar == 0">
                  <div class="d-grid gap-2 col-6 mx-auto">
                    <button type="submit" class="btn btn-success">
                      Agregar comisión
                    </button>
                  </div>
                </div>
                <div v-else>
                  <div class="d-grid gap-2 col-6 mx-auto">
                    <button @click="edit" type="button" class="btn btn-success">
                      Editar comisión
                    </button>
                  </div>
                  <div class="d-grid gap-2 col-6 mx-auto mt-2">
                    <button
                      @click="cancelEdit"
                      type="button"
                      class="btn btn-danger"
                    >
                      Cancelar
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
        <h1>Comisiones</h1>
        <diV class="btns-block d-grid gap-2 mt-5">
          <ul class="list-group btn-group-vertical">
            <li
              class="list-group-item"
              v-for="(i, index) in comisiones"
              :key="index"
            >
              <button class="btn btn-light btn-sm mt-2">
                <span class="text-start float-start mt-1">{{
                  i.consepto
                }}</span>
                <a
                  @click="editComision(i.id)"
                  class="badge bg-primary float-end text-end m-1"
                  ><i class="fa fa-edit fa-md"></i
                ></a>
                <a
                  @click="deleteComision(i.id)"
                  class="badge bg-danger float-end text-end m-1"
                  ><i class="fa fa-trash fa-md"></i
                ></a>
              </button>
            </li>
          </ul>
        </diV>
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
      comisiones: {},
      action: 0,
      idrecord: 0,
      editar: 0,
      id_comision: 0,
      cuentas_cobro_id: 0,
      datos_edit: {},
      new_com: {
        cuentas_cobro_id: 0,
      },
    //   pantalla: "lista",
        pantalla: "nuevo",
    };
  },
  created() {
    this.getSelect();
    this.getTable();
  },
  methods: {
    getSelect() {
      axios.get("/data-select").then((r) => {
        this.tribunales = r.data.tribunales;
        this.magistrados = r.data.magistrados;
      });
    },
    getComisiones() {
      axios
        .post(`/comision-listar`, { id: this.new_com.cuentas_cobro_id })
        .then((r) => {
          this.comisiones = r.data.table;
        });
    },
    getTable() {
      axios.post("/tabla-cuentas-cobro").then((r) => {
        this.table = r.data.table;
        this.fecha_format();
        console.log(this.table);
      });
    },
    editarRecord(x) {
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
      this.id_comision = x;
      this.new_com.cuentas_cobro_id = this.id_comision;

      this.pantalla = "comisiones";
      this.getComisiones();
    },
    reload() {
      //   alert("");
      this.pantalla = "lista";
    },
    newComision() {
      axios.post(`/nueva-comision`, this.new_com).then((e) => {
        if (e.data.code == 200) {
          Swal.fire(e.data.msg, "", "success");
          this.getComisiones();
          this.new_com = {};
          this.new_com.cuentas_cobro_id = this.id_comision;
        } else if (e.data.code == 406) {
          Swal.fire(e.data.msg, "", "question");
        } else {
          swal.fire("Fallo en el sevidor!", "error", "error");
        }
      });
    },
    deleteComision(x) {
      Swal.fire({
        title: "¿Eliminar registro?",
        text: "Esta acción no se puede revertir",
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "Aceptar",
        cancelButtonText: "Cancelar",
      }).then((result) => {
        if (result.value) {
          axios.post(`/comision-eliminar`, { id: x }).then((r) => {
            this.getComisiones();
            Swal.fire("Comision eliminada", "", "success");
          });
        }
      });
    },
    editComision(x) {
      axios.post(`/comision-editar-data`, { id: x }).then((r) => {
        this.editar = 1;
        this.new_com = r.data.data;
      });
    },
    cancelEdit() {
      this.editar = 0;
      this.new_com = {};
      this.new_com.cuentas_cobro_id = this.id_comision;
    },
    edit() {
      axios.post(`/comision-editar`, this.new_com).then((r) => {
        if (r.data.code == 200) {
          Swal.fire("Comisión Actualizada", "", "success");
          this.getComisiones();
          this.cancelEdit();
        } else if (r.data.code == 406) {
          Swal.fire(r.data.msg, "", "warning");
        } else {
          swal.fire("Fallo en el sevidor!", "error", "error");
        }
      });
    },
  },
};
</script>

