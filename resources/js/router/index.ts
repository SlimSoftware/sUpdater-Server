import { RouteRecordRaw, createRouter, createWebHashHistory } from 'vue-router';
import LogIn from '../views/LogIn.vue';
import AppList from '../views/apps/AppList.vue';
import EditApp from '../views/apps/EditApp.vue';
import NewApp from '../views/apps/NewApp.vue';
import { useGlobalStore } from '../stores/global';
import PortableAppList from '../views/portable-apps/PortableAppList.vue';
import NewPortableApp from '../views/portable-apps/NewPortableApp.vue';
import EditPortableApp from '../views/portable-apps/EditPortableApp.vue';

export const routes: RouteRecordRaw[] = [
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
    },
    {
        path: '/apps',
        name: 'apps',
        component: AppList,
        meta: {
            pageTitle: 'Apps',
            showInMenu: true
        }
    },
    {
        path: '/apps/:id',
        component: EditApp,
        name: 'apps-edit'
    },
    {
        path: '/apps/new',
        name: 'apps-new',
        component: NewApp,
        meta: {
            pageTitle: 'New App'
        }
    },
    {
        path: '/portable-apps',
        name: 'portable-apps',
        component: PortableAppList,
        meta: {
            pageTitle: 'Portable Apps',
            showInMenu: true
        }
    },
    {
        path: '/portable-apps/:id',
        name: 'portable-apps-edit',
        component: EditPortableApp
    },
    {
        path: '/portable-apps/new',
        name: 'portable-apps-new',
        component: NewPortableApp
    }
];

const router = createRouter({
    routes,
    history: createWebHashHistory(),
    linkActiveClass: 'active'
});

router.beforeEach((to) => {
    const globalStore = useGlobalStore();
    globalStore.pageTitle = to.meta.pageTitle as string;
});

declare module 'vue-router' {
    interface RouteMeta {
        pageTitle?: string;
        showInMenu?: boolean;
    }
}

export default router;
