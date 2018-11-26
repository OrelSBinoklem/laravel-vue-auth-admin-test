import axios from 'axios'
import Cookies from 'js-cookie'
import * as types from '../mutation-types'

// state
export const state = {
  menuCollapsed: String(Cookies.get('interface.menu.collapsed')) === 'true',
}

// getters
export const getters = {
  menuCollapsed: (state) => {
    return state.menuCollapsed}
}

// mutations
export const mutations = {
  [types.SET_MENU_COLLAPSED] (state, collapsed ) {
    state.menuCollapsed = collapsed
    Cookies.set('interface.menu.collapsed', collapsed, { expires: 365 })
  }
}

// actions
export const actions = {
  saveMenuCollapsed ({ commit, dispatch }, payload) {
    commit(types.SET_MENU_COLLAPSED, payload)
  }
}
