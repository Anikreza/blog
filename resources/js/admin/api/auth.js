import HttpClient from './index'

class AuthApi extends HttpClient {
    async login(payload) {

        return this.requestType('post')
            .formBody(payload)
            .request(`/auth/login`)

    }

    async logout() {
        return this.requestType('post').request(`/auth/logout`)
    }

    async refresh() {
        return this.requestType('post').request(`/auth/refresh`)
    }
}

const authApi = new AuthApi()
export default authApi
