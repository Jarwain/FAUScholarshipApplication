import Vue from 'vue';
import Vuex from 'vuex';
import api from '@/api';
import qualifiers from '@/stores/modules/qualifiers';
import scholarships from '@/stores/modules/scholarships';

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
			videoAuth: null,
		},
		applications: {},
		submit: null,
	},
	getters: {
	},
	mutations: {
		setSubmit(state, submit) {
			state.submit = submit;
		},
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
		submitApplication({ commit, state }) {
			const submit = { status: false };
			commit('setSubmit', submit);
		},
	},
});

export default store;
