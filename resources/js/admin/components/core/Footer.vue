<template>
    <v-footer
        id="core-footer"
        height="60"
    >
        <div class="footer-items">
            <span
                v-for="link in links"
                :key="link.name"
            >
                <a :class="`font-color-${$store.state.app.color}`"
                   :href="link.Link"
                   class="footer-links">{{ link.name }}</a>
            </span>
        </div>
        <v-spacer/>
        <span class="font-weight-light copyright">
            &copy;
            {{ (new Date()).getFullYear() }}
            <a :class="`font-color-${$store.state.app.color}`"
               href="https://codeproof.de/"
               target="_blank">{{ siteTitle }}</a>
        </span>
    </v-footer>
</template>

<script>
export default {
    data: () => ({
        links: [
            {name: 'Home', Link: '/dashboard'},
            {name: 'Demo', Link: ''},
            {name: 'GitHub', Link: ''}
        ],
        siteTitle: process.env.MIX_APP_NAME
    })
}
</script>

<style>
#core-footer {
    z-index: 0;
}
</style>
