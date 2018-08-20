import ScholarshipApi from '@/api';

export default {
	namespaced: true,
	state: {
		loading: true,
		all: new Map(),
	},
	getters: {
		categorizedRequirements: state => Array.from(state.all.values())
		.map(scholarship =>	({
			...scholarship,
			requirements: scholarship.requirements.reduce((a, e) => {
				a[e.category] = a[e.category] ? [...a[e.category], e] : [e];
				return a;
			}, {}),
		})),
	},
	mutations: {
		/* eslint no-param-reassign: [2, { "props": false }] */
		set(state, scholarships) {
			state.loading = false;
			state.all = new Map(Object.entries(scholarships));
		},
	},
	actions: {
		initialize({ state, commit }) {
			if (state.loading) {
				if (window.FAUObj && window.FAUObj.scholarships) {
					commit('set', window.FAUObj.scholarships);
				} else {
					ScholarshipApi.get('scholarships')
						.then((data) => {
							commit('set', data);
						});
				}
			}
		},
	},
};
