import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const routes = [{
        path: '/',
        name: 'home',
        component: () =>
            import ( /* webpackChunkName: "home" */ '../views/Home.vue')
    },
    {
        path: '/produtos',
        name: 'products',
        component: () =>
            import ( /* webpackChunkName: "produtos" */ '../views/ProdutosView.vue')
    },
    {
        path: '/produtos/:id',
        name: 'product',
        component: () =>
            import ( /* webpackChunkName: "produto" */ '../views/ProductView.vue')
    }
]

const router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    routes
})

export default router