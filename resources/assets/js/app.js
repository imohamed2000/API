import Vue from 'vue';
import { createRouter } from './router';
import store from './store';
import supportStorage from './storage';

let router = createRouter();

/**
 * Required component
 */
Vue.component('app', require('./components/App') );

const app = new Vue({
	el: '#app',
	router,
	store,
	created: function(){
		let title = this.$route.meta.title;
		document.title = this.$t("Odigita LMS ") + " | " + this.$t(title) ;
	}
});

router.beforeEach((to, from, next)=>{
	let title = to.meta.title;
	document.title = app.$t("Odigita LMS ") + " | " + app.$t(title) ;
	next();
});