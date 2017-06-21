import * as types from '../mutation-types'

// initial state

const state = {
	pageTitle: ''
}

// getters
const getters = {
  
}

// actions
const actions = {
 	setPageTitle: ({commit}, newTitle) =>{
 		commit('setPageTitle', newTitle);
 	}
}

// mutations
const mutations = {
  setPageTitle: (state, newTitle)=>{
  	state.pageTitle = newTitle;
  }
}

export default {
  state,
  getters,
  actions,
  mutations
}