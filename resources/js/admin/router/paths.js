import store from '../store'
import adminRoutes from '@/router/adminRoutes'

export default [
    {
        path: '*',
        meta: {
            name: '404',
            requiresAuth: false
        },
        redirect: {
            path: '/dashboard/404'
        }
    },
    {
        path: '/dashboard/404',
        name: 'not-found',
        meta: {
            name: 'Not Found',
            slug: 'not_found',
            requiresAuth: false
        },
        component: () => import(`@/views/errors/404.vue`)
    },
    {
        path: '/dashboard',
        meta: {
            name: 'Dashboard',
            requiresAuth: false
        },
        redirect: {
            path: '/dashboard/login'
        }
    },
    // This  allows you to have pages apart of the app but no rendered inside the dash
    {
        path: '/dashboard',
        meta: {
            name: 'Login',
            requiresAuth: false
        },
        component: () =>
            import(/* webpackChunkName: "routes" */ `@/views/LoginHome.vue`),
        // redirect if already signed in
        beforeEnter: (to, from, next) => {
            if (store.getters.authorized) {
                next('/dashboard/admin/home')
            } else {
                next()
            }
        },
        children: [
            {
                path: 'login',
                component: () => import(`@/components/LoginForm.vue`)
            }
        ]
    },
    // add any extra routes that you want rendered in the dashboard as a child below. Change toolbar names here
    {
        path: '/dashboard/admin',
        meta: {
            name: 'Dashboard',
            requiresAuth: false
        },
        redirect: {
            path: '/dashboard/admin/home'
        }
    },
    {
        path: '/dashboard/admin',
        meta: {
            name: 'Dashboard',
            requiresAuth: true
        },
        component: () => import(`@/views/DashboardView.vue`),
        children: adminRoutes
    }
]
