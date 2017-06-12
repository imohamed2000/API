import Vue from 'vue';
import Vuex from 'vuex';
import vuexI18n from 'vuex-i18n';
import * as actions from './actions';
import * as getters from './getters';

// import module from './modules/module';
import example from './modules/example';


Vue.use(Vuex);

// Translations
import translationsEn from './lang/en.js';
import translationsAr from './lang/ar.js';

const store = new Vuex.Store({
  actions,
  getters,
  modules: {
  	example
  }
});

Vue.use(vuexI18n.plugin, store);
Vue.i18n.add('en', translationsEn);
Vue.i18n.add('ar', translationsAr);

Vue.i18n.fallback('en');

export default store;
