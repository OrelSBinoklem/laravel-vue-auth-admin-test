import axios from 'axios'
import Cookies from 'js-cookie'
import * as types from '../mutation-types'

// state
export const state = {
  menuCollapsed: String(Cookies.get('interface.menu.collapsed')) === 'true',
  contentPluginsSidebarMegamenu: Cookies.getJSON('interface.content.plugins.sidebar_megamenu.state') || {},
}

// getters
export const getters = {
  menuCollapsed: (state) => {return state.menuCollapsed},
  contentPluginsSidebarMegamenu: (state) => {return state.contentPluginsSidebarMegamenu}
}

// mutations
export const mutations = {
  [types.SET_MENU_COLLAPSED] (state, collapsed ) {
    state.menuCollapsed = collapsed
    Cookies.set('interface.menu.collapsed', collapsed, { expires: 365 })
  },

  [types.SET_PLUGINS_SIDEBAR_MEGAMENU_STATE] (state, payload ) {
    state.contentPluginsSidebarMegamenu = payload
    Cookies.set('interface.content.plugins.sidebar_megamenu.state', payload, { expires: 365 })
  }
}

// actions
export const actions = {
  saveMenuCollapsed ({ commit, dispatch }, payload) {
    commit(types.SET_MENU_COLLAPSED, payload)
  },

  saveContentPluginsSidebarMegamenu ({ commit, dispatch }, payload) {
    commit(types.SET_PLUGINS_SIDEBAR_MEGAMENU_STATE, payload)
  }
}
