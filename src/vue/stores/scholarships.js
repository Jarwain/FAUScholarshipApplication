import ScholarshipApi from '@/api';

export default {
	namespaced: true,
	state: {
		loading: true,
		all: new Map(),
	},
	getters: {
	},
	mutations: {
		/* eslint no-param-reassign: [2, { "props": false }] */
		set(state, scholarships) {
			state.loading = false;
			state.all = new Map(Object.entries(scholarships));
		},
	},
	actions: {
		initialize({ commit }) {
			if (window.FAUObj && window.FAUObj.scholarships) {
				commit('set', window.FAUObj.scholarships);
			} else {
				ScholarshipApi.getScholarships((scholarships) => {
					commit('set', scholarships);
				});
			}
		},
	},
};
