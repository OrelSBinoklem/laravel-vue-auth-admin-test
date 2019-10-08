import axios from 'axios'
import Cookies from 'js-cookie'
import * as types from '../mutation-types'

// state
export const state = {
  adminMaterials: null,
  clientMenus: {},
  itemsRelatedData: {}
}

// getters
export const getters = {
  adminMaterials: (state) => {return state.adminMaterials},
  menuClientBySlug: (state) => (slug) => {return slug in state.clientMenus ? state.clientMenus[slug] : null},
  itemRelatedData: (state) => (id) => {return id in state.itemsRelatedData ? state.itemsRelatedData[id] : null}
}

// mutations
export const mutations = {
  [types.SET_MENU_ADMIN_MATERIALS] (state, payload ) {
    state.adminMaterials = payload
  },

  [types.SET_MENU_CLIENT] (state, payload ) {
    state.clientMenus[payload.slug] = payload.menu
  },

  [types.SET_ITEMS_RELATED_DATA] (state, payload ) {
    payload.forEach((item) => {
      state.itemsRelatedData[item.id] = item.data
    });
  }
}

// actions
export const actions = {
  setAdminMaterials ({ commit, dispatch }, payload) {
    commit(types.SET_MENU_ADMIN_MATERIALS, payload)
  },

  setMenuClient ({ commit, dispatch }, payload) {
    commit(types.SET_MENU_CLIENT, payload)
  },

  setItemsRelatedData ({ commit, dispatch }, payload) {
    commit(types.SET_ITEMS_RELATED_DATA, payload)
  },
}
