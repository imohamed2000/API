import Vue from 'vue';
import { createRouter } from './router';
import store from './store';
import supportStorage from './storage';

let router = createRouter();

/**
 * Required component
 */
Vue.component('app', require('./components/App') );

function setTitle(app, documentTitle, pageTitle){
	document.title = app.$t("Odigita LMS ") + " | " + app.$t(documentTitle);
	app.$store.commit("setPageTitle", app.$t( pageTitle) );
}

function loadingState(app){
	app.$store.commit('isLoading', true);
}

// Vue script2
Vue.use(require('vue-script2'));

const app = new Vue({
	el: '#app',
	router,
	store,
	created: function(){
		let title = this.$route.meta.title;
		let pageTitle = this.$route.meta.pageTitle;
		setTitle(this, title, pageTitle);
		loadingState(this);
	}
});

router.beforeEach((to, from, next)=>{
	let title = to.meta.title;
	let pageTitle = to.meta.pageTitle;
	setTitle(app, title, pageTitle);
	loadingState(app);
	next();
});
