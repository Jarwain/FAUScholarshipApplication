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
			qualifications: {},
		},
		applications: {},
	},
	getters: {
	},
	mutations: {
		setApplication(state, applications) {
			state.applications = applications;
		},
		setStudent(state, student) {
			state.student = student;
		},
		toggleSelectedScholarship(state, code) {
			const sch = state.selected_scholarships.indexOf(code);
			if (sch === -1) {
				state.selected_scholarships.push(code);
				state.applications[code] = {};
			} else {
				state.selected_scholarships.splice(sch, 1);
				delete state.applications[code];
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
