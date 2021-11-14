import {createRouter, createWebHistory} from 'vue-router'
import {appConfig} from "@/helper/utility";

const routes = [

    //Login
    {
        path: '/',
        name: 'home-page',
        component: () => import( '@/views/HomePage')
    },


    //SIDE MENU
    {
        path: appConfig.base_administration + '/',
        name: 'admin-dashboard',
        component: () => import( '@/views/Protect/Dashboard')
    },

    //////Gestione Parametri
    {
        path: '/parametri/aeroporti',
        name: 'parametri-aeroporti',
        component: () => import( '@/views/Protect/Parametri/Aeroporti')
    },
    {
        path: '/parametri/voli',
        name: 'parametri-voli',
        component: () => import( '@/views/Protect/Parametri/Voli')
    },


    {
        path: appConfig.base_administration + '/gestione-utenti',
        name: 'admin-gestione-utenti',
        component: () => import( '@/views/Protect/UtentiPermessi/GestioneUtenti')
    },
    {
        path: appConfig.base_administration + '/gestione-permessi',
        name: 'admin-gestione-permessi',
        component: () => import( '@/views/Protect/UtentiPermessi/GestionePermessi')
    },
    {
        path: appConfig.base_administration + '/gestione-ruoli',
        name: 'admin-gestione-ruoli',
        component: () => import( '@/views/Protect/UtentiPermessi/GestioneRuoli')
    },

    //NAV MENU
    {
        path: appConfig.base_administration + '/profile',
        name: 'admin-profilo',
        component: () => import( '@/views/Protect/Profile')
    },
    {
        path: appConfig.base_administration + '/support',
        name: 'admin-supporto',
        component: () => import( '@/views/Protect/Support')
    },

    //Logout
    {
        path: '/logout',
        name: 'logout',
        component: () => import( '@/views/Logout')
    },
    //Login
    {
        path: '/login',
        name: 'login',
        component: () => import( '@/views/Login')
    },


    //404
    {
        path: '/:pathMatch(.*)*',
        component: () => import( '@/views/PageNotFound')
    }
]


const router = createRouter({
    history: createWebHistory(),
    routes
});

router.getByName = (name, fail_go_to_404_route = true) => {
    if (router.hasRoute(name)) {
        let r = router.getRoutes().filter(r => r.name === name)
        if (r.length) {
            return r[0].path;
        }
    }

    if (fail_go_to_404_route) {
        return '/404';
    }
    return false;
};


export default router
