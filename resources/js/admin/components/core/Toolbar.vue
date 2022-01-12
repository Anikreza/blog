<template>
    <v-toolbar id="core-toolbar" flat elevation="5">
        <v-app-bar-nav-icon :color="$store.state.app.color" v-if="responsive"
                            @click.stop="onClickBtn"></v-app-bar-nav-icon>

        <v-toolbar-title :class="`font-color-${$store.state.app.color}`">
            {{ pageTitle }}
        </v-toolbar-title>

        <v-spacer/>
        <v-toolbar-items>
            <v-flex
                align-center
                layout
                py-2>
                <v-text-field
                    v-if="responsiveInput"
                    class="mr-4 mt-2 purple-input"
                    :label="`${$t('Common.search')}...`"
                    hide-details
                    color="purple"
                />
                <router-link
                    v-ripple
                    class="toolbar-items"
                    to="/">
                    <v-icon>mdi-home</v-icon>
                </router-link>
                <v-menu
                    bottom
                    left
                    offset-y
                    transition="slide-y-transition">
                    <template v-slot:activator="{ on, attrs }">

                        <v-badge :color="$store.state.app.color" overlap>
                            <template slot="badge">{{ notifications.length }}</template>
                            <div v-ripple v-bind="attrs" v-on="on">
                                <v-icon>mdi-bell</v-icon>
                            </div>
                        </v-badge>

                    </template>

                    <v-card class="notifications-area">
                        <v-list dense>
                            <v-list-item
                                v-for="notification in notifications"
                                :key="notification"
                                @click="onClick">
                                <v-list-item-title v-text="notification"/>
                            </v-list-item>
                        </v-list>
                    </v-card>
                </v-menu>
                <router-link
                    v-ripple
                    class="toolbar-items"
                    :to="{ name: 'user-profile' }">
                    <v-icon>mdi-account</v-icon>
                </router-link>

                <v-icon
                    class="toolbar-items"
                    @click="logout">mdi-power
                </v-icon>
            </v-flex>
        </v-toolbar-items>
    </v-toolbar>
</template>

<script>
import {mapGetters, mapMutations} from 'vuex'

export default {
    data: () => ({
        notifications: [
            'Mike, Thanos is coming',
            '5 new avengers joined the team',
            'You\'re now friends with Capt',
            'Another Notification',
            'Another One - Dj Khalid voice'
        ],
        pageTitle: '',
        responsive: false,
        responsiveInput: false
    }),

    computed: {
        ...mapGetters(['authorized'])
    },

    watch: {
        $route(val) {
            this.pageTitle = this.$t('Core.Nav.' + val.meta.slug)
        }
    },

    mounted() {
        this.onResponsiveInverted()
        window.addEventListener('resize', this.onResponsiveInverted)
        this.pageTitle = this.$t('Core.Nav.' + this.$route.meta.slug)
    },
    beforeDestroy() {
        window.removeEventListener('resize', this.onResponsiveInverted)
    },

    methods: {
        ...mapMutations('app', ['setDrawer', 'toggleDrawer']),
        onClickBtn() {
            this.toggleDrawer()
        },
        onClick() {
            //
        },
        onResponsiveInverted() {
            if (window.innerWidth < 991) {
                this.responsive = true
                this.responsiveInput = false
            } else {
                this.responsive = false
                this.responsiveInput = true
            }
        },
        logout: async function () {
            try {
                await this.$store.dispatch('logout');
            } catch ($e) {
                console.log($e)
            }
            await this.$router.push('/dashboard')
        }
    }
}
</script>

<style>
#core-toolbar a {
    text-decoration: none;
}
</style>
