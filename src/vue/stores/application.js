import Vue from 'vue';
import Vuex from 'vuex';
import api from '@/api';
import qualifiers from '@/stores/modules/qualifiers';
import scholarships from '@/stores/modules/scholarships';

Vue.use(Vuex);

const studentConstraints = {
	first_name: {
		presence: {
			allowEmpty: false,
		},
	},
	last_name: {
		presence: {
			allowEmpty: false,
		},
	},
	znumber: {
		presence: {
			allowEmpty: false,
		},
		length: {
			is: 8,
		},
		numericality: true,
	},
	email: {
		presence: {
			allowEmpty: false,
		},
		email: true,
		format: {
			pattern: /.*fau\.edu$/,
			message: 'should be your fau.edu address',
		},
	},
};

const store = new Vuex.Store({
	modules: {
		qualifiers,
		scholarships,
	},
	state: {
		selected_scholarships: [],
		student: {
			first_name: null,
			last_name: null,
			znumber: null,
			email: null,
			videoAuth: null,
		},
		qualifications: {},
		answers: {},
		submit: false,
		result: false,
		studentConstraints,
	},
	getters: {
	},
	mutations: {
		setSubmit(state, submit) {
			state.submit = submit;
		},
		setResult(state, result) {
			state.result = result;
		},
		setAnswers(state, answers) {
			state.answers = answers;
		},
		setStudent(state, student) {
			state.student = student;
		},
		setQualifications(state, qualifications) {
			state.qualifications = qualifications;
		},
		toggleSelectedScholarship(state, code) {
			const sch = state.selected_scholarships.indexOf(code);
			if (sch === -1) {
				state.selected_scholarships.push(code);
				Vue.set(state.answers, code, {});
			} else {
				state.selected_scholarships.splice(sch, 1);
				delete state.answers[code];
			}
		},
	},
	actions: {
		// _.debounce is a lodash function
		// It prevents an action from firing "too much"
		// Sprinkle it anywhere that has a lot of (asynchronous?) calls
		updateStudent: (context, item) => {
			context.commit('setStudent', item);
		},
		updateAnswers(context, item) {
			context.commit('setAnswers', item);
		},
		updateQualifications(context, item) {
			context.commit('setQualifications', item);
		},
		submitAnswers({ commit, state }) {
			commit('setSubmit', true);
			const student = { ...state.student };
			student.znumber = `Z${student.znumber}`;
			student.qualifications = state.qualifications;
			const answers = {
				student,
				answers: state.answers,
			};
			api.submitAnswers(answers).then((response) => {
				console.log(response.data);
				commit('setResult', response.data);
			}).catch((response) => {
				console.log(response);
			});
		},
	},
});

export default store;
