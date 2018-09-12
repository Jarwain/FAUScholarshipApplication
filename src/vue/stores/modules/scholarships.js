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
		set(state, scholarships) {
			state.loading = false;
			console.log(scholarships)
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
