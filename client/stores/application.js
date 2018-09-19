import Vue from 'vue';
import Vuex from 'vuex';
import api from '@/api';
import validate from 'validate.js';
import debounce from 'lodash/debounce';
import questions from '@/stores/modules/questions';
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
		numericality: {
			notValid: 'should be a number',
		},
		length: {
			is: 8,
		},
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
		questions,
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
			videoAuth: null,
		},
		search: false,
		qualifications: {},
		answers: {},
		submit: false,
		result: false,
		studentConstraints,
		invalid: {
			student: [],
			qualifications: {},
			answers: {},
		},
	},
	getters: {
	},
	mutations: {
		search(state) {
			state.search = true;
		},
		setInvalid(state, invalid) {
			state.invalid = invalid;
		},
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
				Vue.set(state.invalid.answers, code, {});
			} else {
				state.selected_scholarships.splice(sch, 1);
				Vue.delete(state.answers, code);
				Vue.delete(state.invalid.answers, code);
			}
		},
	},
	actions: {
		updateInvalid: debounce(({
			state: {
				invalid,
				student,
				qualifications,
				answers,
				questions: { all: allQuestions },
				scholarships: { all: allScholarships },
				selected_scholarships: selected,
			},
			getters: {
				'qualifiers/constraints': qualifierConstraints,
			},
			commit,
		}) => {
			// Validate Student
			invalid.student = validate(student, studentConstraints) || false;
			// Validate Qualifiers
			invalid.qualifications = validate(qualifications, qualifierConstraints) || false;
			// Validate Answers
			selected.forEach((code) => {
				allScholarships.get(code).questions.forEach((q) => {
					const question = allQuestions.get(q);
					let answer = answers[code][q];
					// TODO: Add File validator to actually validate files
					if (question.type === 'file' && answer) {
						answer = answer.name;
					}
					const valid = validate.single(answer, question.constraints);
					if (valid) {
						Vue.set(
							invalid.answers[code],
							q,
							validate.single(answer, question.constraints),
						);
					} else {
						Vue.delete(invalid.answers[code], q);
					}
				});
				if (Object.keys(invalid.answers[code]).length === 0) {
					Vue.set(invalid.answers, code, false);
				}
			});
			commit('setInvalid', invalid);
		}, 100, { trailing: true }),
		updateStudent: debounce((context, item) => {
			context.commit('setStudent', item);
			context.dispatch('updateInvalid');
		}, 50, { trailing: true }),
		updateAnswers: debounce((context, item) => {
			context.commit('setAnswers', item);
			context.dispatch('updateInvalid');
		}, 50, { trailing: true }),
		updateQualifications: debounce((context, item) => {
			context.commit('setQualifications', item);
			context.dispatch('updateInvalid');
		}, 50, { trailing: true }),
		submitAnswers({ commit, state }) {
			commit('setSubmit', true);
			const student = { ...state.student };
			student.znumber = `Z${student.znumber}`;
			student.qualifications = state.qualifications;
			if (student.videoAuth === null) delete student.videoAuth;
			const answers = {
				student,
				answers: state.answers,
			};
			console.log(answers);
			api.submitAnswers(answers).then((data) => {
				console.log(data);
				commit('setResult', data);
			}).catch((data) => {
				console.log(data);
				commit('setResult', data);
			});
		},
	},
});

export default store;
