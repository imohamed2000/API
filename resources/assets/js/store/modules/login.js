import * as types from '../mutation-types'
import Cookie from 'js-cookie';
import axios from 'axios';
// initial state

const state = {
	 isGuest : typeof( Cookie.get('isGuest') ) == "undefined",
   user: {}
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
 	},
  logout({commit}){
    commit('logout');
  },
  getUserData({commit}){
    commit('getUserData');
  }
}

// mutations
const mutations = {
  toAuth(state){
  	state.isGuest = false;
  },
  logout(state){
    axios.post("/api/v1/logout")
      .then(response=>{
          mutations.toGuest(state);
        })
      .catch(error=> {
        console.log(error.response.data)
      });
    
  },
  toGuest(state){
    Cookie.remove('isGuest');
    state.isGuest = true;
  },
  getUserData(state){
    let userData = {};
    axios.get("https://baconipsum.com/api/?type=all-meat&sentences=1&start-with-lorem=1")
      .then(response => {

        let userName = response.data[0].split(" ").filter((v, i)=>{
          return i < 2;
        }).join(" ");

        userData.first_name = userName;
        userData.avatar= "/layouts/layout5/img/avatar1.jpg";
        state.user = userData;

      });
  }
}

export default {
  state,
  getters,
  actions,
  mutations
}
