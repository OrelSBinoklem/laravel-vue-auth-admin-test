import axios from 'axios'
import Cookies from 'js-cookie'
import * as types from '../mutation-types'

// state
export const state = {
  adminMaterials: null,
  clientMenus: {}
}

// getters
export const getters = {
  adminMaterials: (state) => {return state.adminMaterials},
  menuClientBySlug: (state) => (slug) => {return slug in state.clientMenus ? state.clientMenus[slug] : null}
}

// mutations
export const mutations = {
  [types.SET_MENU_ADMIN_MATERIALS] (state, payload ) {
    state.adminMaterials = payload
  },

  [types.SET_MENU_CLIENT] (state, payload ) {
    state.clientMenus[payload.slug] = payload.menu
  }
}

// actions
export const actions = {
  setAdminMaterials ({ commit, dispatch }, payload) {
    commit(types.SET_MENU_ADMIN_MATERIALS, payload)
  },

  setMenuClient ({ commit, dispatch }, payload) {
    commit(types.SET_MENU_CLIENT, payload)
  }
}
