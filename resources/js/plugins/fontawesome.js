import Vue from 'vue'

import { library } from '@fortawesome/fontawesome-svg-core'
import {
  faEdit, faTrashAlt, faSave
} from '@fortawesome/free-regular-svg-icons'
import {
  faUser, faLock, faSignOutAlt, faCog, faChartArea, faAngleRight, faBars, faTachometerAlt, faUserPlus, faCalendarAlt, faUserTie, faFileContract,
  faListAlt, faPlus, faCaretDown
} from '@fortawesome/free-solid-svg-icons'

import {
  faGithub
} from '@fortawesome/free-brands-svg-icons'

//import * as regular from '@fortawesome/free-regular-svg-icons'

import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

library.add(
  faEdit, faTrashAlt, faSave,
  faUser, faLock, faSignOutAlt, faCog, faChartArea, faAngleRight, faBars, faTachometerAlt, faUserPlus, faCalendarAlt, faUserTie, faFileContract,
  faListAlt, faPlus, faCaretDown,
  faGithub
)

Vue.component('fa', FontAwesomeIcon)
