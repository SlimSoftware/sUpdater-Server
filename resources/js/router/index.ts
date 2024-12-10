import { RouteRecordRaw, createRouter, createWebHashHistory } from 'vue-router';
import LogIn from '../views/LogIn.vue';
import AppList from '../views/apps/AppList.vue';
import EditApp from '../views/apps/EditApp.vue';
import NewApp from '../views/apps/NewApp.vue';
import { useGlobalStore } from '../stores/global';

const routes: RouteRecordRaw[] = [
    {
        path: '/',
        redirect: '/apps'
    },
    {
        path: '/login',
        name: 'login',
        component: LogIn,
        meta: {
            pageTitle: 'Log In'
        }
    }
    // {
    //     path: '/apps',
    //     component: AppList,
    // },
    // {
    //     path: '/apps/:id',
    //     component: EditApp,
    // },
    // {
    //     path: 'apps/new',
    //     component: NewApp,
    // },
];

const router = createRouter({
    routes,
    history: createWebHashHistory()
});

router.beforeEach((to) => {
    const globalStore = useGlobalStore();
    globalStore.pageTitle = to.meta.pageTitle as string;
});

export default router;
