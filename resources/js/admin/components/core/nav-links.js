const adminPrefixSlug = 'dashboard/admin'
const adminRoutes = [
    {
        to: `/${adminPrefixSlug}/home`,
        icon: 'mdi-view-dashboard',
        slug: 'dashboard'
    },

    {
        to: `#`,
        icon: 'mdi-cog',
        slug: 'settings',
        subLinks: [
            {
                to: `/${adminPrefixSlug}/user-profile`,
                icon: 'mdi-account',
                slug: 'user_profile'
            },
            {
                to: `#`,
                icon: '#',
                slug: 'first_level',
                subLinks: [
                    {
                        to: ``,
                        icon: 'mdi-arrow-right-bold ',
                        slug: 'second_level'
                    },
                ]
            },
        ]
    }
]

export default adminRoutes
