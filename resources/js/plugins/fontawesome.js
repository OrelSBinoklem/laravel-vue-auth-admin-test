import Vue from 'vue'

import { library } from '@fortawesome/fontawesome-svg-core'
import {
  faEdit, faTrashAlt, faSave, faPlusSquare, faMinusSquare, faWindowClose, faClone, faCopy as farCopy
} from '@fortawesome/free-regular-svg-icons'
import {
  faUser, faLock, faSignOutAlt, faCog, faChartArea, faAngleRight, faBars, faTachometerAlt, faUserPlus, faCalendarAlt, faUserTie, faFileContract,
  faListAlt, faPlus, faCaretDown, faCopy, faFolder, faTag, faChevronRight, faExpand, faTimes, faExclamationTriangle
} from '@fortawesome/free-solid-svg-icons'

import {
  faGithub, faWordpress, faVuejs, faLaravel
} from '@fortawesome/free-brands-svg-icons'

//import * as regular from '@fortawesome/free-regular-svg-icons'

import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

library.add(
  faEdit, faTrashAlt, faSave, faPlusSquare, faMinusSquare, faWindowClose, faClone, farCopy,

  faUser, faLock, faSignOutAlt, faCog, faChartArea, faAngleRight, faBars, faTachometerAlt, faUserPlus, faCalendarAlt, faUserTie, faFileContract,
  faListAlt, faPlus, faCaretDown, faCopy, faFolder, faTag, faChevronRight, faExpand, faTimes, faExclamationTriangle,

  faGithub, faWordpress, faVuejs, faLaravel
)

Vue.component('fa', FontAwesomeIcon)
