// Lib imports
import axios from 'resources/js/src/plugins/axios'

// Sets the default url used by all of this axios instance's requests
axios.defaults.baseURL = process.env.VUE_APP_API_URL
axios.defaults.headers.get['Accept'] = 'application/json'

const token = localStorage.getItem('token')
if (token) {
  axios.defaults.headers.common['Authorization'] = JSON.parse(token)
}

axios.defaults.headers.common['Accept-Language'] = localStorage.getItem('locale') || 'en'

export default axios
