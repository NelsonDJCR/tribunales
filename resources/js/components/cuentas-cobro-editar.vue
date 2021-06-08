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
          <li class="breadcrumb-item active"><router-link :to="{ name: 'home'}"><span>Home</span></router-link> / <label for="" class="p-2">Tribunales de Garantía / Listado de cuentas de cobro / Editar cuenta de cobro </label></li>
      </ol>
      <div class="row p-2 text-center border shadow rounded-3">
        <div class="row">
          <div class="col-12 col-md-12 col-lg-10 col-xl-10 p-2">
            <h1 class="text-blue"><b>EDITAR CUENTA DE COBRO</b></h1>
          </div>
          <div class="col-12 col-md-12 col-lg-2 col-xl-2 p-2">
            <button
              @click="reload"
              class="btn btn-danger text-white w-100 mt-2"
            >
              Volver
            </button>
          </div>
        </div>
      </div>
      <form @submit.prevent="editar">
        <div class="row">
          <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-5">
          <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Tribunal</b></label>
                  <select
                    v-model="record.id_tribunal"
                    class="form-select"
                    name="tribu_id"
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
            <div class="row" v-if="validacion == '0'">
              <div class="mb-3">
                <label for="" class="form-label"><b>Magistrado</b></label>
                  <select
                    v-model="record.id_magistrado"
                    class="form-select"
                  >
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
                    type="text"
                    class="form-control"
                    v-model="record.fecha_inicio"
                    
                  />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"
                  ><b>Fecha fin</b>
                </label>
                <div class="input-group">
                  <input
                    type="text"
                    class="form-control"
                    v-model="record.fecha_fin"
                    
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
                    
                  />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Valor total a pagar</b></label>
                <input
                    type="number" min="1" step="any"
                    class="form-control"
                    v-model="record.total_pagar"
                    
                  />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Rete fuente</b></label>
                <input
                    type="number" min="1" step="any"
                    class="form-control"
                    v-model="record.rete_fuente"
                    
                  />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Rete IVA</b></label>
                <input
                    type="number" min="1" step="any"
                    class="form-control"
                    v-model="record.rete_iva"
                    
                  />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Rete ICA</b></label>
                <input
                    type="number" min="1" step="any"
                    class="form-control"
                    v-model="record.rete_ica"
                    
                  />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Neto a pagar</b></label>
                <input
                    type="number" min="1" step="any"
                    class="form-control"
                    v-model="record.neto_pagar"
                    
                  />
              </div>
            </div>
            <!-- <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Archivo</b></label>
                <div class="row">
                  <div class="d-grid gap-2">
                    <button class="btn btn-secondary btn-sm">
                      <span class="text-start float-start">Nombre de Archivo</span>
                      <span class="badge bg-secondary float-end"><i class="fa fa-download fa-lg"></i></span>
                      <a class="text-end" href="#">
                        <span class="badge bg-primary badge-dot"></span>
                      </a>
                    </button>
                  </div>
                </div>
              </div>
            </div>
             -->

            <div class="d-grid gap-2 col-6 mx-auto">
              <button type="submit"  class="btn btn-secondary active">Editar</button>
              <button @click="reload" class="btn btn-danger text-white w-100 mt-2">Cancelar</button>

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
                  <!-- <i class="fas fa-plus"></i> -->
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
  props: ['id','solicitud'],
  data() {
    return {
      view:{},
      datarecord:{},
      tribunales:{},
      magistrados:{},
      record:{},
      validacion:'',
    };
  },
  created() {
    if (this.solicitud) {
      this.validacion = ''
    }else{
      this.validacion = '0'
    }
    this.getRecord();
    this.select();
  },
  methods: {
    select(){
      axios.get(`/data-select`).then((r) => {
        this.tribunales = r.data.tribunales; 
        this.magistrados = r.data.magistrados; 
        this.tipo_archivos = r.data.tipo_archivos; 
      })
    },
    getRecord(){
      axios.post(`/record-cuenta-cobro`, {id:this.id}).then((r) => {
        this.record = r.data.data
      });
    },
    editar(){
      axios.post(`/cuenta-cobro-editar`, this.record).then((r) => {
          if(r.data.code== 200){
            swal.fire(r.data.msg,'', "success").then(function(){ location.reload() });
          }else if(r.data.code== 406){
            swal.fire(r.data.msg,'', "warning")
          }else{
            swal.fire("Fallo en el sevidor!",'error', "error")
          }
      });
    },
    reload(){
      location.reload()
    },
  },
};
</script>





