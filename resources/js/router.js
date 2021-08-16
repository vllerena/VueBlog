import Router from 'vue-router'
import Vue from "vue";
Vue.use(Router)
import home from "./components/pages/home";
import tags from "./admin/components/pages/tags";
import categories from "./admin/components/pages/categories";
import usecom from "./vuex/usecom";
import adminusers from "./admin/components/pages/adminusers";
import login from "./admin/components/pages/login"

const routes = [
    {
        path: '/',
        component: home,
    },
    {
        path: '/login',
        component: login,
        name: 'login'
    },
    {
        path: '/vuex',
        component: usecom,
    },
    {
        path: '/tags',
        component: tags,
    },
    {
        path: '/categories',
        component: categories,
    },
    {
        path: '/adminusers',
        component: adminusers,
    },
]

export default new Router({
    mode: 'history',
    routes
})
