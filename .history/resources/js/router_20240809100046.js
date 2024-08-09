import { createRouter, createWebHistory } from 'vue-router';
import store from './store';
import Login from './components/Login.vue';
import Registration from './components/Register.vue';
import IdentitasIbu from './components/Ibu/IdentitasIbu.vue';
import IdentitasAnak from './components/Anak/IdentitasAnak.vue';
import IdentitasAyah from './components/Ayah/IdentitasAyahNew.vue';
import DashboardIbu from './components/Ibu/Profile.vue';
import HealthRecordIbu from './components/Ibu/HealthRecord.vue';
import QRCode from './components/utils/QRCode.vue';
import UserLayout from './layouts/UserLayout.vue';
import LoginLayout from './layouts/LoginLayout.vue';
import MenuMedis from './components/medis/menu.vue';
import Checkup from './components/medis/checkup.vue';
import CheckupShow from './components/medis/checkupShow.vue';
import MenuIbu from './components/Ibu/menu.vue';
import Dashboard from './components/Dashboard.vue';
import DashboardAnak from './components/Anak/DashboardAnak.vue';
import StatusKehamilan from './components/Ibu/StatusKehamilan.vue';
import KalenderHpl from './components/ibu/KalenderHpl.vue';
import WeeklyMonitoringAnswer from './components/Ibu/WeeklyMonitoringAnswer.vue';
import WeeklyMonitoringResult from './components/Ibu/WeeklyMonitoringResult.vue';
import GrafikEvaluasiKehamilan from './components/Ibu/GrafikEvaluasiKehamilan.vue';
import RiwayatPersalinan from './components/Ibu/RiwayatPersalinan.vue';
import RiwayatPersalinanEdit from './components/Ibu/RiwayatPersalinan_edit.vue';
import ListInfoMedis from './components/InfoMedis/ListInfoMedis.vue';
import InfoMedis from './components/InfoMedis/InfoMedis.vue';
import PregnancyHistory from './components/Ibu/PregnancyHistory.vue';
import StuntingChart from './components/StuntingChart.vue';
import Imunisasi from './components/medis/Imunisasi.vue';
import ChildDevelopmentList from './components/Anak/ChildDevelopmentList.vue';
import ChildDevelopment from './components/Anak/ChildDevelopment.vue';
import DiaryAnak from './components/anak/ChildWeeklyMonitoringResult.vue';
import DiaryAnakEdit from './components/anak/ChildWeeklyMonitoringAnswer.vue';
import PertumbuhanAnak from './components/anak/PertumbuhanAnak.vue';
import History from './components/medis/history.vue';
import HistoryDetail from './components/medis/historyDetail.vue';
import MyProfile from './components/Ibu/MyProfile.vue';

