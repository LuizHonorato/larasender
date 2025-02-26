import Vue from 'vue';
import VueRouter from 'vue-router';
import Login from '../components/LoginComponent';
import App from '../components/App'
import Dashboard from "../components/screens/DashboardComponent";
import Contacts from '../components/screens/ContactsComponent';
import Emails from '../components/screens/EmailsComponent';
import UserProfile from "../components/screens/UserProfileComponent";

Vue.use(VueRouter);

const routes = [
    {path: '/login', name: 'login', component: Login},
    {path: '/', component: App,
        children: [
            {
                path: '/dashboard',
                meta: {
                    auth: true
                },
                name: 'Dashboard',
                component: Dashboard
            },
            {
                path: '/contatos',
                meta: {
                    auth: true
                },
                name: 'Contatos',
                component: Contacts
            },
            {
                path: '/emails',
                meta: {
                    auth: true
                },
                name: 'E-mails',
                component: Emails
            },
            {
                path: '/perfil',
                meta: {
                    auth: true
                },
                name: 'Perfil do usuário',
                component: UserProfile
            }
        ]
    }
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
