import axios from 'axios'
import Cookies from 'js-cookie'
import * as types from '../mutation-types'

// state
export const state = {
  categories: null
}

// getters
export const getters = {
  categories: state => state.categories,
}

// mutations
export const mutations = {
  [types.REFRESH_CATEGORIES] (state, payload) {
    state.categories = payload
  }
}

// actions
export const actions = {
  async loadCategories ({ commit, state }) {
    if(state.categories === null) {
      let response = await axios.get('/api/admin/categories')
      commit(types.REFRESH_CATEGORIES, response.data)
    }
  },

  async refreshCategories ({ commit }, payload) {
    let response = await axios.get('/api/admin/categories')
    commit(types.REFRESH_CATEGORIES, response.data)
  }
}
