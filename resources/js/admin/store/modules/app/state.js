const initialState = () => ({
  drawer: null,
  color: localStorage.getItem('color') ? localStorage.getItem('color') : 'accent',
  image: '', // change if you want a picture but if you are using this internally get rid of the picture links here and in filter.vue
  isDark: localStorage.getItem('isDark') === 'true' || localStorage.getItem('isDark') === true, // Light || Dark,
  locale: localStorage.getItem('locale') ? localStorage.getItem('locale') : 'en',
  countries: [],
  snackbarMessage: null,
  displaySnackbar: false
})

export default initialState
