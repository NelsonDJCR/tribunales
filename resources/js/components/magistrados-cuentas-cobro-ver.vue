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
          <li class="breadcrumb-item active"><router-link :to="{ name: 'home'}"><span>Home</span></router-link> / <label for="" class="p-2">Magistrados / Listado de cuentas de cobro / Ver cuenta de cobro </label></li>
      </ol>
      <div class="row p-2 text-center border shadow rounded-3">
              <div class="row">
                <div class="col-12 col-md-12 col-lg-10 col-xl-10 p-2">
                    <h1 class="text-blue"><b>VISUALIZACIÓN CUENTA DE COBRO</b></h1>
                </div>
                <div class="col-12 col-md-12 col-lg-2 col-xl-2 p-2">
                    <router-link :to='`/magistrados/cuentas-de-cobro`' @click.native="$router.go()" class="btn btn-secondary active text-white w-100 mt-2">Volver al listado</router-link>
                </div>
                <!--div class="col-12 col-md-12 col-lg-2 col-xl-2 p-2">
                  <button
                    @click="editar"
                    class="btn btn-warning text-white w-100 mt-2"
                  >
                    Editar cuenta
                  </button>
                </div-->
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
                    id=""
                    name=""
                    v-model="sesion.theme"
                    placeholder="Tribunal"
                    disabled
                  />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Magistrado</b></label>
                  <input
                    type="text"
                    class="form-control"
                    id=""
                    name=""
                    v-model="sesion.theme"
                    placeholder="Magistrado"
                    disabled
                  />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"
                  ><b>Fecha inicio</b>
                </label>
                <div class="input-group">
                  <input
                    v-model="sesion.date"
                    type="date"
                    class="form-control"
                    disabled
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
                    v-model="sesion.date"
                    type="date"
                    class="form-control"
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
                    id=""
                    name=""
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
                    id=""
                    name=""
                    placeholder="30"
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
                    id=""
                    name=""
                    placeholder="30.000.000"
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
                    id=""
                    name=""
                    placeholder="30.000.000"
                    disabled
                  />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Valor total a pagar</b></label>
                <input
                    type="number" min="1" step="any"
                    class="form-control"
                    id=""
                    name=""
                    placeholder="90.000.000"
                    disabled
                  />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Rete fuente</b></label>
                <input
                    type="number" min="1" step="any"
                    class="form-control"
                    id=""
                    name=""
                    placeholder="2%"
                    disabled
                  />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Rete IVA</b></label>
                <input
                    type="number" min="1" step="any"
                    class="form-control"
                    id=""
                    name=""
                    placeholder="16%"
                    disabled
                  />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Rete ICA</b></label>
                <input
                    type="number" min="1" step="any"
                    class="form-control"
                    id=""
                    name=""
                    placeholder="10%"
                    disabled
                  />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Neto a pagar</b></label>
                <input
                    type="number" min="1" step="any"
                    class="form-control"
                    id=""
                    name=""
                    placeholder="100.000.000"
                    disabled
                  />
              </div>
            </div>
            <div class="row">
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

          </div>
        </div>

        <div class="row">
            <h3 class="mb-2 text-secondary mt-5"><b>Comisiones</b></h3>
            <div class="row">
                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <div class="row">
                        <div class="mb-3">
                            <label for="" class="form-label"
                            ><b>Concepto</b>
                            </label>
                            <input
                                type="text"
                                class="form-control"
                                id=""
                                name=""
                                placeholder="Transporte"
                                disabled
                            />
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3">
                            <label for="" class="form-label"><b>Valor honorarios</b></label>
                            <input
                                type="number"
                                class="form-control"
                                id=""
                                name=""
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
                                id=""
                                name=""
                                placeholder="30"
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
                                id=""
                                name=""
                                placeholder="30.000.000"
                                disabled
                            />
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3">
                            <label for="" class="form-label"><b>Valor factura</b></label>
                            <input
                                type="number"
                                class="form-control"
                                id=""
                                name=""
                                placeholder="30.000.000"
                                disabled
                            />
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3">
                            <label for="" class="form-label"><b>Valor total a pagar</b></label>
                            <input
                                type="number" min="1" step="any"
                                class="form-control"
                                id=""
                                name=""
                                placeholder="90.000.000"
                                disabled
                            />
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <div class="row">
                        <div class="mb-3">
                            <label for="" class="form-label"><b>Rete fuente</b></label>
                            <input
                                type="number" min="1" step="any"
                                class="form-control"
                                id=""
                                name=""
                                placeholder="2%"
                                disabled
                            />
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3">
                            <label for="" class="form-label"><b>Rete IVA</b></label>
                            <input
                                type="number" min="1" step="any"
                                class="form-control"
                                id=""
                                name=""
                                placeholder="16%"
                                disabled
                            />
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3">
                            <label for="" class="form-label"><b>Rete ICA</b></label>
                            <input
                                type="number" min="1" step="any"
                                class="form-control"
                                id=""
                                name=""
                                placeholder="10%"
                                disabled
                            />
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3">
                            <label for="" class="form-label"><b>Neto a pagar</b></label>
                            <input
                                type="number" min="1" step="any"
                                class="form-control"
                                id=""
                                name=""
                                placeholder="100.000.000"
                                disabled
                            />
                        </div>
                    </div>
                    <div class="row">
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
                </div>
            </div>
            <div class="row">



            </div>
        </div>

      </form>
    </div>


  </div>

