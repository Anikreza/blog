import profileApi from '@/api/profile'

export default {
  getCountryList ({ commit, state }) {
    return new Promise(async (resolve, reject) => {
      if (state.countries.length) {
        resolve(state.countries)
      } else {
        let response = await profileApi.getCountryList(`/get-country-list`)
          .catch(error => reject(error))

        if (response.status === 200) {
          const countries = response.data.data.countries
          commit('setCountryList', countries)
          resolve(response.data.data.countries)
        } else {
          reject(`request status: ${response.status}`)
        }
      }
    })
  },
  setColor ({ commit }, payload) {
    commit('setColor', payload)
    localStorage.setItem('color', payload)
  },
  setIfDark ({ commit }, payload) {
    commit('setIfDark', payload)
    localStorage.setItem('isDark', payload)
  },
  setLocale ({ commit }, payload) {
    commit('setLocale', payload)
    localStorage.setItem('locale', payload)
  },
  setSnackbarMessage ({ commit }, payload) {
    commit('setSnackbarMessage', payload)
    commit('toggleSnackbar')
  },
  closeSnackbar ({ commit }) {
    commit('toggleSnackbar')
    commit('setSnackbarMessage', null)
  }
}
