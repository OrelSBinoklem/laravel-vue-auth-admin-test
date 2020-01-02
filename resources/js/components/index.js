import Vue from 'vue'
import Card from './Card'
import Child from './Child'
import Button from './Button'
import Checkbox from './Checkbox'
import { HasError, AlertError, AlertSuccess } from 'vform'

import AdminPosition from './content-widgets/AdminPosition'
import AdminWidget from './content-widgets/AdminWidget'
import BsSidebarMenuNestedDropSubItem from './bs-sidebar-menu-nested-drop/SubItem'
import TableMenuSubItem from './table-menu/TableMenuSubItem'

// Components that are registered globaly.
[
  Card,
  Child,
  Button,
  Checkbox,
  HasError,
  AlertError,
  AlertSuccess,
  AdminPosition,
  AdminWidget,
  BsSidebarMenuNestedDropSubItem,
  TableMenuSubItem
].forEach(Component => {
  Vue.component(Component.name, Component)
})
