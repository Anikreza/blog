/**
 * Vue i18n
 *
 * @library
 *
 * http://kazupon.github.io/vue-i18n/en/
 */

// Lib imports
import Vue from 'vue'
import VueI18n from 'vue-i18n'
import messages from '@/lang'
import enValidation from 'vee-validate/dist/locale/en.json'
import deValidation from 'vee-validate/dist/locale/de.json'

if (messages['en']) {
  messages['en']['validation'] = enValidation.messages
}
if (messages['de']) {
  messages['de']['validation'] = deValidation.messages
}

Vue.use(VueI18n)

const i18n = new VueI18n({
  locale: 'de',
  fallbackLocale: 'en',
  messages
})

export default i18n
