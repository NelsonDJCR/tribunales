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
          <li class="breadcrumb-item active"><router-link :to="{ name: 'home'}"><span>Home</span></router-link> / <label for="" class="p-2">Tribunales de Garantia / Listado de casos / Ver caso </label></li>
      </ol>
      <div class="row p-2 text-center border shadow rounded-3">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-10 col-xl-10 p-2">
                <h2 class="text-blue"><b>VISUALIZACIÓN DEL CASO</b></h2>
            </div>
            <div class="col-12 col-md-12 col-lg-2 col-xl-2 p-2">
                <router-link :to='`/tribunales/listado-de-pqrs`' @click.native="$router.go()" class="btn btn-secondary active text-white w-100 mt-2">Volver al listado</router-link>
            </div>
        </div>

      </div>

      <form @submit.prevent="save">

        <div class="row">
          <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-5">
            <h3 class="mb-2 text-secondary"><b>Detalles del caso</b></h3>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Tipo de tramite</b></label>
                <input
                    type="text"
                    class="form-control"
                    id=""
                    name=""
                    placeholder="Queja"
                    disabled
                  />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"
                  ><b>Fecha de elección</b>
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
                <label for="" class="form-label"><b>Tipo de elección</b></label>
                <input
                    type="text"
                    class="form-control"
                    id=""
                    name=""
                    v-model="sesion.theme"
                    placeholder="Ordinaria"
                    disabled
                  />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Prioridad</b></label>
                <input
                    type="text"
                    class="form-control"
                    id=""
                    name=""
                    placeholder="Alta"
                    disabled
                  />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"
                  ><b>Fecha de recibido</b>
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
                <label for="" class="form-label"><b>Medio de recepción</b></label>
                <input
                    type="text"
                    class="form-control"
                    id=""
                    name=""
                    placeholder="Correo electrónico"
                    disabled
                  />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Correo de notificación</b></label>
                <input
                    type="text"
                    class="form-control"
                    id=""
                    name=""
                    placeholder="correo@correo.com"
                    disabled
                  />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Informante anónimo</b></label>
                <input
                    type="text"
                    class="form-control"
                    id=""
                    name=""
                    placeholder="Si"
                    disabled
                  />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Departamento</b></label>
                  <select
                    disabled
                    class="form-select"
                    name="dep_id"
                    id="dep_id"
                  >
                    <option value="" selected>Cundinamarca</option>
                    <option
                      v-for="(i, index) in departament"
                      :key="index"
                      v-text="i.nombre"
                      :value="i.id"
                    ></option>
                  </select>
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Municipio</b></label>
                  <select
                    disabled
                    class="form-select"
                    name=""
                    id=""
                  >
                    <option value="" selected>Chía</option>
                    <option
                      v-for="(i, index) in departament"
                      :key="index"
                      v-text="i.nombre"
                      :value="i.id"
                    ></option>
                  </select>
              </div>
            </div>

          </div>

          <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-5">
            <div class="row mb-3 hidden-sm">
                <br/>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Dirección</b></label>
                <input
                    type="text"
                    class="form-control"
                    id=""
                    name=""
                    placeholder="Calle falsa 123"
                    disabled
                  />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Barrio</b></label>
                <input
                    type="text"
                    class="form-control"
                    id=""
                    name=""
                    placeholder="Kennnedy"
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
                <label for="" class="form-label"><b>Puesto de votación</b></label>
                <input
                    type="text"
                    class="form-control"
                    id=""
                    name=""
                    placeholder="Escuela patria"
                    disabled
                  />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Mesa de votación</b></label>
                <input
                    type="text"
                    class="form-control"
                    id=""
                    name=""
                    placeholder="Escuela patria"
                    disabled
                  />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Asunto</b></label>
                <input
                    type="text"
                    class="form-control"
                    id=""
                    name=""
                    placeholder="3"
                    disabled
                  />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Hechos</b></label>
                <textarea class="form-control" id="" rows="8" placeholder="Descripción de los hechos" disabled></textarea>
              </div>
            </div>

          </div>
        </div>

        <div class="row">

          <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-3">
            <h3 class="mb-2 text-secondary"><b>Datos del solicitante</b></h3>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Nombres y apellidos del solicitante</b></label>
                <input
                    type="text"
                    class="form-control"
                    id=""
                    name=""
                    placeholder="Camilo Avendaño"
                    disabled
                  />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Tipo de identificación</b></label>
                  <select
                    disabled
                    class="form-select"
                    name=""
                    id=""
                  >
                    <option value="" selected>CC</option>
                  </select>
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Número de Identificacíon</b></label>
                <input
                    type="text"
                    class="form-control"
                    id=""
                    name=""
                    placeholder="10305582574"
                    disabled
                  />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Departamento de residencia</b></label>
                <div class="input-group">
                  <select
                    disabled
                    class="form-select"
                    name=""
                    id=""
                  >
                    <option value="" selected>Cundinamarca</option>
                  </select>
                </div>
              </div>
            </div>

          </div>

          <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-3">
            <div class="row mb-3 hidden-sm">
                <br/>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"
                  ><b>Municipio de residencia</b>
                </label>
                <div class="input-group">
                  <select
                    disabled
                    class="form-select"
                    name=""
                    id=""
                  >
                    <option value="" selected>Chía</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Dirección de residencia</b></label>
                <input
                    type="text"
                    class="form-control"
                    id=""
                    name=""
                    placeholder="Calle falsa 123"
                    disabled
                  />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Telefóno de residencia</b></label>
                <input
                    type="number"
                    class="form-control"
                    id=""
                    name=""
                    placeholder="Calle falsa 123"
                    disabled
                  />
              </div>
            </div>
          </div>

        </div>

        <div class="row">

          <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-3">
            <h3 class="mb-2 text-secondary"><b>Gestión</b></h3>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Estado</b></label>
                <input
                    type="text"
                    class="form-control"
                    id=""
                    name=""
                    v-model="sesion.theme"
                    placeholder="En proceso"
                    disabled
                  />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Asesor asignado</b></label>
                <input
                    type="text"
                    class="form-control"
                    id=""
                    name=""
                    v-model="sesion.theme"
                    placeholder="Pepito Perez"
                    disabled
                  />
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Fecha de asignación</b></label>
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

          </div>

          <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-3">
            <div class="row mb-3 hidden-sm">
                <br/>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"
                  ><b>Fecha de respuesta</b>
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
                <label for="" class="form-label"><b>Respuesta</b></label>
                <textarea class="form-control" id="" rows="5" placeholder="Respuesta al caso" disabled></textarea>
              </div>
            </div>
          </div>

        </div>

        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-3">
               <h3 class="mb-2 text-secondary"><b>Trazabilidad</b></h3>
               <div class="row">
                   <table class="table table-bordered table-striped table-lg">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">Estado</th>
                                <th scope="col" class="w-50 ">Gestión</th>
                                <th scope="col">Asesor</th>
                                <th scope="col">Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Jacob</td>
                                <td>Thornton</td>
                                <td>@fat</td>
                            </tr>
                        </tbody>
                    </table>
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
