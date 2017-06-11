import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);
const routes = require('./routes.js');

export function createRouter(){
	return new VueRouter({
		mode: 'history',
		routes
	});
}
