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
            >Tribunales de Garantía / Listado de cuentas de cobro / Nueva cuenta
            de cobro
          </label>
        </li>
      </ol>
      <div class="row p-2 text-center border shadow rounded-3">
        <div class="row">
          <div class="col-12 col-md-12 col-lg-10 col-xl-10 p-2">
            <h1 class="text-blue"><b>EDITAR CUENTA DE COBRO</b></h1>
          </div>
          <div class="col-12 col-md-12 col-lg-2 col-xl-2 p-2">
            <div @click="regresar" class="btn btn-danger text-white w-100 mt-2">
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
                  @change="magistradosxtribunal(form.id_tribunal)"
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
                <label for="" class="form-label"><b>Funcionarios</b></label>
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
                <label for="" class="form-label"><b>Fecha inicio</b> </label>
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
                <label for="" class="form-label"><b>Valor honorarios</b></label>
                <input
                  type="number"
                  class="form-control"
                  v-model="form.valor_honorarios"
                />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Número de días</b></label>
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
                  type="text"
                  class="form-control"
                  v-model="form.valor_bruto"
                />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Valor factura</b></label>
                <input
                  type="text"
                  class="form-control"
                  v-model="form.valor_factura"
                />
              </div>
            </div>

            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"
                  ><b>Valor iva factura</b></label
                >
                <input
                  type="number"
                  class="form-control"
                  v-model="form.iva_factura"
                  @keyup="cal_total_pagar"
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
                <select
                  class="form-select"
                  name="type_file"
                  v-model="form.id_tipo_documento"
                >
                  <option>Seleccione ...</option>
                  <option
                    v-for="(i, index) in type_file"
                    :key="index"
                    :value="i.id"
                    v-text="i.nombre"
                  ></option>
                </select>
              </div>
            </div>
            <div class="row mt-5" @click="box_file">
              <div
                class="form-group files border opacity-2 opacity-2h"
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
            <input
              type="file"
              class="d-none"
              id="file"
              accept=".pdf, .png, .jpg"
              @change="upload_file($event)"
            />

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
                          <button
                            type="button"
                            class="badge bg-danger float-end text-end m-1"
                            @click="eliminar_archivo(index)"
                          >
                            <i class="fa fa-trash fa-md"></i>
                          </button>
                        </div>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>

            <div class="d-grid gap-2 col-6 mx-auto">
              <button type="submit" class="btn btn-success">
                Guardar cambios
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
<script>
export default {
  props: ["id"],
  data() {
    return {
      tribunales: [],
      magistrados: [],
      tipo_archivo: [],
      eliminados: [],
      type_file: [],
      tipo_documentos: [],
      tribunales: [],
      documentos: [],
      archivo: {},
      form: { id_tipo_documento: "" },
    };
  },
  created() {
    if (this.solicitud) {
      this.validacion = "";
    } else {
      this.validacion = "0";
    }
    this.getRecord();
    // this.select();
  },
  methods: {
    regresar() {
      this.$emit("pantalla", "lista");
    },
    eliminar_archivo(index) {
      if (this.documentos[index].id != 0) {
        this.eliminados.push(this.documentos[index].id);
      }
      this.documentos.splice(index, 1);
      this.tipo_documentos.splice(index, 1);
    },
    getRecord() {
      axios.post(`/record-cuenta-cobro`, { id: this.id }).then((r) => {
        //   axios.post(`/record-cuenta-cobro`, { id: "6" }).then((r) => {
        this.form = r.data.data;
        this.documentos = r.data.documentos;
        this.type_file = r.data.tipo_archivos;
        this.tribunales = r.data.tribunales;
        for (let index = 0; index < this.documentos.length; index++) {
          this.tipo_documentos.push(this.documentos[index].id_tipo_documento);
        }
        let url = "/magistradosxtribunal/" + this.id;
        // let url = "/magistradosxtribunal/" + "6";
        axios.get(url).then((res) => {
          console.log(res.data);
          this.magistrados = res.data.funcionarios;
        });
        this.form["id_tipo_documento"] = "";
        console.log(r.data);
      });
    },
    box_file() {
      if (this.form.id_tipo_documento != "") {
        $("#file").trigger("click");
      } else {
        Swal.fire("¡Error!", "Seleccione un tipo de archivo", "error");
      }
    },
    magistradosxtribunal(i) {
      let url = "/magistradosxtribunal/" + i;
      axios.get(url).then((res) => {
        console.log(res.data);
        this.magistrados = res.data.funcionarios;
      });
    },
    upload_file(event) {
      for (let index = 0; index < this.tipo_documentos.length; index++) {
        if (this.tipo_documentos[index] == this.form.id_tipo_documento) {
          Swal.fire(
            "¡Advertencia!",
            "Ya usaste este tipo de archivo",
            "warning"
          );
          return;
        }
      }
      this.archivo = event.target.files[0];
      this.archivo["id_tipo_documento"] = this.form.id_tipo_documento;
      this.documentos.push(this.archivo);
      this.tipo_documentos.push(this.form.id_tipo_documento);
      this.form.id_tipo_documento = "";
      //   console.log(this.archivos);
    },
    reload() {
      location.reload();
    },
    select() {
      axios.get(`/data-select`).then((r) => {
        // console.log(r.data);
        this.tribunales = r.data.tribunales;
        // this.magistrados = r.data.magistrados;
        this.type_file = r.data.tipo_archivos;
      });
    },
    newForm() {
      let formulario = new FormData();
      formulario.append("id", this.id);
      //   formulario.append('id', 6)
      formulario.append("id_tribunal", this.form.id_tribunal);
      formulario.append("id_magistrado", this.form.id_magistrado);
      formulario.append("fecha_inicio", this.form.fecha_inicio);
      formulario.append("fecha_fin", this.form.fecha_fin);
      formulario.append("valor_honorarios", this.form.valor_honorarios);
      formulario.append("numero_dias", this.form.numero_dias);
      formulario.append("valor_bruto", this.form.valor_bruto);
      formulario.append("valor_factura", this.form.valor_factura);
      formulario.append("total_pagar", this.form.total_pagar);
      formulario.append("rete_fuente", this.form.rete_fuente);
      formulario.append("rete_iva", this.form.rete_iva);
      formulario.append("rete_ica", this.form.rete_ica);
      formulario.append("neto_pagar", this.form.neto_pagar);
      formulario.append("cantidad", this.tipo_documentos.length);
      formulario.append("cant_eliminados", this.eliminados.length);
      formulario.append('iva_factura', this.form.iva_factura)

      for (let index = 0; index < this.documentos.length; index++) {
        formulario.append("archivo" + index, this.documentos[index]);
      }

      for (let index = 0; index < this.tipo_documentos.length; index++) {
        formulario.append("tipo_archivo" + index, this.tipo_documentos[index]);
      }

      for (let index = 0; index < this.eliminados.length; index++) {
        formulario.append("e_id" + index, this.eliminados[index]);
      }

      axios.post("/update-cuenta-cobro", formulario).then((r) => {
        if (r.data.status == 200) {
          swal.fire(r.data.msg, "", "success").then(function () {
            location.reload();
          });
        } else if (r.data.status == 406) {
          swal.fire(r.data.msg, "", "warning");
        } else {
          swal.fire("Fallo en el sevidor!", "error", "error");
        }
      });
    },
  },
};
</script>





