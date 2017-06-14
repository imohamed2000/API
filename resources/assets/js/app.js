import Vue from 'vue';
import { createRouter } from './router';
import store from './store';



/**
 * Required component
 */
Vue.component('login', require('./components/Login') );

const app = new Vue({
	el: '#app',
	router: createRouter(),
	store,
});
