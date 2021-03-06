import ScholarshipApi from '@/api';

function validateBool(value) {
	return value;
}

function validateRange(value, valid) {
	const min = valid[0] ? valid[0] : this.props.min;
	const max = valid[1] ? valid[1] : this.props.max;
	return min < value && value < max;
}

function validateSelect(value, valid) {
	if (Array.isArray(value)) {
		return value.reduce((a, e) => {
			if (a) return a;
			return valid.includes(e);
		}, false);
	}
	return valid.includes(value);
}

export default {
	namespaced: true,
	state: {
		loading: true,
		all: new Map(),
	},
	getters: {
		required(state) {
			return Array.from(state.all.values()).filter(e => e.props.required);
		},
		optional(state) {
			return Array.from(state.all.values()).filter(e => !e.props.required);
		},
		constraints(state) {
			const constraints = {};
			state.all.forEach((e) => {
				constraints[e.name] = e.constraints;
			});
			return constraints;
		},
	},
	mutations: {
		set(state, qualifiers) {
			state.loading = false;
			Object.values(qualifiers).forEach((e) => {
				e.constraints = {
					presence: e.props.required ?
						{ allowEmpty: false } : false,
				};
				switch (e.type) {
				case 'bool':
					e.validate = validateBool;
					break;
				case 'range':
					e.validate = validateRange;
					e.constraints.numericality = {
						greaterThanOrEqualTo: e.props.min,
						lessThanOrEqualTo: e.props.max,
					};
					break;
				case 'select':
					e.validate = validateSelect;
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
				if (window.FAUObj && window.FAUObj.qualifiers) {
					commit('set', window.FAUObj.qualifiers);
				} else {
					ScholarshipApi.get('qualifiers')
						.then((data) => {
							commit('set', data);
						});
				}
			}
		},
	},
};
