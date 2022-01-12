/**
 * Vue Router
 *
 * @library
 *
 * https://router.vuejs.org/en/
 */

// Lib imports
import Vue from 'vue'
import VueAnalytics from 'vue-analytics'
import Router from 'vue-router'
import VueMeta from 'vue-meta'

// Routes
import paths from './paths'
import store from "@/store";

Vue.use(Router)

// Create a new router
const router = new Router({
    base: '/',
    mode: 'history',
    routes: paths,

    scrollBehavior(to, from, savedPosition) {
        if (savedPosition) {
            return savedPosition
        }
        if (to.hash) {
            return {selector: to.hash}
        }
        return {x: 0, y: 0}
    }
})

// Route guard checks to see if you are logged in, if not reroutes to login
// to is where you are going, matched.some is to find which routes have requiresAuth
router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (store.getters.authorized) {
            next()
            return
        }
        next('/dashboard/login')
    } else {
        next()
    }
})

Vue.use(VueMeta, {
    // optional pluginOptions
    keyName: 'metaInfo',
    attribute: 'data-vue-meta',
    ssrAttribute: 'data-vue-meta-server-rendered',
    tagIDKeyName: 'vmid',
    refreshOnceOnNavigation: true
})

// Bootstrap Analytics
// Set in .env
// https://github.com/MatteoGabriele/vue-analytics
if (process.env.GOOGLE_ANALYTICS) {
    Vue.use(VueAnalytics, {
        id: process.env.GOOGLE_ANALYTICS,
        router,
        autoTracking: {
            page: process.env.NODE_ENV !== 'development'
        }
    })
}

export default router
