var BoolInput = {
	props: {
		name: {
			type: String,
			default: '',
			required: true,
		},
		question: {
			type: String,
			default: '',
			required: true
		},
		props: {
			required: false
		},
		value:{
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
			},
		}
	},
	template: `<div class='form-group row'>
		<label class='col-sm-3 col-form-label' :for='name'>{{question}}</label>
		<div class='col-sm-9'>
			<div class='form-check form-check-inline'>
				<input v-model="localValue" class='form-check-input' type='radio' :name='name' value='true'>
				<label class='form-check-label' :for='name'>Yes</label>
			</div>
			<div class='form-check form-check-inline'>
				<input v-model="localValue" class='form-check-input' type='radio' :name='name' value='false'>
				<label class='form-check-label' :for='name'>No</label>
			</div>
		</div>
	</div>`
};

var RangeInput = {
	props: {
		name: {
			type: String,
			default: '',
			required: true,
		},
		question: {
			type: String,
			default: '',
			required: true
		},
		props: {
			type: Object,
			default: ()=>({
				min: 0,
				max: 10,
				step: 1,
			}),
			required: true
		},
		value:{
			required: false,
			default: 0
		}
	},
	computed: {
		localValue: {
			get() {
				return this.value || (this.props.max+this.props.min) / 2;
			},
			set(value) {
				this.$emit('input', value);
			},
		}
	},
	template: `<div class='form-group'>
		<div class="custom-control-inline">
			<label class='col-auto col-form-label' :for='name'>{{question}}</label> 
			<input class="form-control col-3" type="text" :name="name" v-model="localValue">
		</div>
		<input v-model="localValue" type='range' class='custom-range' :min="props['min']" :max="props['max']" :step="props['step']">
	</div>`
};

var SelectInput = {
	props: {
		name: {
			type: String,
			default: '',
			required: true,
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
		value:{
			default: ()=>[],
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
			},
		}
	},
	template: `<div class='form-group'>
    <label class='col-sm-3 col-form-label' :for="name">{{question}}</label>
    <select v-model="localValue" :multiple="props['multi']" :name="props['multi'] ? name + '[]' : name" class='form-control'>
			<option v-if="!props['multi']" disabled selected value>{{question}}</option>
			<option v-for="option in props['haystack']" :key='option' :value='option'>{{option}}</option>";
    </select>
  </div>`
};

Vue.component('qualifier-input', {
	components: {
		BoolInput,
		RangeInput,
		SelectInput,
	},
	props: {
		qualifier: {
			type: Object,
			required: true,
		},
		value:{
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
			},
		}
	},
	template: `<div>
		<bool-input v-if="qualifier.type == 'bool'" v-bind="qualifier" v-model="localValue">
		</bool-input>
		<range-input v-if="qualifier.type == 'range'" v-bind="qualifier" v-model="localValue">
		</range-input>
		<select-input v-if="qualifier.type == 'select'" v-bind="qualifier" v-model="localValue">
		</select-input>
	</div>`
});