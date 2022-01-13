const adminPrefixSlug = 'dashboard/admin'
const adminRoutes = [
    {
        to: `/${adminPrefixSlug}/home`,
        icon: 'mdi-view-dashboard',
        slug: 'dashboard'
    },
    {
        to: `#`,
        icon: 'mdi-briefcase-edit',
        slug: 'articles',
        subLinks: [
            {
                to: `/${adminPrefixSlug}/categories`,
                icon: 'mdi-tag-multiple',
                slug: 'categories'
            },
            {
                to: `/${adminPrefixSlug}/articles`,
                icon: 'mdi-table-edit',
                slug: 'articles'
            },
            {
                to: `/${adminPrefixSlug}/create-article`,
                icon: 'mdi-square-edit-outline',
                slug: 'new-article'
            }
        ]
    },
    {
        to: `#`,
        icon: 'mdi-page-next',
        slug: 'pages',
        subLinks: [
            {
                to: `/${adminPrefixSlug}/pages`,
                icon: 'mdi-table-edit',
                slug: 'pages'
            },
            {
                to: `/${adminPrefixSlug}/create-page`,
                icon: 'mdi-square-edit-outline',
                slug: 'new-page'
            }
        ]
    },
    {
        to: `#`,
        icon: 'mdi-cog',
        slug: 'settings',
        subLinks: [
            {
                to: `/${adminPrefixSlug}/ad-spaces`,
                icon: 'mdi-google-ads',
                slug: 'ad-spaces'
            },
            {
                to: `/${adminPrefixSlug}/widget-settings`,
                icon: 'mdi-saw-blade',
                slug: 'widget-settings'
            },
            {
                to: `/${adminPrefixSlug}/system-settings`,
                icon: 'mdi-cog',
                slug: 'system-settings',
            },
            {
                to: `/${adminPrefixSlug}/user-profile`,
                icon: 'mdi-account',
                slug: 'user-profile'
            },
        ]
    }
]

export default adminRoutes
