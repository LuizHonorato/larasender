import Vue from 'vue';
import VueRouter from 'vue-router';
import Login from '../components/LoginComponent';
import Dashboard from '../components/DashboardComponent'

Vue.use(VueRouter);

const routes = [
    {path: '/login', name: 'login', component: Login},
    {
        path: '/dashboard',
        meta: {
            auth: true
        },
        name: 'dashboard',
        component: Dashboard
    },
];

const router = new VueRouter({
    // mode: 'history',
    // base: process.env.BASE_URL,
    routes
});

router.beforeEach((to, from, next) => {
    const loggedIn = localStorage.getItem('user');

    if(to.matched.some(record => record.meta.auth) && !loggedIn) {
        next('/login')
        return
    }

    next()
});

export default router
