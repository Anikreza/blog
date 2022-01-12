import Vue from 'vue'
import Vuex from 'vuex'
import createPersistedState from 'vuex-persistedstate'
// Store functionality
import actions from './actions'
import getters from './getters'
import modules from './modules'
import mutations from './mutations'
import state from './state'

Vue.use(Vuex)

// Create a new store
const store = new Vuex.Store({
  actions,
  getters,
  modules,
  mutations,
  state,
  plugins: [createPersistedState({
    key: process.env.MIX_APP_NAME,
    reducer (val) {
      if(val.token === '') { // return empty state when user logged out
        return {}
      }
      return val
    }
  })],
})

export default store
