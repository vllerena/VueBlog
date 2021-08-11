import Router from 'vue-router'
import Vue from "vue";
Vue.use(Router)
import home from "./components/pages/home";
import tags from "./components/pages/tags";

const routes = [
    {
        path: '/',
        component: home,
    },
    {
        path: '/tags',
        component: tags,
    },
]

export default new Router({
    mode: 'history',
    routes
})
