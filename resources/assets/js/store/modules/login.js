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
  getUserData({commit}){
    commit('getUserData');
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
