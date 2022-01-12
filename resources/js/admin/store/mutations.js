export default {
  auth_request (state) {
    state.authStatus = 'loading'
  },
  auth_success (state, { token }) {
    state.authStatus = 'success'
    state.token = token
  },
  set_auth_profile (state, user) {
    state.user = user
  },
  auth_error (state) {
    state.authStatus = 'error'
  },
  logout (state) {
    state.authStatus = ''
    state.token = ''
    state.user = {}
  },
  setTableList (state, tableList) {
    state.tableList = tableList
  }
}
