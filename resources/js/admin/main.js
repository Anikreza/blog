// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'

// Application imports
import App from '@/App'
import i18n from '@/i18n'
import '@/plugins/veeValidate'
import router from '@/router'
import store from '@/store'
import vuetify from '@/plugins/vuetify'
import '@/plugins/errorLogger'
import helper from '@/plugins/helper';
import VueToastr from "vue-toastr";

Vue.use(VueToastr, {});

Vue.prototype.$helper = helper

Vue.config.productionTip = false

new Vue({
    vuetify,
    i18n,
    router,
    store,
    render: h => h(App),
    mounted() {
        this.$toastr.defaultPosition = "toast-top-right";
    }
}).$mount('#app')
