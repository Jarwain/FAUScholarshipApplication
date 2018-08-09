var BoolInput = {
	props: {
		name: {
			type: String,
			default: '',
			required: true
		},
		question: {
			type: String,
			default: '',
			required: true
		},
		props: {
			required: false
		},
		value: {
			required: false
		}
	},
	computed: {
		localValue: {
			get() {
				return this.value;
			},
			set(value) {
				this.$emit('input', value);
			}
		}
	},
	template: '<div class=\'form-group row\'>\n\t\t<label class=\'col-sm-3 col-form-label\' :for=\'name\'>{{question}}</label>\n\t\t<div class=\'col-sm-9\'>\n\t\t\t<div class=\'form-check form-check-inline\'>\n\t\t\t\t<input v-model="localValue" class=\'form-check-input\' type=\'radio\' :name=\'name\' value=\'true\'>\n\t\t\t\t<label class=\'form-check-label\' :for=\'name\'>Yes</label>\n\t\t\t</div>\n\t\t\t<div class=\'form-check form-check-inline\'>\n\t\t\t\t<input v-model="localValue" class=\'form-check-input\' type=\'radio\' :name=\'name\' value=\'false\'>\n\t\t\t\t<label class=\'form-check-label\' :for=\'name\'>No</label>\n\t\t\t</div>\n\t\t</div>\n\t</div>'
};

var RangeInput = {
	props: {
		name: {
			type: String,
			default: '',
			required: true
		},
		question: {
			type: String,
			default: '',
			required: true
		},
		props: {
			type: Object,
			default: () => ({
				min: 0,
				max: 10,
				step: 1
			}),
			required: true
		},
		value: {
			required: false,
			default: 0
		}
	},
	computed: {
		localValue: {
			get() {
				return this.value || (this.props.max + this.props.min) / 2;
			},
			set(value) {
				this.$emit('input', value);
			}
		}
	},
	template: '<div class=\'form-group\'>\n\t\t<div class="custom-control-inline">\n\t\t\t<label class=\'col-auto col-form-label\' :for=\'name\'>{{question}}</label> \n\t\t\t<input class="form-control col-3" type="text" :name="name" v-model="localValue">\n\t\t</div>\n\t\t<input v-model="localValue" type=\'range\' class=\'custom-range\' :min="props[\'min\']" :max="props[\'max\']" :step="props[\'step\']">\n\t</div>'
};

var SelectInput = {
	props: {
		name: {
			type: String,
			default: '',
			required: true
		},
		question: {
			type: String,
			default: '',
			required: true
		},
		props: {
			type: Object,
			required: true
		},
		value: {
			default: () => [],
			required: false
		}
	},
	computed: {
		localValue: {
			get() {
				return this.value || (this.props['multi'] ? [] : "");
			},
			set(value) {
				this.$emit('input', value);
			}
		}
	},
	template: '<div class=\'form-group\'>\n    <label class=\'col-sm-3 col-form-label\' :for="name">{{question}}</label>\n    <select v-model="localValue" :multiple="props[\'multi\']" :name="props[\'multi\'] ? name + \'[]\' : name" class=\'form-control\'>\n\t\t\t<option v-if="!props[\'multi\']" disabled selected value>{{question}}</option>\n\t\t\t<option v-for="option in props[\'haystack\']" :key=\'option\' :value=\'option\'>{{option}}</option>";\n    </select>\n  </div>'
};

Vue.component('qualifier-input', {
	components: {
		BoolInput,
		RangeInput,
		SelectInput
	},
	props: {
		qualifier: {
			type: Object,
			required: true
		},
		value: {
			default: null,
			required: false
		}
	},
	computed: {
		localValue: {
			get() {
				return this.value;
			},
			set(value) {
				this.$emit('input', value);
			}
		}
	},
	template: '<div>\n\t\t<bool-input v-if="qualifier.type == \'bool\'" v-bind="qualifier" v-model="localValue">\n\t\t</bool-input>\n\t\t<range-input v-if="qualifier.type == \'range\'" v-bind="qualifier" v-model="localValue">\n\t\t</range-input>\n\t\t<select-input v-if="qualifier.type == \'select\'" v-bind="qualifier" v-model="localValue">\n\t\t</select-input>\n\t</div>'
});