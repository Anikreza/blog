<template>
    <v-navigation-drawer
        id="app-drawer"
        v-model="$store.state.app.drawer"
        app
        floating
        persistent
        width="260"
        fixed
        hide-overlay
        :mobile-breakpoint="991"
    >
        <v-img
            :src="image"
            height="100%"
        >
            <v-layout
                class="fill-height"
                tag="v-list"
                column
            >
                <v-list dense nav class="navigation-wrapper">
                    <v-list-item>
                        <v-img
                            @click="openHomePage"
                            :src="logo"
                            height="55"
                            contain
                        />
                    </v-list-item>
                    <v-divider/>
                    <v-list-item
                        v-if="responsive"
                    >
                        <v-text-field
                            class="purple-input search-input"
                            :label="`${$t('Common.search')}...`"
                            color="purple"
                        />
                    </v-list-item>

                    <div v-for="(parentLink, i) in routes">

                        <div v-if="parentLink.subLinks !== undefined && parentLink.subLinks.length">
                            <v-list-group
                                dense
                                class="parent-group-items"
                                v-model="parentLink.active"
                                :prepend-icon="parentLink.icon"
                                :key="i"
                                :to="parentLink.to === '#' ? '': parentLink.to"
                                :active-class="`bg-color-${$store.state.app.color}`"
                            >
                                <template v-slot:activator>
                                    <v-list-item-content>
                                        <v-list-item-title v-text="$t('Core.Nav.'+ parentLink.slug)"/>
                                    </v-list-item-content>
                                </template>

                                <div v-for="(childLink, j) in parentLink.subLinks">
                                    <DrawerGroupItem :link-info="childLink" :key="j"/>
                                </div>
                            </v-list-group>
                        </div>

                        <div v-else>
                            <DrawerSingleItem @click="collapseAll" :link-info="parentLink"/>
                        </div>

                    </div>
                </v-list>
            </v-layout>
        </v-img>

        <template v-slot:append>
            <div class="pa-2 filter-wrapper">
                <core-filter/>
            </div>
        </template>
    </v-navigation-drawer>
</template>

<script>
// Utilities
import {mapMutations, mapState} from 'vuex'
import routes from '@/components/core/nav-links'
import CoreFilter from '@/components/core/Filter'
import DrawerSingleItem from '@/components/core/drawer-partials/DrawerSingleItem'
import DrawerGroupItem from '@/components/core/drawer-partials/DrawerGroupItem'
import logo from '@/assets/img/logo.png'

export default {
    components: {
        CoreFilter, DrawerSingleItem, DrawerGroupItem
    },
    data: () => ({
        routes,
        responsive: false,
        logo
    }),
    computed: {
        ...mapState('app', ['image', 'color']),
        siteTitle() {
            return process.env.MIX_APP_NAME
        },
        siteUrl() {
            return process.env.MIX_APP_URL
        }
    },
    mounted() {
        this.onResponsiveInverted()
        window.addEventListener('resize', this.onResponsiveInverted)
    },
    beforeDestroy() {
        window.removeEventListener('resize', this.onResponsiveInverted)
    },
    methods: {
        ...mapMutations('app', ['setDrawer', 'toggleDrawer']),
        onResponsiveInverted() {
            this.responsive = window.innerWidth < 991
        },
        collapseAll() {
            this.routes.map(link => {
                link.active = false
                return link
            })
        },
        openHomePage() {
            window.open(this.siteUrl, '_blank')
        }
    }
}
</script>

<style lang="scss">
#app-drawer {
    .v-list__item {
        border-radius: 4px;
    }

    .v-image__image--contain {
        top: 9px;
        height: 60%;
    }

    .search-input {
        margin-bottom: 30px !important;
        padding-left: 15px;
        padding-right: 15px;
    }
}
</style>
