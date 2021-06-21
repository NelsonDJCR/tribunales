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
          class="form-control bg-transparent"
          v-model="sor.nombre"
          disabled
        />
      </div>
      <div class="col-5">
        <label for="eleccion">Tipo de elección</label>
        <input
          type="text"
          class="form-control bg-transparent"
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
              <select
                class="form-select"
                v-model="i.mag_id"
                @change="cambiar(i, index)"
                :disabled="i.disa == 1"
              >
                <option
                  v-for="(i, index) in magistrados"
                  :key="index"
                  :value="i.id"
                  v-text="i.nombre"
                ></option>
              </select>
              <!-- {{ i.mag_nombre }} -->
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="row mt-3">
      <div class="col-2">
        <button class="btn btn-secondary active" @click="regresar">
          Regresar
        </button>
      </div>
      <div class="col-2">
        <button class="btn btn-secondary active" @click="editar">
          Editar
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["id"],
  data() {
    return {
      departamentos: [],
      magistrados: [],
      disabl: 0,
      sor: {},
      mag_id: [],
      eleccion: {},
      departamento: {
        dep_nombre: "",
        mag_nombre: "",
        mag_id: "",
        dep_id: "",
        id: 0,
      },
    };
  },
  created() {
    let url = "/detalles_sorteo/" + this.id;
    axios.get(url).then((res) => {
      this.departamentos = res.data.sorteo;
      for (let index = 0; index < this.departamentos.length; index++) {
          if(this.departamentos[index].estado == 1){
              this.departamentos[index]["disa"] = 0;
          }else{
              this.departamentos[index]["disa"] = 1;
          }
        this.mag_id.push(this.departamentos[index].mag_id);
      }
      this.magistrados = res.data.magistrados;
      this.sor = res.data.sor;
      this.eleccion = res.data.eleccion;
    });
  },
  methods: {
    regresar() {
      this.$emit("pantalla", "lista");
    },
    editar() {
      let url = "/editar_sorteo";
      axios.post(url, this.departamentos).then((res) => {
        console.log(res.data);
        // Swal.fire('Éxito', res.data.msg, 'success');
      });
    },
    cambiar(i, index) {
      // alert(i.dep_nombre)

      this.departamentos[index]["disa"] = 1;
      this.departamentos[index]["e_id"] = this.departamentos[index].id;
      // this.departamentos[index]['id_mag']
      this.departamento = { dep_nombre: i.dep_nombre, mag_id: i.mag_id, n_id: 1, dep_id: i.dep_id, sorteo_id: i.sorteo_id };
      this.departamentos.push(this.departamento);
      this.departamentos[index]["mag_id"] = this.mag_id[index];
      this.mag_id.push(this.departamento.mag_id)
    //   this.departamentos[index]["n_id"] = 1;
    },
  },
};
</script>
