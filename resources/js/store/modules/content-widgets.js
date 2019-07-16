import axios from 'axios'
import Cookies from 'js-cookie'
import _ from 'lodash'
import * as types from '../mutation-types'

// state
export const state = {
  selected: null,
  widgetsTypes: null,
  widgetsTypesObject: null,

  selectedCopyCode: null
}

// getters
export const getters = {
  selected: state => state.selected,
  widgetsTypes: state => state.widgetsTypes,
  widgetsTypesObject: state => state.widgetsTypesObject,

  selectedCopyCode: state => state.selectedCopyCode,
}

// mutations
export const mutations = {
  [types.SET_SELECT_POSITION] (state, payload) {
    state.selected = payload
  },

  [types.SET_WIDGETS_TYPES] (state, payload) {
    state.widgetsTypes = payload
    state.widgetsTypesObject = _.keyBy(payload, 'slug');
  },

  [types.SET_SELECT_COPY_CODE] (state, payload) {
    state.selectedCopyCode = payload
  }
}

// actions
export const actions = {
  setSelectPosition ({ commit, dispatch }, payload) {
    commit(types.SET_SELECT_POSITION, payload)
  },

  setWidgetsTypes ({ commit, dispatch }, payload) {
    commit(types.SET_WIDGETS_TYPES, payload)
  },

  setSelectCopyCode ({ commit, dispatch }, payload) {
    commit(types.SET_SELECT_COPY_CODE, payload)
  }
}
