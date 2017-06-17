import Vue from 'vue';
import { createRouter } from './router';
import store from './store';
import supportStorage from './storage';


/**
 * Required component
 */
Vue.component('app', require('./components/App') );

const app = new Vue({
	el: '#app',
	router: createRouter(),
	store
});
