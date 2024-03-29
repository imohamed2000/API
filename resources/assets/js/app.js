import Vue from 'vue';
import { createRouter } from './router';
import store from './store';
import supportStorage from './storage';

let router = createRouter();
/**
 * Required component
 */
Vue.component('app', require('./components/App') );

/**
 * Sets page title [A translated page title]
 */
function setTitle(app, documentTitle, pageTitle){
	document.title = app.$t("Odigita LMS ") + " | " + app.$t(documentTitle);
	app.$store.commit("setPageTitle", app.$t( pageTitle) );
}
/**
 * Changes the loading state
 */
function loadingState(app){
	app.$store.commit('isLoading', true);
}

// Vue script2
Vue.use(require('vue-script2'));
window.setTitle = function(app, documentTitle, pageTitle){
	setTitle(app, documentTitle, pageTitle);
};

const app = new Vue({
	el: '#app',
	router,
	store,
	created: function(){
		let title = this.$route.meta.title;
		let pageTitle = this.$route.meta.pageTitle;
		if(title !== undefined && pageTitle !== undefined){
			setTitle(this, title, pageTitle);
		}else{
			setTitle(this, 'Home', 'Home');
		}
		loadingState(this);
	}
});
window.app = app;

router.beforeEach((to, from, next)=>{
	let title = to.meta.title;
	let pageTitle = to.meta.pageTitle;
	if( ('title' in to.meta) ){
		setTitle(app, title, pageTitle);
	}
	loadingState(app);
	next();
});
