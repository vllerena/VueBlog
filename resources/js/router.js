import Router from 'vue-router'
import Vue from "vue";
Vue.use(Router)
import firstPage from './components/pages/myFirstVuePage.vue'

const routes = [
    {
        path: '/my-new-vue-route',
        component: firstPage,
    },
]

export default new Router({
    mode: 'history',
    routes
})
