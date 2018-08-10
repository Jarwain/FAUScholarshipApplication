import Vue from 'vue';
import Router from 'vue-router';
import Vuex from 'vuex';
import axios from 'axios';


Vue.config.productionTip = false;

Vue.use(Router);
Vue.use(Vuex);

// Generates a separate chunk for this route
// Which is lazy-loaded
function loadView(view) {
	return () => import(/* webpackChunkName: "view-[request]" */ `@/views/${view}.vue`);
}

const router = new Router({
	mode: 'history',
	base: `${process.env.BASE_URL}application/`,
	routes: [
		{
			path: '/',
			name: 'student',
			component: loadView('StudentForm'),
		},
		{
			path: '/select',
			name: 'select',
			component: loadView('ScholarshipSelect'),
		},
	],
});

const store = new Vuex.Store({
	state: {
		qualifiers: {},
		scholarships: {},
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
		requiredQualifiers(state) {
			return Object.values(state.qualifiers).filter(e => (e.props.required));
		},
		optionalQualifiers(state) {
			return Object.values(state.qualifiers).filter(e => (!e.props.required));
		},
	},
	mutations: {
		/* eslint no-param-reassign: [2, { "props": false }] */
		setQualifiers(state, qualifiers) {
			state.qualifiers = qualifiers;
		},
		setScholarships(state, scholarships) {
			state.scholarships = scholarships;
		},
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
		getAllQualifiers({ commit }) {
			if (window.FAUobj && window.FAUobj.qualifiers) {
				commit('setQualifiers', window.FAUobj.qualifiers);
			} else {
				axios
					.get(
						'https://boc22finaid.fau.edu/scholarship/api/qualifier/',
						{ headers: { Accept: 'application/json' } },
					)
					.then((response) => { commit('setQualifiers', response.data); });
			}
		},
		getAllScholarships({ commit }) {
			if (window.FAUobj && window.FAUobj.scholarships) {
				commit('setScholarships', window.FAUobj.scholarships);
			} else {
				axios
					.get(
						'https://boc22finaid.fau.edu/scholarship/api/scholarship/',
						{ headers: { Accept: 'application/json' } },
					)
					.then((response) => { commit('setScholarships', response.data); });
			}
		},
	},
});

new Vue({
	router,
	store,
}).$mount('#app');
