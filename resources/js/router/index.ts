import { RouteRecordRaw, createRouter, createWebHashHistory } from 'vue-router';
import LogIn from '../views/LogIn.vue';
import AppList from '../views/apps/AppList.vue';
import EditApp from '../views/apps/EditApp.vue';
import NewApp from '../views/apps/NewApp.vue';

const routes: RouteRecordRaw[] = [
    {
        path: '/',
        redirect: '/apps',
    },
    {
        path: '/login',
        component: LogIn,
    },
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
    history: createWebHashHistory(),
});

export default router;