</template>
<script>
// $('body').on('click', '.delete_file', function() {
//   $(this).parent().parent().remove();
// });
export default {
  data() {
    return {
      type_file: [],
      ciudades: [],
      departament: [],
      sesion: {},
      documentos: [],
      index: 0,
      // department = 0,
      //   municipality =0,
      //   radicado_CNE = '',
      //   theme = '',
      //   description = '',
      //   date = '',
    };
  },
  created() {
    const url = "/data-new-sesion";
    axios.get(url).then((r) => {
      this.type_file = r.data.tipo;
      this.ciudades = r.data.municipios;
      this.departament = r.data.departament;
    });
  },
  methods: {
    editar() {
      this.pantalla = "editar";
    },
    openModalFile() {
      $("#modal_file").modal("show");
    },
    add_file() {
      var index = this.index++;
      var file = `<div class="row">
              <div class="col-11">
                  <input id="archivo_${index}"  type="text" class="form-control mb-3" />
              </div>
              <div class="col-1">
                  <button class="btn-delete-file btn delete_file " @click="delete_file()" ><i class="typcn typcn-delete" style="color:red; backgroud:red;"></i></button>
              </div>
          </div>`;
      $("#box_files").append(file);
      var archivo1 = $(`#arcivo_${index}`).val()
      console.log(archivo1);
      this.documentos[index] = archivo1
      // console.log(this.documentos);
      $("body").on("click", ".delete_file", function () {
        $(this).parent().parent().remove();
      });
    },
    delete_file() {
      $(this).parent().parent().remove();
    },
    closeAddFile() {
      $("#modal_file").modal("hide");
    },
    changeCity() {
      var id = $("#departamento_id").val();
      axios.post("/changeCity", { id: id }).then((r) => {
        this.ciudades = r.data;
      });
    },
    save() {
      let datos = this.sesion;
      let url = "saveSesion";
      axios.post(url, datos).then((r) => {
        if (r.data.status == 406) {
          Swal.fire("Error", r.data.msg, "error");
        } else if (r.data.code == 200) {
          Swal.fire({
            icon: "success",
            title: "¡Perfercto!",
            text: "Datos guardados exitosamente",
          }).then(function () {
            window.location = "/main#/listarSesiones";
          });
        }

      });
    },
  },
};
</script>





