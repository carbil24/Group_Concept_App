require('./bootstrap');

window.Vue = require('vue');

// ES6 Modules or TypeScript
import Swal from 'sweetalert2'
// CommonJS
window.Swal = Swal;

const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000,
})
window.Toast = Toast;

import VueRouter from 'vue-router'
Vue.use(VueRouter)

import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
Vue.use(Vuetify);

import '@mdi/font/css/materialdesignicons.css' // Ensure you are using css-loader


let routes = [
        { path: '/admin/categories', component: require('./components/CategoryManagementComponent.vue').default },
        { path: '/admin/suppliers', component: require('./components/SupplierManagementComponent.vue').default },
        { path: '/admin/sectors', component: require('./components/SectorManagementComponent.vue').default },
        { path: '/admin/products', component: require('./components/ProductManagementComponent.vue').default },
        { path: '/admin/users', component: require('./components/UserManagementComponent.vue').default },
        { path: '/admin', component: require('./components/DashboardComponent.vue').default },
        //{ path: '*', component: require('./components/NoAccessComponent.vue').default }
  ]

  const router = new VueRouter({
    mode: 'history',
    routes // short for `routes: routes`
  })

  Vue.component('admin-menu', require('./components/AdminMenuComponent.vue').default);


const app = new Vue({
    el: '#app',
    router,
    vuetify: new Vuetify({
      icons: {
        iconfont: 'mdi'
      }
    }),
})
