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
		answers: {},
		submit: null,
	},
	getters: {
	},
	mutations: {
		setSubmit(state, submit) {
			state.submit = submit;
		},
		setAnswers(state, answers) {
			state.answers = answers;
		},
		setStudent(state, student) {
			state.student = student;
		},
		toggleSelectedScholarship(state, code) {
			const sch = state.selected_scholarships.indexOf(code);
			if (sch === -1) {
				state.selected_scholarships.push(code);
				state.answers[code] = {};
			} else {
				state.selected_scholarships.splice(sch, 1);
				delete state.answers[code];
			}
		},
	},
	actions: {
		submitAnswers({ commit, state }) {
			const submit = { status: false };
			commit('setSubmit', submit);
			const answers = {
				student: state.student,
				answers: state.answers,
			};
			api.submitAnswers(answers).then((response) => {
				console.log(response);
			});
		},
	},
});

export default store;
