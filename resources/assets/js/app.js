import Vue from 'vue';
import { createRouter } from './router';

/**
 * Required component
 */
Vue.component('example', require('./components/Example') );
Vue.component('docs', require('./components/Documentation') );


const app = new Vue({
	el: '#app',
	router: createRouter(),
});
