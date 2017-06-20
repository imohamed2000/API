import * as types from '../mutation-types'
import Cookie from 'js-cookie';
import axios from 'axios';
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
    axios.post("/api/v1/logout")
      .then(response=>{
          Cookie.remove('isGuest');
          state.isGuest = true;
        })
      .catch(error=> {
        console.log(error.response.data)
      });
    
  }
}

export default {
  state,
  getters,
  actions,
  mutations
}