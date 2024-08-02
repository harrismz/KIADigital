import { createRouter, createWebHistory } from 'vue-router';
import store from './store';
import Login from './components/Login.vue';
import Registration from './components/Register.vue';
import IdentitasIbu from './components/Ibu/IdentitasIbu.vue';
import IdentitasAyah from './components/Ayah/IdentitasAyah.vue';
import Profile from './components/Ibu/Profile.vue';
import HealthRecordIbu from './components/Ibu/HealthRecord.vue';
import QRCode from './components/utils/QRCode.vue';
import UserLayout from './layouts/UserLayout.vue';
import LoginLayout from './layouts/LoginLayout.vue';
import MenuMedis from './components/medis/menu.vue';
import Checkup from './components/medis/checkup.vue';
import CheckupShow from './components/medis/checkupShow.vue';
import MenuIbu from './components/ibu/menu.vue';
import Dashboard from './components/Dashboard.vue';
import StatusKehamilan from './components/ibu/StatusKehamilan.vue';
import KalenderHpl from './components/ibu/KalenderHpl.vue';
import WeeklyMonitoringAnswer from './components/ibu/WeeklyMonitoringAnswer.vue';
import WeeklyMonitoringResult from './components/ibu/WeeklyMonitoringResult.vue';

const resolveComponentBasedOnRole = async () => {
    const userRole = store.state.user ? store.state.user.role : null; // Assuming the user's role is stored in the Vuex store

    switch (userRole) {
        case null:
            return Dashboard;
        case 'ibu':
            return MenuIbu;
        case 'ayah':
            return IdentitasAyah;
        default:
            return Checkup;
    }
};

const routes = [
    {
        path: '/login',
        name: 'login',
        component: Login,
        meta: {
            layout: 'LoginLayout'
        }
    },
    {
        path: '/registration',
        name: 'registration',
        component: Registration,
        meta: {
            layout: 'LoginLayout'
        }
    },
    {
        path: '/qr-code/:id',
        name: 'QRCode',
        component: QRCode,
        meta: {
            layout: 'UserLayout'
        }
    },
    {
        path: '/identitas-ibu',
        name: 'identitas-ibu',
        component: IdentitasIbu,
        props: true,
        meta: {
            layout: 'LoginLayout'
        }
    },
    {
        path: '/identitas-ayah',
        name: 'identitas-ayah',
        component: IdentitasAyah,
        props: true,
        meta: {
            layout: 'LoginLayout'
        }
    },
    {
        path: '/status-kehamilan',
        name: 'status-kehamilan',
        component: StatusKehamilan,
        props: true,
        meta: {
            layout: 'LoginLayout'
        }
    },
    {
        path: '/kalender-hpl',
        name: 'kalender-hpl',
        component: KalenderHpl,
        props: true,
        meta: {
            layout: 'LoginLayout'
        }
    },
    {
        path: '/weekly-monitoring-answer',
        name: 'weekly-monitoring-answer',
        component: WeeklyMonitoringAnswer,
        props: true,
        meta: {
            layout: 'UserLayout'
        }
    },
    {
        path: '/weekly-monitoring-result',
        name: 'weekly-monitoring-result',
        component: WeeklyMonitoringResult,
        props: true,
        meta: {
            layout: 'UserLayout'
        }
    },
    {
        path: '/admin',
        name: 'Admin',
        component: resolveComponentBasedOnRole,
        meta: {
            layout: 'UserLayout',
            requiresAuth: true
        }
    },
    {
        path: '/',
        name: 'home',
        component: Dashboard,
        meta: {
            layout: 'UserLayout',
            requiresAuth: false
        }
    },
    {
        path: '/dashboard',
        name: 'dashboard',
        component: Dashboard,
        meta: {
            layout: 'UserLayout',
            requiresAuth: false
        }
    },
    {
        path: '/checkup-anak',
        name: 'checkup-anak',
        component: Checkup,
        meta: {
            layout: 'UserLayout',
            requiresAuth: true
        }
    },
    {
        path: '/profile',
        name: 'user-profile',
        component: Profile,
        meta: {
            layout: 'UserLayout',
            requiresAuth: false
        }
    },
    {
        path: '/admin/checkup',
        name: 'admin-checkup',
        component: Checkup,
        meta: {
            layout: 'UserLayout',
            requiresAuth: true
        }
    },
    {
        path: '/admin/checkup/show',
        name: 'admin-checkup-show',
        component: CheckupShow,
        meta: {
            layout: 'UserLayout',
            requiresAuth: true
        }
    },
    {
        path: '/health-record-ibu',
        name: 'health-record-ibu',
        component: HealthRecordIbu,
        meta: {
            layout: 'UserLayout',
            requiresAuth: true
        }
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth) {
        const isAuthenticated = store.getters.isAuthenticated;

        if (!isAuthenticated) {
            next({ name: 'login' });
        } else {
            next();
        }
    } else {
        next();
    }
});

export default router;
