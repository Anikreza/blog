<template>
    <v-app id="dashboard-view" :dark="$store.state.app.isDark">
        <core-drawer/>
        <core-toolbar/>
        <v-main>
            <v-fade-transition mode="out-in">
                <router-view/>
            </v-fade-transition>
        </v-main>
        <!--        <core-footer v-if="$route.meta.name !== 'Maps'"/>-->
    </v-app>
</template>

<script>
import CoreToolbar from '@/components/core/Toolbar'
import CoreDrawer from '@/components/core/Drawer'
import CoreFooter from '@/components/core/Footer'

export default {
    name: 'DashboardView',
    components: {
        CoreDrawer, CoreFooter, CoreToolbar
    },
    metaInfo() {
        return {
            title: `Admin - ${process.env.MIX_APP_NAME}`
        }
    }
}
</script>

<style>

</style>
