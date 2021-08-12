import Router from 'vue-router'
import Vue from "vue";
Vue.use(Router)
import home from "./components/pages/home";
import tags from "./admin/components/pages/tags";
import categories from "./admin/components/pages/categories";

const routes = [
    {
        path: '/',
        component: home,
    },
    {
        path: '/tags',
        component: tags,
    },
    {
        path: '/categories',
        component: categories,
    },
]

export default new Router({
    mode: 'history',
    routes
})
