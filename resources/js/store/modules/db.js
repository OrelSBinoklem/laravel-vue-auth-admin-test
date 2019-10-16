import axios from 'axios'
import Cookies from 'js-cookie'
import * as types from '../mutation-types'

// state
export const state = {
  categories: null,
  categoriesPublic: null,
  categoriesPublicTree: null
}

// getters
export const getters = {
  categories: state => state.categories,
  categoriesPublic: state => state.categoriesPublic,
  categoriesPublicTree: state => (slug = null) => {
    if(!!slug) {
      let partRootCat = _.find(state.categoriesPublic, {slug});
      return !!partRootCat && !!partRootCat.children && !!partRootCat.children.length ? partRootCat.children : null;
    } else {
      return state.categoriesPublic;
    }
  }
}

// mutations
export const mutations = {
  [types.REFRESH_CATEGORIES] (state, payload) {
    state.categories = payload
  },

  [types.REFRESH_CATEGORIES_PUBLIC] (state, payload) {
    state.categoriesPublic = payload
  },

  [types.REFRESH_CATEGORIES_PUBLIC_TREE] (state, payload) {
    state.categoriesPublicTree = payload
  },
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
  },

  async loadCategoriesPublic ({ commit, state }) {
    if(state.categoriesPublic === null) {
      let response = await axios.get('/api/categories');
      commit(types.REFRESH_CATEGORIES_PUBLIC, response.data);
      commit(types.REFRESH_CATEGORIES_PUBLIC_TREE, appHelper.flatToTree(response.data));
    }
  },

  async refreshCategoriesPublic ({ commit }, payload) {
    let response = await axios.get('/api/categories')
    commit(types.REFRESH_CATEGORIES_PUBLIC, response.data);
    commit(types.REFRESH_CATEGORIES_PUBLIC_TREE, appHelper.flatToTree(response.data));
  }
}
