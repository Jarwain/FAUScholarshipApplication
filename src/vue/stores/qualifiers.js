import ScholarshipApi from '@/api';

export default {
	namespaced: true,
	state: {
		loading: true,
		all: new Map(),
	},
	getters: {
		required(state) {
			return Array.from(state.all.values()).filter(e => (e.props.required));
		},
		optional(state) {
			return Array.from(state.all.values()).filter(e => (!e.props.required));
		},
	},
	mutations: {
		set(state, qualifiers) {
			state.loading = false;
			state.all = new Map(Object.entries(qualifiers));
		},
	},
	actions: {
		initialize({ commit }) {
			if (window.FAUobj && window.FAUobj.qualifiers) {
				commit('set', window.FAUobj.qualifiers);
			} else {
				ScholarshipApi.getQualifiers((qualifiers) => {
					commit('set', qualifiers);
				});
			}
		},
	},
};
