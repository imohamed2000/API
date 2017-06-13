import Vue from 'vue';
import { createRouter } from './router';
import store from './store';



/**
 * Required component
 */
Vue.component('example', require('./components/Example') );
Vue.component('docs', require('./components/Documentation') );


const app = new Vue({
	el: '#app',
	router: createRouter(),
	store,
});
