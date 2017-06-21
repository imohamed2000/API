import * as types from '../mutation-types'

// initial state

const state = {
	pageTitle: '',
	loading: true
}

// getters
const getters = {
  
}

// actions
const actions = {
 	setPageTitle: ({commit}, newTitle) =>{
 		commit('setPageTitle', newTitle);
 	},
 	isLoading:({ commit }, status) => {
 		commit('isLoading', status);
 	},
}

// mutations
const mutations = {
  setPageTitle: (state, newTitle)=>{
  	state.pageTitle = newTitle;
  },
  isLoading: (state, status) =>{
  	state.loading = status;
  }
}

export default {
  state,
  getters,
  actions,
  mutations
}