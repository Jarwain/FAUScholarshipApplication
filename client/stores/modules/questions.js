import ScholarshipApi from '@/api';

export default {
	namespaced: true,
	state: {
		loading: true,
		all: new Map(),
	},
	getters: {
		video(state) {
			return Array.from(state.all.values()).filter(e => (e.type === 'video'));
		},
	},
	mutations: {
		set(state, questions) {
			state.loading = false;
			Object.values(questions).forEach((e) => {
				e.constraints = {
					presence: e.props.optional ?
						false : {
							allowEmpty: false,
							message: 'is required',
						},
				};
				switch (e.type) {
				case 'essay':
					e.constraints.length = {
						minimum: e.props.min_words,
						maximum: e.props.max_words,
						tooShort: 'must be at least %{count} words',
						tooLong: 'cannot be more than %{count} words',
						tokenizer: value => value.split(/\s+/g),
					};
					break;
				case 'file':
					e.constraints.format = {
						pattern: e.props.filetype ?
							`.*(${e.props.filetype})$` : false,
						message: 'has invalid filetype',
					};
					break;
				case 'video':
					break;
				default:
					break;
				}
				state.all.set(e.id, e);
			});
		},
	},
	actions: {
		initialize({ state, commit }) {
			if (state.loading) {
				if (window.FAUObj && window.FAUObj.questions) {
					commit('set', window.FAUObj.questions);
				} else {
					ScholarshipApi.get('questions')
						.then((data) => {
							commit('set', data);
						});
				}
			}
		},
	},
};
