import Vue from 'vue'

import { library } from '@fortawesome/fontawesome-svg-core'
import {
  faUser, faLock, faSignOutAlt, faCog, faChartArea, faAngleRight, faBars, faTachometerAlt
} from '@fortawesome/free-solid-svg-icons'

import {
  faGithub
} from '@fortawesome/free-brands-svg-icons'

//import * as regular from '@fortawesome/free-regular-svg-icons'

import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

library.add(
  faUser, faLock, faSignOutAlt, faCog, faChartArea, faAngleRight, faBars, faTachometerAlt,
  faGithub
)

Vue.component('fa', FontAwesomeIcon)
