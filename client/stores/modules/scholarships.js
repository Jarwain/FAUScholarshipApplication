import ScholarshipApi from '@/api';

export default {
	namespaced: true,
	state: {
		loading: true,
		all: new Map(),
	},
	getters: {
		eligible(state) {
			return Array.from(state.all.values()).filter(e => e.eligible);
		},
		ineligible(state) {
			return Array.from(state.all.values()).filter(e => !e.eligible);
		},
	},
	mutations: {
		set(state, scholarships) {
			state.loading = false;
			state.all = new Map(Object.entries(scholarships));
		},
	},
	actions: {
		initialize({ state, commit }, query = null) {
			if (state.loading) {
				if (window.FAUObj && window.FAUObj.scholarships && !query) {
					commit('set', window.FAUObj.scholarships);
				} else {
					const q = query || {};
					q.active = true;
					ScholarshipApi.get('scholarships', q)
						.then((data) => {
							commit('set', data);
						});
				}
			}
		},
	},
};
