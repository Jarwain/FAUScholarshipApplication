import Vue from 'vue';
import Vuex from 'vuex';
import router from '@/routers/admin';
import qualifiers from '@/stores/modules/qualifiers';
import scholarships from '@/stores/modules/scholarships';

Vue.config.productionTip = false;

Vue.use(Vuex);

const store = new Vuex.Store({
	modules: {
		qualifiers,
		scholarships,
	},
	state: {
	},
	getters: {
	},
	mutations: {
	},
	actions: {
	},
});

new Vue({
	router,
	store,
}).$mount('#app');
