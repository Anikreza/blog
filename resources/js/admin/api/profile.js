import HttpClient from './index'

class ProfileApi extends HttpClient {
  getCountryList () {
    return this.requestType('get').request(`/get-country-list`)
  }

  saveProfile (payload) {
    return this.requestType('post').formBody(payload).isMultimedia().request(`/auth/save-profile`)
  }
}

const profileApi = new ProfileApi()
export default profileApi
