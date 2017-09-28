import 'bootstrap'
import 'bootstrap/dist/css/bootstrap.min.css'

// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import Notifications from 'vue-notification'
import velocity from 'velocity-animate'
import App from './App'
import router from './router'
import './filters'

Vue.use(Notifications, {velocity})

Vue.config.productionTip = false

/* eslint-disable no-new */
new Vue({
  router,
  template: '<App/>',
  components: { App },
}).$mount('#app')
