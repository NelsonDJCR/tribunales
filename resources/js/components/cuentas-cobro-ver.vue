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
        <li class="breadcrumb-item active">
          <router-link :to="{ name: 'home' }"><span>Home</span></router-link> /
          <label for="" class="p-2"
            >Tribunales de Garantía / Listado de cuentas de cobro / Editar
            cuenta de cobro
          </label>
        </li>
      </ol>
      <div class="row p-2 text-center border shadow rounded-3">
        <div class="row">
          <div class="col-12 col-md-12 col-lg-10 col-xl-10 p-2">
            <h1 class="text-blue"><b>VISUALIZACIÓN CUENTA DE COBRO</b></h1>
          </div>
          <div class="col-12 col-md-12 col-lg-2 col-xl-2 p-2">
            <button
              @click="regresar"
              class="btn btn-danger text-white w-100 mt-2"
            >
              Cancelar
            </button>
          </div>
        </div>
      </div>
      <form @submit.prevent="save">
        <div class="row">
          <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-5">
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Tribunal</b></label>
                <input
                  type="text"
                  class="form-control"
                  disabled
                  v-model="record.tribunal.nombre"
                />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Magistrado</b></label>
                <input
                  type="text"
                  class="form-control"
                  v-model="record.magistrado.nombre"
                  disabled
                />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Fecha inicio</b> </label>
                <div class="input-group">
                  <input
                    type="text"
                    class="form-control"
                    v-model="record.fecha_inicio"
                    disabled
                  />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Fecha fin</b> </label>
                <div class="input-group">
                  <input
                    type="text"
                    class="form-control"
                    v-model="record.fecha_fin"
                    disabled
                  />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Valor honorarios</b></label>
                <input
                  type="number"
                  class="form-control"
                  v-model="record.valor_honorarios"
                  placeholder="32.000.000"
                  disabled
                />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Número de días</b></label>
                <input
                  type="number"
                  class="form-control"
                  v-model="record.numero_dias"
                  disabled
                />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Valor bruto</b></label>
                <input
                  type="number"
                  class="form-control"
                  v-model="record.valor_bruto"
                  disabled
                />
              </div>
            </div>

            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Iva factura</b></label>
                <input
                  type="number"
                  class="form-control"
                  v-model="record.iva_factura"
                  disabled
                />
              </div>
            </div>
          </div>

          <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-5">
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Valor factura</b></label>
                <input
                  type="number"
                  class="form-control"
                  v-model="record.valor_factura"
                  disabled
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
                  v-model="record.total_pagar"
                  disabled
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
                  v-model="record.rete_fuente"
                  disabled
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
                  v-model="record.rete_iva"
                  disabled
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
                  v-model="record.rete_ica"
                  disabled
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
                  v-model="record.neto_pagar"
                  disabled
                />
              </div>
            </div>
            <div class="row">
              <div class="mb-1">
                <label for="" class="form-label"><b>Archivos</b></label>
                <div class="row">
                  <div class="btns-block d-grid gap-2">
                    <ul class="list-group btn-group-vertical">
                      <li
                        class="list-group-item"
                        v-for="(i, index) in documentos"
                        :key="index"
                      >
                        <div class="btn btn-light btn-sm mt-2">
                          <span class="text-start float-start mt-1">
                            <select
                              class="form-control bg-transparent text-dark"
                              style="outline: none"
                              v-model="i.id_tipo_documento"
                              disabled
                            >
                              <option
                                v-for="(item, index) in type_file"
                                :key="index"
                                :value="item.id"
                                v-text="item.nombre"
                              ></option>
                            </select>
                          </span>
                          <a
                            :href="i.ruta"
                            :download="i.ruta"
                            class="badge bg-info float-end text-end m-1"
                            ><i class="fa fa-download fa-md"></i
                          ></a>
                        </div>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
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
                <label class="form-label">Agrege todos los documentos</label>
              </div>
              <div class="col-1">
                <button
                  class="btn-more btn"
                  id="add_file"
                  @click="add_file()"
                  type="button"
                >
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
export default {
  props: ["id"],
  data() {
    return {
      view: {},
      datarecord: {},
      record: {},
      type_file:[],
      documentos: [],
    };
  },
  created() {
    this.getRecord();
  },
  methods: {
    getRecord() {
      axios.post(`/record-cuenta-cobro`, { id: this.id }).then((r) => {
        this.record = r.data.data;
      this.documentos = r.data.documentos
      this.type_file = r.data.tipo_archivos
      });
    },
    reload() {
      location.reload();
    },
    regresar(){
        this.$emit('pantalla', 'lista')
    },
  },
};
</script>