const resolveComponentBasedOnRole = async () => {
    const userRole = store.state.user ? store.state.user.role : null; // Assuming the user's role is stored in the Vuex store
    console.log({ userRole });
    switch (userRole) {
        case null:
            return Dashboard;
        case 'ibu':
            return DashboardIbu;
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
        path:'/history',
        name:'history',
        component: History,
        meta :{
            layout: 'UserLayout',
            requiresAuth: true
        }
    },
    {
        path:'/history/:type/:id',
        name:'history-detail',
        component: HistoryDetail,
        meta :{
            layout: 'UserLayout',
            requiresAuth: true
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
    // Registration Process
    {
        path: '/registration',
        name: 'registration',
        component: Registration,
        meta: {
            layout: 'LoginLayout'
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
            layout: 'UserLayout',
            requiresAuth: true
        }
    },
    {
        path: '/child',
        name: 'child',
        component: IdentitasAnak,
        props: true,
        meta: {
            layout: 'LoginLayout'
        }
    },
    {
        path: '/dashboard-ibu',
        name: 'dashboard-ibu',
        component: DashboardIbu,
        meta: {
            layout: 'UserLayout',
            requiresAuth: false
        }
    },
    // Detail Halaman Ibu
    {
        path: '/my-profile',
        name: 'my-profile',
        component: MyProfile,
        meta: {
            layout: 'UserLayout',
            requiresAuth: true
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
        path: '/grafik-evaluasi-kehamilan',
        name: 'grafik-evaluasi-kehamilan',
        component: GrafikEvaluasiKehamilan,
        props: true,
        meta: {
            layout: 'UserLayout'
        }
    },
    {
        path: '/riwayat-persalinan',
        name: 'riwayat-persalinan',
        component: RiwayatPersalinan,
        props: true,
        meta: {
            layout: 'UserLayout'
        }
    },
    {
        path: '/riwayat-persalinan-edit',
        name: 'riwayat-persalinan-edit',
        component: RiwayatPersalinanEdit,
        props: true,
        meta: {
            layout: 'UserLayout'
        }
    },

    {
        path: '/health-records',
        name: 'health-records',
        component: HealthRecordIbu,
        props: true,
        meta: {
            layout: 'UserLayout'
        }
    },

    {
        path: '/pregnancy_history/:weeks',
        name: 'pregnancy_history',
        component: PregnancyHistory,
        meta: {
            layout: 'UserLayout',
            requiresAuth: true,
        }
    },
    {
        path: '/informasi-medis',
        name: 'informasi-medis',
        component: ListInfoMedis,
        props: true,
        meta: {
            layout: 'UserLayout'
        }
    },
    {
        path: '/informasi-medis/:slug',
        name: 'informasi-medis-detail',
        component: InfoMedis,
        props: true,
        meta: {
            layout: 'UserLayout'
        }
    },
    {
        path: '/imunisasi',
        name: 'imunisasi',
        component: Imunisasi,
        props: true,
        meta: {
            layout: 'UserLayout'
        }
    },
    // child
    {
        path: '/child-development',
        name: 'child-development-list',
        component: ChildDevelopmentList,
        props: true,
        meta: {
            layout: 'UserLayout'
        }
    },
    {
        path: '/child-development/:id',
        name: 'child-development',
        component: ChildDevelopment,
        props: true,
        meta: {
            layout: 'UserLayout'
        }
    },

    // Halaman Anak
    {
        path: '/dashboard-anak',
        name: 'dashboard-anak',
        component: DashboardAnak,
        meta: {
            layout: 'UserLayout',
            requiresAuth: false
        }
    },
    {
        path: '/child-weekly-monitoring-result',
        name: 'child-weekly-monitoring-result',
        component: DiaryAnak,
        meta: {
            layout: 'UserLayout',
            requiresAuth: false
        }
    },
    {
        path: '/child-weekly-monitoring-answer',
        name: 'child-weekly-monitoring-answer',
        component: DiaryAnakEdit,
        meta: {
            layout: 'UserLayout',
            requiresAuth: false
        }
    },
    {
        path: '/pertumbuhan-anak',
        name: 'pertumbuhan-anak',
        component: PertumbuhanAnak,
        meta: {
            layout: 'UserLayout',
            requiresAuth: false
        }
    },
    // Halaman Admin
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
        path: '/checkup',
        name: 'checkup',
        component: Checkup,
        meta: {
            layout: 'UserLayout',
            requiresAuth: true
        }
    },
    {
        path: '/checkup/show',
        name: 'checkup-show',
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
    },
    {
        path: '/pregnancy_history',
        name: 'pregnancy_history',
        component: PregnancyHistory,
        meta: {
            layout: 'UserLayout',
            requiresAuth: true
        }
    },
    //Grafik Stunting
    {
        path: '/stunting_chart',
        name: 'StuntingChart',
        component: StuntingChart,
        meta: {
            layout: 'LoginLayout'
        }
    },

];

const router = createRouter({
    history: createWebHistory(),
    routes
});

router.beforeEach((to, from, next) => {
    // console.log('dispatching fetch user')

    if (to.meta.requiresAuth) {
        store.dispatch('fetchUser').then((res) => {

            console.log('res dari dispatch', {res})
            const isAuthenticated = store.getters.isAuthenticated;
            console.log('im before each', {isAuthenticated})

            if (!isAuthenticated) {
                next({ name: 'login', query: { redirect: to.fullPath } });
            } else {
                next();
            }
        })
    } else {
        store.dispatch('fetchUser'); //fetch juga biar sama
        next();
    }
});

export default router;
