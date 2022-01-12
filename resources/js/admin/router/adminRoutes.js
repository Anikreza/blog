const routes = [
    {
        path: 'home',
        meta: {
            name: 'Dashboard',
            slug: 'dashboard',
            requiresAuth: true
        },
        component: () => import(`@/components/dash-views/Dashboard.vue`)
    },
    {
        path: 'user-profile',
        name: 'user-profile',
        meta: {
            name: 'User Profile',
            slug: 'user_profile',
            requiresAuth: true
        },
        component: () => import(`@/views/UserProfile.vue`)
    },
]

export default routes
