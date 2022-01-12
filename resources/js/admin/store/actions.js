// https://vuex.vuejs.org/en/actions.html
import authApi from '@/api/auth'
import {localStorage} from '@/services/storage'
import profile from '@/api/profile'

const removeAuthDataFromLocalStorage = () => {
    localStorage.removeItem('token')
    localStorage.removeItem('user')
}

export default {
    async login({commit}, userData) {
        return new Promise((resolve, reject) => {
            commit('auth_request')
            authApi.login({email: userData.email, password: userData.password})
                .then(response => {
                    const {data} = response

                    if (data.access_token) {
                        const token = `${data.token_type} ${data.access_token}`
                        const user = data.user
                        localStorage.setItem('token', token)
                        commit('auth_success', {token})
                        commit('set_auth_profile', user)
                        resolve(data)
                    } else {
                        reject('something_went_wrong')
                    }

                })
                .catch(({data}) => {
                    commit('auth_error')
                    removeAuthDataFromLocalStorage()
                    reject(data)
                })
        })
    },

    logout({commit}) {
        return new Promise((resolve, reject) => {
            authApi.logout()
                .then(() => {
                    commit('logout')
                    removeAuthDataFromLocalStorage()
                    resolve(true)
                })
                .catch(({data}) => reject(data))
        })
    },

    refreshToken({commit}) {
        return new Promise((resolve, reject) => {
            authApi.refresh()
                .then(response => {
                    const {data} = response
                    const token = data.access_token
                    localStorage.setItem('token', 'Bearer ' + token)
                    commit('auth_success', {token})
                    resolve(true)
                })
                .catch(({data}) => {
                    commit('logout')
                    removeAuthDataFromLocalStorage()
                    reject(data)
                })
        })
    },

    saveProfile({commit}, payload) {
        return new Promise((resolve, reject) => {
            profile.saveProfile(payload)
                .then(({data}) => {
                    commit('set_auth_profile', data.user)
                    resolve(data.user)
                })
                .catch(({data}) => reject(data))
        })
    }
}
