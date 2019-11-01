import axios from 'axios'
import Cookies from 'js-cookie'
import * as types from '../mutation-types'

// state
export const state = {
  menuCollapsed: String(Cookies.get('interface.menu.collapsed')) === 'true',
  priorityCopyTypeCode: Cookies.getJSON('interface.priorityCopyTypeCode') || {},
  hashGroups: {},
  navHashes: [],
  //todo лучше сохранять на долго потому что пользователь может работать с несколькими технологиями но куки маленькие может локал сторадж
  filterPlugins: {},
  cardsOrListPlugins: 'cards',
  curListCategory: null,
}

// getters
export const getters = {
  menuCollapsed: (state) => {return state.menuCollapsed},
  priorityCopyTypeCode: (state) => {return state.priorityCopyTypeCode},
  hashGroups: (state) => {return state.hashGroups},
  navHashes: (state) => {return state.navHashes},

  filterPlugins: (state) => {return state.filterPlugins},
  cardsOrListPlugins: (state) => {return state.cardsOrListPlugins},
  curListCategory: (state) => {return state.curListCategory},
}

// mutations
export const mutations = {
  [types.SET_MENU_COLLAPSED] (state, collapsed) {
    state.menuCollapsed = collapsed
    Cookies.set('interface.menu.collapsed', collapsed, { expires: 7 })
  },

  [types.SET_PRIORITY_COPY_TYPE_CODE_STATE] (state, payload) {
    state.priorityCopyTypeCode = payload
    Cookies.set('interface.priorityCopyTypeCode', payload, { expires: 7 })
  },

  [types.SET_HASH_GROUPS] (state, payload) {
    state.hashGroups = payload
  },

  [types.SET_NAV_HASHES] (state, payload) {
    state.navHashes = payload
  },

  [types.SET_FILTER_PLUGINS] (state, filterPlugins) {
    state.filterPlugins = filterPlugins;
  },

  [types.SET_CARDS_OR_LIST_PLUGINS] (state, cardsOrListPlugins) {
    state.cardsOrListPlugins = cardsOrListPlugins;
  },

  [types.SET_CUR_LIST_CATEGORY_PLUGINS] (state, curListCategory) {
    state.curListCategory = curListCategory;
  },
}

// actions
export const actions = {
  saveMenuCollapsed ({ commit, dispatch }, payload) {
    commit(types.SET_MENU_COLLAPSED, payload)
  },

  savePriorityCopyTypeCode ({ commit, dispatch }, payload) {
    commit(types.SET_PRIORITY_COPY_TYPE_CODE_STATE, payload)
  },

  setHashGroups ({ commit, dispatch }, payload) {
    commit(types.SET_HASH_GROUPS, payload)
  },

  setNavHashes ({ commit, dispatch }, payload) {
    commit(types.SET_NAV_HASHES, payload)
  },

  saveFilterPlugins ({ commit, dispatch }, payload) {
    commit(types.SET_FILTER_PLUGINS, payload)
  },

  saveCardsOrListPlugins ({ commit, dispatch }, payload) {
    commit(types.SET_CARDS_OR_LIST_PLUGINS, payload)
  },

  saveCurListCategory ({ commit, dispatch }, payload) {
    commit(types.SET_CUR_LIST_CATEGORY_PLUGINS, payload)
  },
}
