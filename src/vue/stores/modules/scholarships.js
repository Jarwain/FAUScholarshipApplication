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
		/*qualifying: (state, getters, rootState, rootGetters) => {
			const scholarships = getters.categorizedRequirements;
			const qualifiers = rootState.qualifiers.all;
			const qualifications = rootGetters.getQualifications;
			const [pass, fail] = scholarships.reduce(([p, f], scholarship) => {
				if (scholarship.requirements.length === 0) {
					return [[...p, scholarship], f];
				}
				const categoryResults = Object.entries(scholarship.requirements)
					.reduce((category, [cat, requirements]) => {
						category[cat] = requirements.reduce((res, req) => {
							if (!res) return false;
							const qualifier = qualifiers.get(req.qualifier_id);
							const qual = qualifications[req.qualifier_id];
							return qualifier.validate(qual, req.valid);
						}, true);
						return category;
					}, {});

				if (categoryResults.length === 1 && '*' in categoryResults) {
					return categoryResults['*'] ? [[...p, scholarship], f] : [p, [...f, scholarship]];
				}
				const wildcard = '*' in categoryResults ? categoryResults['*'] : true;
				delete categoryResults['*'];

				const result = Object.values(categoryResults).reduce((a, e) => {
					if (a) return true;
					return e;
				}, false);

				return result && wildcard ? [[...p, scholarship], f] : [p, [...f, scholarship]];
			}, [[], []]);
			return { pass, fail };
		},*/
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
