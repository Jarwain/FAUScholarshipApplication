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
		selected_scholarships: [],
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
		toggleSelectedScholarship(state, code) {
			const sch = state.selected_scholarships.indexOf(code);
			if (sch === -1) {
				state.selected_scholarships.push(code);
			} else {
				state.selected_scholarships.splice(sch, 1);
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
