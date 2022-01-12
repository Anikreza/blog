import Vue from 'vue'

Vue.config.errorHandler = (err, vm, info) => {
  console.log(`Error: ${err}`)
  console.log('VM: ', vm)
  console.log('Info: ', info)
}

window.onerror = function (message, source, lineno, colno, error) {
  console.log(message, source, lineno, colno, error)
}
