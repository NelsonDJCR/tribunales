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
      <label for="" class="p-2">Tribunales/ detalles de sorteo</label>
      <div class="row p-2 text-center border shadow mb-2">
        <div class="row">
          <h1 class="text-blue"><b>VISUALIZACIÓN SORTEO</b></h1>
        </div>
      </div>
    </div>
    <div class="mt-5"></div>
    <div class="container row mt-3">
      <div class="col-5">
        <label for="nombre">Nombre del sorteo</label>
        <input
          type="text"
          id="nombre"
          class="form-control"
          v-model="sor.nombre"
          disabled
        />
      </div>
      <div class="col-5">
        <label for="eleccion">Tipo de elección</label>
        <input
          type="text"
          class="form-control"
          v-model="eleccion.nombre"
          disabled
        />
      </div>
    </div>

    <div class="table-responsive mt-3">
      <table class="table">
        <thead>
          <tr>
            <th class="w-50 p-4">Departamentos</th>
            <th class="w-50"></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(i, index) in departamentos" :key="index">
            <td class="p-4">{{ i.dep_nombre }}</td>
            <td>
              {{ i.mag_nombre }}
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="mt-3">
        <button class="btn btn-secondary active" @click="regresar">Regresar</button>
    </div>
  </div>
</template>

<script>
export default {
  props: ["id"],
  data() {
    return {
      departamentos: [],
      sor: {},
      eleccion: {},
    };
  },
  created() {
    let url = "/detalles_sorteo/" + this.id;
    axios.get(url).then((res) => {
      this.departamentos = res.data.sorteo;
      this.sor = res.data.sor;
      this.eleccion = res.data.eleccion;
    });
  },
  methods: {
      regresar(){
          this.$emit("pantalla", 'lista')
      }
  }
};
</script>
