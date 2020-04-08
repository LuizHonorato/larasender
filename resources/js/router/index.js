import Vue from 'vue';
import VueRouter from 'vue-router';
import Login from '../components/LoginComponent';
import App from '../components/App'
import Dashboard from "../components/screens/DashboardComponent";
import Contacts from '../components/screens/ContactsComponent';
import Emails from '../components/screens/EmailsComponent';
import Campaigns from "../components/screens/CampaignsComponent";
import Templates from "../components/screens/TemplatesComponent";
import LandingPages from "../components/screens/LandingPagesComponent";

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
                path: '/campanhas',
                meta: {
                    auth: true
                },
                name: 'Campanhas',
                component: Campaigns
            },
            {
                path: '/templates',
                meta: {
                    auth: true
                },
                name: 'Templates de e-mails',
                component: Templates
            },
            {
                path: '/landing-pages',
                meta: {
                    auth: true
                },
                name: 'Landing Pages',
                component: LandingPages
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
