import Vue from 'vue'

import { library } from '@fortawesome/fontawesome-svg-core'
import {
  faEdit, faTrashAlt, faSave, faPlusSquare, faMinusSquare
} from '@fortawesome/free-regular-svg-icons'
import {
  faUser, faLock, faSignOutAlt, faCog, faChartArea, faAngleRight, faBars, faTachometerAlt, faUserPlus, faCalendarAlt, faUserTie, faFileContract,
  faListAlt, faPlus, faCaretDown, faCopy, faFolder, faTag
} from '@fortawesome/free-solid-svg-icons'

import {
  faGithub
} from '@fortawesome/free-brands-svg-icons'

//import * as regular from '@fortawesome/free-regular-svg-icons'

import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

library.add(
  faEdit, faTrashAlt, faSave, faPlusSquare, faMinusSquare,
  faUser, faLock, faSignOutAlt, faCog, faChartArea, faAngleRight, faBars, faTachometerAlt, faUserPlus, faCalendarAlt, faUserTie, faFileContract,
  faListAlt, faPlus, faCaretDown, faCopy, faFolder, faTag,
  faGithub
)

Vue.component('fa', FontAwesomeIcon)
