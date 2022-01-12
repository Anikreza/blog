import { set, toggle } from '@/utils/vuex'

export default {
  setDrawer: (state, payload) => set('drawer', payload),
  setImage: (state, payload) => set('image', payload),
  setColor: (state, payload) => set('color', payload),
  setIfDark: (state, payload) => (state['isDark'] = payload),
  setLocale: (state, payload) => (state['locale'] = payload),
  toggleDrawer: toggle('drawer'),
  setCountryList: (state, payload) => (state['countries'] = payload),
  setSnackbarMessage: (state, payload) => (state['snackbarMessage'] = payload),
  toggleSnackbar: toggle('displaySnackbar')
}
