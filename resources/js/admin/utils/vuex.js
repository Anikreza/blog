// *******************************************************************
// Getters
// *******************************************************************
// Find an object in a list of objects by matching a property value.
// userById: findByKey('users', 'id')
// getters.userById('123')
export function findByKey (prop, targetKey) {
  return state => val => state[prop].find(x => x[targetKey] === val)
}

// Filter a list of objects by matching a property value.
// usersByStatus: filterByKey('users', 'status')
// getters.usersByStatus('INACTIVE')
export function filterByKey (prop, targetKey) {
  return state => values => {
    if (!Array.isArray(values)) values = [values]
    return state[prop].filter(x => values.indexOf(x[targetKey]) > -1)
  }
}

export function mapKeys (prop, targetKey) {
  const filter = filterByKey(prop, targetKey)
  return state => values => filter(state)(values)
    .sort((a, b) => values.indexOf(a[targetKey]) - values.indexOf(b[targetKey]))
}

// *******************************************************************
// Mutators
// *******************************************************************
export const set = property => (state, payload) => (state[property] = payload)

export const toggle = property => state => (state[property] = !state[property])

// Set a value at a path within state
// Create objects and arrays as needed
// Path is an array, and array indicies are numbers (not string numbers)
// setUserName: setPath(['user', 'name'])
// commit('setUserName', 'foo')
export const setPath = path => (state, val) => {
  const obj = path.slice(0, -1).reduce((acc, x, i) => {
    if (!(x in acc)) acc[x] = typeof path[i + 1] === 'number' ? [] : {}
    return acc[x]
  }, state)
  obj[last(path)] = val
}

// For all key/value in propMap, set state[key] = data[propMap[value]]
export const pick = propMap => (state, data) => {
  data = data || {}
  Object.keys(propMap).forEach(x => { state[x] = data[propMap[x]] })
}

// push an item onto a list
// addItem: pushTo('items')
export const pushTo = key => (state, val) => state[key].push(val)

// copy all key/values from data to state
// useful for resetting state to default values
// resetState: assignConstant(initialState)
// commit('resetState')
export const assignConstant = data => state => Object.assign(state, data)

// remove item from list
export const omitFromList = key => (state, item) => {
  const index = state[key].indexOf(item)
  if (index > -1) state[key].splice(index, 1)
}

// increment the index of a list argument or a list in state
export const incrementListIndex = (key, listOrListProp) => state => {
  const list = Array.isArray(listOrListProp) ? listOrListProp : state[listOrListProp]
  state[key] = (state[key] + 1) % list.length
}

// add or extend a record in a list
export const extendRecordInList = (key, idKey = 'id', valKey) => (state, data) => {
  const id = data[idKey]
  const val = valKey ? data[valKey] : data
  const index = state[key].findIndex(x => x[idKey] === id)
  return index < 0
    ? state[key].push(val)
    : state[key].splice(index, 1, Object.assign({}, state[key][index], val))
}

// add or replace a record in a list
export const replaceRecordInList = (key, idKey = 'id', valKey) => (state, data) => {
  const id = data[idKey]
  const val = valKey ? data[valKey] : data
  const index = state[key].findIndex(x => x[idKey] === id)
  return index < 0
    ? state[key].push(val)
    : state[key].splice(index, 1, val)
}
