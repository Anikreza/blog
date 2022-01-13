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
            slug: 'user-profile',
            requiresAuth: true
        },
        component: () => import(`@/views/UserProfile.vue`)
    },
    {
        path: 'articles',
        name: 'articles',
        meta: {name: 'Articles', slug: 'articles', requiresAuth: true},
        component: () => import(`@/views/Articles/List.vue`)
    },
    {
        path: 'create-article',
        name: 'new-article',
        meta: {name: 'New Article', slug: 'new-article', requiresAuth: true},
        component: () => import(`@/views/Articles/New.vue`),
    },
    {
        path: 'articles/:slug/edit',
        name: 'edit-articles',
        meta: {name: 'Edit Article', slug: 'edit-article', requiresAuth: true},
        component: () => import(`@/views/Articles/Edit.vue`),
    },
    {
        path: 'categories',
        name: 'categories',
        meta: {name: 'Categories', slug: 'categories', requiresAuth: true},
        component: () => import(`@/views/Categories/List.vue`),
    },
    {
        path: 'pages',
        name: 'pages',
        meta: {name: 'Pages', slug: 'pages', requiresAuth: true},
        component: () => import(`@/views/Pages/List.vue`)
    },
    {
        path: 'create-page',
        name: 'new-page',
        meta: {name: 'New Article', slug: 'new-article', requiresAuth: true},
        component: () => import(`@/views/Pages/New.vue`),
    },
    {
        path: 'pages/:slug/edit',
        name: 'edit-pages',
        meta: {name: 'Edit Page', slug: 'edit-page', requiresAuth: true},
        component: () => import(`@/views/Pages/Edit.vue`),
    },
    {
        path: 'ad-spaces',
        name: 'ad-spaces',
        meta: {name: 'AdSpace', slug: 'ad-spaces', requiresAuth: true},
        component: () => import(`@/views/AdSpace/List.vue`)
    },
    {
        path: 'widget-settings',
        name: 'widget-settings',
        meta: {name: 'Widget Settings', slug: 'widget-settings', requiresAuth: true},
        component: () => import(`@/views/Settings/WidgetSettings.vue`),
    },
    {
        path: 'system-settings',
        name: 'system-settings',
        meta: {name: 'System Settings', slug: 'system-settings', requiresAuth: true},
        component: () => import(`@/views/Settings/SystemSettings.vue`),
    }
]

export default routes
