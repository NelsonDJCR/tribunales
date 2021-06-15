<template>
  <div class="main col-12">
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x"
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://use.fontawesome.com/releases/v5.15.1/css/all.css"
      integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp"
      crossorigin="anonymous"
    />
    <div class="container mt-5">
      <label for="" class="p-2">Sistema Uriel/Trazabilidad</label>
      <div class="row p-2 text-center border shadow mb-2">
        <div class="row">
          <h1 class="text-blue"><b>TRAZABILIDAD</b></h1>
        </div>
      </div>
    </div>

    <div class="container mt-4">
      <div class="row">
        <div class="col-sm-3">
          <label for="">N° de caso</label>
          <input type="text" class="form-control" v-model="filtros.n_casos" />
        </div>
        <div class="col-sm-3">
          <label for=""></label>
          <button
            class="btn btn-secondary active btn-block mt-1"
            @click="filtrar"
          >
            Buscar
          </button>
        </div>

        <div class="mt-5">
          <table
            v-for="(i, index) in casos"
            :key="index"
            class="table table-striped table-hover text-center table-bordered"
          >
            <thead>
              <tr>
                <th class="align-middle">N° de caso: {{ i.id }}</th>
                <!-- 1 -->
                <th
                  class="align-middle"
                  style="padding: 20px; background: #2d23a3; color: white"
                  v-if="i.id_estado == 1"
                >
                  Recibido<br />
                  {{ i.recibido }}
                </th>
                <th class="align-middle" style="padding: 20px" v-else>
                  Recibido<br />
                  {{ i.recibido }}
                </th>

                <!-- 2 -->

                <th
                  class="align-middle"
                  v-if="i.id_estado == 2"
                  style="background: #2d23a3; color: white"
                >
                  Asignado <br />
                  {{ i.asignado }}
                </th>
                <th class="align-middle" v-else>
                  Asignado <br />
                  {{ i.asignado }}
                </th>

                <!-- 3 -->

                <th
                  class="align-middle"
                  v-if="i.id_estado == 3"
                  style="background: #2d23a3; color: white"
                >
                  En trámite <br />
                  {{ i.tramite }}
                </th>
                <th class="align-middle" v-else>
                  En trámite <br />
                  {{ i.tramite }}
                </th>

                <!-- 4 -->

                <th
                  class="align-middle"
                  v-if="i.id_estado == 4"
                  style="background: #2d23a3; color: white"
                >
                  Finalizado <br />
                  {{ i.finalizado }}
                </th>
                <th class="align-middle" v-else>
                  Finalizado <br />
                  {{ i.finalizado }}
                </th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      pantalla: "listado",
      casos: [],
      filtros: { n_casos: "" },
    };
  },
  //   created() {
  //     let data = this.id;
  //     let url = "/ver-caso/" + data;
  //     let url = "/detalles_trazabilidad";
  //     axios.get(url).then((res) => {
  //       this.casos = res.data.casos;
  //       this.formatearFecha1();
  //       console.log(this.casos);
  //     });
  //   },
  methods: {
    enviarData() {
      this.$emit("pantalla", this.pantalla);
    },
    formatearFecha() {
      var fechas = "";
      var fecha_format = "";
      var array = [];
      for (let index = 0; index < this.trazabilidad.length; index++) {
        fechas = this.trazabilidad[index].fechaGestion;
        array = fechas.split("-");
        array[2] = array[2].split(" ")[0];
        fecha_format = array[2] + "-" + array[1] + "-" + array[0];
        this.trazabilidad[index].fechaGestion = fecha_format;
      }
    },
    // maximo(){
    //     for (let index = 0; index < this.casos.length; index++) {
    //         if(this.casos[index].maximo == this.casos[index].recibido){

    //         }
    //     }
    // },
    formatearFecha1() {
        var array = []
      for (let index = 0; index < this.casos.length; index++) {
        if (this.casos[index].recibido != null) {
          let recibido = this.casos[index].recibido.split(" ");
          array = recibido[0].split('-');
          let fecha_format = array[2] + "-" + array[1] + "-" + array[0];
          this.casos[index].recibido = fecha_format;
        }
        if (this.casos[index].asignado != null) {
          let asignado = this.casos[index].asignado.split(" ");
          array = asignado[0].split('-')
          let fecha_format = array[2] + "-" + array[1] + "-" + array[0];
          this.casos[index].asignado = fecha_format;
        }
        if (this.casos[index].tramite != null) {
          let tramite = this.casos[index].tramite.split(" ");
          array = tramite[0].split('-')
          let fecha_format = array[2] + "-" + array[1] + "-" + array[0]
          this.casos[index].tramite = fecha_format;
        }
        if (this.casos[index].finalizado != null) {
          let finalizado = this.casos[index].finalizado.split(" ");
          array = finalizado[0].split('-')
          let fecha_format = array[2] + "-" + array[1] + "-" + array[0]
          this.casos[index].finalizado = fecha_format;
        }
      }
    },
    filtrar() {
      let url = "filtro_detalles_trazabilidad/";
      axios.post(url, this.filtros).then((res) => {
        if (res.data.status == 200) {
          this.casos = res.data.casos;
          this.formatearFecha1();
        }
      });
    },
  },
};
</script>
