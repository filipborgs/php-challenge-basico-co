import Vue from 'vue'
import App from './App.vue'
import VueMaterial from 'vue-material'
import 'vue-material/dist/vue-material.min.css'
import 'vue-material/dist/theme/default.css'
import router from './router'
import "./plugins/axios"
import Vuelidate from 'vuelidate'
import store from './store';

Vue.use(Vuelidate)
Vue.use(VueMaterial)

Vue.config.productionTip = false

new Vue({
    router,
    store,
    render: h => h(App)
}).$mount('#app')