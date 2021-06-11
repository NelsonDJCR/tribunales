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
            >Tribunales de Garantía / Listado de Actividades / Nueva actividad
          </label>
        </li>
      </ol>
      <div class="row p-2 text-center border shadow rounded-3">
        <div class="row">
          <div class="col-12 col-md-12 col-lg-10 col-xl-10 p-2">
            <h1 class="text-blue"><b>NUEVA ACTIVIDAD</b></h1>
          </div>
          <div class="col-12 col-md-12 col-lg-2 col-xl-2 p-2">
            <router-link
              :to="`/tribunales/listado-de-actividades`"
              @click.native="$router.go()"
              class="btn btn-danger text-white w-100 mt-2"
              >Cancelar</router-link
            >
          </div>
        </div>
      </div>

      <form @submit.prevent="save">
        <div class="row">
          <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-5">
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Fecha</b> </label>
                <div class="input-group">
                  <input
                    v-model="form.fecha"
                    type="date"
                    class="form-control"
                  />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Tema</b></label>
                <input
                  type="text"
                  class="form-control"
                  id=""
                  name=""
                  :maxlength="150"
                  v-model="form.tema"
                />
              </div>
            </div>

            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Descripción</b></label>
                <textarea
                  v-model="form.descripcion"
                  class="form-control"
                  :maxlength="501"
                  id=""
                  rows="3"
                ></textarea>
              </div>
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Departamento</b></label>
                <select
                  v-on:change="changeCity()"
                  v-model="form.dep_id"
                  class="form-select"
                  name="dep_id"
                  id="departamento_id"
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
            </div>
            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Ciudad</b> </label>
                <select
                  v-model="form.ciu_id"
                  class="form-select"
                  name="dep_id"
                  id="dep_id"
                >
                  <option value="">Selecciona</option>
                  <option
                    v-for="(i, index) in ciudades"
                    :key="index"
                    v-text="i.nombre"
                    :value="i.id"
                  ></option>
                </select>
              </div>
            </div>
          </div>

          <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-5">
            <div class="row" v-if="origen == 'actividades'">
              <div class="mb-3">
                <label for="" class="form-label"><b>Magistrado</b></label>
                <select
                  v-model="form.id_magistrado"
                  class="form-select"
                  name="dep_id"
                  id="dep_id"
                >
                  <option value="">Selecciona</option>
                  <option
                    v-for="(i, index) in magistrados"
                    :key="index"
                    v-text="i.nombre"
                    :value="i.id"
                  ></option>
                </select>
              </div>
            </div>

            <div class="row">
              <div class="mb-3">
                <label for="" class="form-label"><b>Tribunal</b></label>
                <select v-model="form.tribunal_id" class="form-select">
                  <option value="">Selecciona</option>
                  <option
                    v-for="(i, index) in tribunales"
                    :key="index"
                    v-text="i.nombre"
                    :value="i.id"
                  ></option>
                </select>
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
                  v-model="form.id_tipo_archivo"
                >
                  <option
                    v-for="(i, index) in type_file"
                    :key="index"
                    :value="i.id"
                    v-text="i.nombre"
                  ></option>
                </select>
              </div>
            </div>
            <div class="row mt-5" @click="box_file()">
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

            <div class="row">
              <div class="mb-1">
                <label for="" class="form-label"><b>Archivos</b></label>
                <div class="row">
                  <div class="btns-block d-grid gap-2">
                    <ul class="list-group btn-group-vertical">
                      <li
                        class="list-group-item"
                        v-for="(i, index) in archivos"
                        :key="index"
                      >
                        <button class="btn btn-light btn-sm mt-2">
                          <span class="text-start float-start mt-1">
                            <select
                              class="form-control bg-transparent text-dark"
                              style="outline: none"
                              v-model="i.id_tipo_archivo"
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
                          <button
                            class="badge bg-danger float-end text-end m-1"
                            @click="eliminar_archivo(index)"
                          >
                            <i class="fa fa-trash fa-md"></i>
                          </button>
                        </button>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <input
              type="file"
              id="file"
              accept=".pdf, .png, jpg"
              class="d-none"
              @change="upload_file($event)"
            />
            <!-- <input type="hidden" v-model="form.token"> -->
            <div class="d-grid gap-2 col-6 mx-auto">
              <button type="submit" class="btn btn-primary">
                Crear Actividad
              </button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>
<script>
export default {
  props: ["id"],
  data() {
    return {
      type_file: [],
      tipo_archivo: [],
      ciudades: [],
      departament: [],
      archivos: [],
      tribunales: [],
      magistrados: [],
      form: { id_tipo_archivo: "" },
      documentos: [],
      origen: "",
      index: 0,
    };
  },
  created() {
    if (this.id) {
      this.origen = "magistrado";
    } else {
      this.origen = "actividades";
    }
    axios.get("/data-select").then((r) => {
      this.ciudades = r.data.ciudades;
      this.departament = r.data.departamentos;
      this.type_file = r.data.tipo_archivos;
      this.magistrados = r.data.magistrados;
      this.tribunales = r.data.tribunales;
    });
    this.form.token = Math.floor(Math.random() * (9999 - 5000)) + 5000;
  },
  methods: {
    box_file() {
      if (this.form.id_tipo_archivo != "") {
        $("#file").trigger("click");
      } else {
        Swal.fire("¡Error!", "Selecciona un tipo de archivo", "error");
      }
    },
    upload_file(event) {
      for (let index = 0; index < this.tipo_archivo.length; index++) {
        if (this.tipo_archivo[index] == this.form.id_tipo_archivo) {
          Swal.fire(
            "¡Advertencia!",
            "Ya usaste este tipo de archivo",
            "warning"
          );
          return;
        }
      }
      this.archivo = event.target.files[0];
      this.archivo["id_tipo_archivo"] = this.form.id_tipo_archivo;
      this.archivos.push(this.archivo);
      this.tipo_archivo.push(this.form.id_tipo_archivo);
      this.form.id_tipo_archivo = "";
      //   console.log(this.archivos);
    },
    changeCity() {
      var id = $("#departamento_id").val();
      console.log(id);
      axios.post("/changeCity", { id: id }).then((r) => {
        this.ciudades = r.data;
      });
    },
    save() {
        if(this.archivos.length == 0){
            Swal.fire('¡Error!','Carga por lo menos un archivo','error')
            return
        }
        // console.log(this.form);
        // return
        let formulario = new FormData()
        formulario.append('ciu_id', this.form.ciu_id)
        formulario.append('dep_id', this.form.dep_id)
        formulario.append('descripcion', this.form.descripcion)
        formulario.append('fecha', this.form.fecha)
        formulario.append('id_magistrado', this.form.id_magistrado)
        formulario.append('tema', this.form.tema)
        formulario.append('tribunal_id', this.form.tribunal_id)
        formulario.append('cantidad', this.archivos.length)

        for (let index = 0; index < this.archivos.length; index++) {
            formulario.append('archivo'+index, this.archivos[index])
        }

        for (let index = 0; index < this.tipo_archivo.length; index++) {
            formulario.append('tipo_archivo'+index, this.tipo_archivo[index])
        }

      axios.post("/guardar-actividad", formulario).then((r) => {
        if (r.data.code == 200) {
          Swal.fire(
            "¡Perfecto!",
            "Datos guardados exitosamente",
            "success"
          ).then(function () {
            location.reload();
          });
        } else if (r.data.code == 406) {
          Swal.fire(
            r.data.msg,
            "Ingrese todos los datos para continuar",
            "warning"
          );
        }
      });
    },
  },
};
</script>





