import Vue from 'vue'
import Vuetify from 'vuetify'
import theme from './theme'
import 'vuetify/dist/vuetify.min.css'
// import '@mdi/font/css/materialdesignicons.css'
// import 'material-design-icons-iconfont/dist/material-design-icons.css'

const opts = {
    icons: {
        iconfont: 'mdi', // default - only for display purposes
    },
    theme: theme
}


Vue.use(Vuetify)
const vuetify = new Vuetify(opts)

export default vuetify
