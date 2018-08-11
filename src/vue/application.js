import Vue from 'vue';
import Vuex from 'vuex';
import router from './routers/application';
import qualifiers from './stores/qualifiers';
import scholarships from './stores/scholarships';

Vue.config.productionTip = false;

Vue.use(Vuex);

const store = new Vuex.Store({
	modules: {
		qualifiers,
		scholarships,
	},
	state: {
		selected_scholarships: new Map(),
		student: {
			first_name: '',
			last_name: '',
			znumber: '',
			email: '',
			qualifications: [],
		},
	},
	getters: {
	},
	mutations: {
		/* eslint no-param-reassign: [2, { "props": false }] */
		setStudent(state, student) {
			state.student = student;
		},
		toggleSelectedScholarship(state, scholarship) {
			if (state.selected_scholarships.has(scholarship.code)) {
				state.selected_scholarships.delete(scholarship.code);
			} else {
				state.selected_scholarships.set(scholarship.code, scholarship);
			}
		},
	},
	actions: {
	},
});

new Vue({
	router,
	store,
}).$mount('#app');
