<template>
  <div class="main col-12">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active">
        <router-link :to="{ name: 'home' }"><span>Home</span></router-link> /
        <label for="" class="p-2"
          >Tribunales de Garantía / Sorteo de Asignación
        </label>
      </li>
    </ol>
    <div class="row p-2 text-center border shadow rounded-3">
      <div class="row">
        <div class="col-12 col-md-12 col-lg-12 col-xl-12 p-2">
          <h1 class="text-blue"><b>SORTEO DE ASIGNACIÓN</b></h1>
        </div>
        <div class="col-12 col-md-12 col-lg-2 col-xl-2 p-2">
        </div>
      </div>
    </div>

    <div class="container row mt-3">
        <div class="col-5">
            <label for="nombre">Nombre del sorteo</label>
                <input type="text" id="nombre" class="form-control" v-model="sorteo.nombre">
        </div>
        <div class="col-5">
            <label for="eleccion">Tipo de elección</label>
            <select class="form-select" v-model="sorteo.id_tipo_eleccion">
                <option value="">Seleccione</option>
                <option v-for="(i,index) in tipo_eleccion" :key="index" :value="i.id" v-text="i.nombre"></option>
            </select>
        </div>
    </div>

    <div class="container mt-3">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Departamentos</th>
                    <th>Cantidad</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(i,index) in departamentos" :key="index">
                    <td>{{ i.nombre }}</td>
                    <td>
                        <input type="number" step="10" max="4" min="0" class="form-control" placeholder="Cantidad de magistrados" v-model="cant[index]">
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="container row mt-4">
        <div class="col-4"></div>
        <div class="col-4">
            <button class="btn btn-secondary active btn-block" @click="sortear">Sortear</button>
        </div>
        <div class="col-4"></div>
    </div>

  </div>
</template>

<script>
export default {
    data(){
        return{
            departamentos: [],
            dep:[],
            cant_mag: [],
            tipo_eleccion: [],
            cant: {},
            sorteo: {nombre: '', id_tipo_eleccion: ''},
        }
    },
    created(){
        let url = '/departamentos_sorteo'
        axios.post(url).then(res => {
            this.departamentos = res.data.departamentos
            this.tipo_eleccion = res.data.tipo_eleccion
        })
    },
    methods:{
        sortear(){
            let formulario = new FormData()
            formulario.append('nombre', this.sorteo.nombre)
            formulario.append('id_tipo_eleccion', this.sorteo.id_tipo_eleccion)
            for (let index = 0; index < this.departamentos.length; index++) {
                if(this.cant[index] != undefined && this.cant[index] != '' && this.cant[index] != null){
                    this.dep.push(this.departamentos[index].id)
                    this.cant_mag.push(this.cant[index])
                }
            }

            for (let index = 0; index < this.cant_mag.length; index++) {
                formulario.append('cant'+index, this.cant_mag[index])
                formulario.append('dep'+index, this.dep[index])
            }
            formulario.append('cantidad', this.cant_mag.length)

            axios.post('/departamentos_sortear', formulario).then(res => {
                if(res.data.status == 200){
                    Swal.fire('¡Éxito!',res.data.msg,'success').then(() => {
                        location.reload()
                    })
                }else if(res.data.status == 406){
                    Swal.fire('¡Error!',res.data.msg,'error')
                }
            })
        }
    }
}
</script>
