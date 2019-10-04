import Vue from 'vue'

import { library } from '@fortawesome/fontawesome-svg-core'
import {
  faEdit, faTrashAlt, faSave, faPlusSquare, faMinusSquare, faWindowClose, faClone, faCopy as farCopy, faCaretSquareDown
} from '@fortawesome/free-regular-svg-icons'
import {
  faUser, faLock, faSignOutAlt, faCog, faChartArea, faAngleRight, faBars, faTachometerAlt, faUserPlus, faCalendarAlt, faUserTie, faFileContract, faBoxes,
  faListAlt, faPlus, faCaretDown, faCopy, faFolder, faTag, faChevronRight, faExpand, faTimes, faExclamationTriangle, faFileAlt,
  faDownload, faLink, faGraduationCap, faFileArchive, faGlobe, faEye
} from '@fortawesome/free-solid-svg-icons'

import {
  faGithub, faWordpress, faVuejs, faLaravel, faNpm
} from '@fortawesome/free-brands-svg-icons'

//import * as regular from '@fortawesome/free-regular-svg-icons'

import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

library.add(
  faEdit, faTrashAlt, faSave, faPlusSquare, faMinusSquare, faWindowClose, faClone, farCopy, faCaretSquareDown,

  faUser, faLock, faSignOutAlt, faCog, faChartArea, faAngleRight, faBars, faTachometerAlt, faUserPlus, faCalendarAlt, faUserTie, faFileContract, faBoxes,
  faListAlt, faPlus, faCaretDown, faCopy, faFolder, faTag, faChevronRight, faExpand, faTimes, faExclamationTriangle, faFileAlt,
  faDownload, faLink, faGraduationCap, faFileArchive, faGlobe, faEye,

  faGithub, faWordpress, faVuejs, faLaravel, faNpm
)

Vue.component('fa', FontAwesomeIcon)
