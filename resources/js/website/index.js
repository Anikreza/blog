import Vue from 'vue';
import axios from 'axios'

import {configure, extend} from 'vee-validate'
import {email, required, min} from 'vee-validate/dist/rules'
import i18n from '@/i18n'

configure({
    defaultMessage: (field, values) => {
        values._field_ = field
        return i18n.t(`validation.${values._rule_}`, values)
    }
})

extend('required', required)
extend('email', email)
extend('min', min)


window.routes = {};


Vue.config.productionTip = false;
Vue.prototype.$http = axios;
Vue.prototype.$baseURL = process.env.MIX_APP_URL;

Vue.component('contact-form', require('./contact-form').default);
const app = new Vue({
    el: document.querySelector('#form-plugin'),
});
