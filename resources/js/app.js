import $ from 'jquery';
require('./bootstrap');
import router from './routes'
import { useRoute } from 'vue-router';

window.Vue = require('vue');

Vue.component('listarSesiones', require('./components/listarSesiones.vue').default);
Vue.component('editar-sesion', require('./components/editar-sesion.vue').default);
Vue.component('tribunales-nuevo', require('./components/tribunales-nuevo.vue').default);
Vue.component('tribunales-editar', require('./components/tribunales-editar.vue').default);
Vue.component('tribunales-ver', require('./components/tribunales-ver.vue').default);
Vue.component('tribunales-nuevo', require('./components/tribunales-nuevo.vue').default);

Vue.component('tribunales-actividades-nuevo', require('./components/tribunales-actividades-nuevo.vue').default);
Vue.component('tribunales-actividades-editar', require('./components/tribunales-actividades-editar.vue').default);
Vue.component('tribunales-actividades-ver', require('./components/tribunales-actividades-ver.vue').default);
Vue.component('cuentas-cobro-nuevo', require('./components/cuentas-cobro-nuevo.vue').default);
Vue.component('cuentas-cobro-editar', require('./components/cuentas-cobro-editar.vue').default);
Vue.component('cuentas-cobro-ver', require('./components/cuentas-cobro-ver.vue').default);
Vue.component('tribunales-magistrados-nuevo', require('./components/tribunales-magistrados-nuevo.vue').default);
Vue.component('tribunales-magistrados-ver', require('./components/tribunales-magistrados-ver.vue').default);
Vue.component('tribunales-magistrados-editar', require('./components/tribunales-magistrados-editar.vue').default);

// Vue.component('tipo-documento', require('./components/tipoDocumento_J/index.vue').default);

Vue.directive('permiso', function (el, binding,vnode) {
  if(superAdmin == '1'){
    return vnode.elm.hidden = false;
  }else{
    if(Permissions.indexOf(binding.value) !== -1){
        return vnode.elm.hidden = false;
    }else{
        return vnode.elm.hidden = true;
    }
  }
})

const app = new Vue({
    router,
    el: '#app',
    props: {},
    components:{
    },
    data :{
      menu : 0,
    },
    methods: {
    },
});
