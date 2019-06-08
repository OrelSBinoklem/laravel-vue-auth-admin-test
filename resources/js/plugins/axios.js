import Vue from 'vue'
import axios from 'axios'
import store from '~/store'
import router from '~/router'
import swal from 'sweetalert2'
import i18n from '~/plugins/i18n'

// Request interceptor
axios.interceptors.request.use(request => {
  const token = store.getters['auth/token']
  if (token) {
    request.headers.common['Authorization'] = `Bearer ${token}`
  }

  const locale = store.getters['lang/locale']
  if (locale) {
    request.headers.common['Accept-Language'] = locale
  }

  // request.headers['X-Socket-Id'] = Echo.socketId()

  return request
})

// Response interceptor
let $eventBus = new Vue();
Vue.prototype.$eventHub = $eventBus;

Vue.component('notifications', {
  template: '<div><vue-snotify></vue-snotify></div>',
  created() {
    this.$eventHub.$on('open-modal', ({
      type,
      title,
      message
    }) => {
      const conf = {
        timeout: 5000,
        showProgressBar: true,
        closeOnClick: true,
        pauseOnHover: true
      }
      if(!type) {
        throw new Error("Not given type")
      }

      if(!/^(simple|success|info|warning|error)$/gi.test(type)) {
        throw new Error("Supported types \"simple, success, info, warning, error\" given:" + type)
      }

      if(title) {
        this.$snotify[type](message, title, conf);
      } else {
        this.$snotify[type](message, conf);
      }
    });
  },
  beforeDestroy() {
    this.$eventHub.$off('open-modal');
  },
});
axios.interceptors.response.use(response => {
  if(/^\/admin\/?/gi.test(router.currentRoute.fullPath)) {
    if(response.data.notification) {
      $eventBus.$emit('open-modal', {
        type: response.data.notification.type ? response.data.notification.type : 'success',
        title: response.data.notification.title ? response.data.notification.title : null,
        message: response.data.notification.message
      });
    }

    if(response.data.status) {
      $eventBus.$emit('open-modal', {
        type: 'success',
        title: null,
        message: response.data.status
      });
    }

    if(response.data.error) {
      $eventBus.$emit('open-modal', {
        type: 'error',
        title: null,
        message: response.data.error
      });
    }
  }

  return response
}, error => {
  const { status } = error.response

  if (status >= 500) {
    swal({
      type: 'error',
      title: i18n.t('error_alert_title'),
      text: i18n.t('error_alert_text'),
      reverseButtons: true,
      confirmButtonText: i18n.t('ok'),
      cancelButtonText: i18n.t('cancel')
    })
  } else if (status === 401 && store.gtters['auth/check']) {
    swal({
      type: 'warning',
      title: i18n.t('token_expired_alert_title'),
      text: i18n.t('token_expired_alert_text'),
      reverseButtons: true,
      confirmButtonText: i18n.t('ok'),
      cancelButtonText: i18n.t('cancel')
    }).then(() => {
      store.commit('auth/LOGOUT')

      router.push({ name: 'login' })
    })
  } else {
    $eventBus.$emit('open-modal', {
      type: 'error',
      title: null,
      message: error.response.data.message
    });
  }

  return Promise.reject(error)
})
