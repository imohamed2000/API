import * as types from '../mutation-types'
import Cookie from 'js-cookie';
// initial state

const state = {
	 isGuest : typeof( Cookie.get('isGuest') ) == "undefined",
}

// getters
const getters = {
 
}

// actions
const actions = {
 	toAuth({commit}){
 		commit('toAuth');
 	},
 	toGuest({commit}){
 		commit('toGuest');
 	}
}

// mutations
const mutations = {
  toAuth(state){
  	state.isGuest = false;
  },
  toGuest(state){
    Cookie.remove('isGuest');
  	state.isGuest = true;
  }
}

export default {
  state,
  getters,
  actions,
  mutations
}