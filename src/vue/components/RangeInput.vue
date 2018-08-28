<template>
	<div class='form-group'>
		<div class="custom-control-inline">
			<label class='col-auto col-form-label' :for='name'>{{question}}</label>
			<input class="form-control col-3" type="text"
			v-model="localValue" @blur="onBlur"
			:class="{[invalid ? 'is-invalid' : 'is-valid']: beenFocused}">
			<div v-if="invalid" class="invalid-feedback">
				{{name}} {{ invalid[0] }}
			</div>
		</div>
		<input type='range' class='custom-range'
		v-model="localValue" @blur="onBlur"
		:min="props['min']" :max="props['max']" :step="props['step']">
	</div>
</template>

<script>
import validate from 'validate.js';

export default {
	name: 'RangeInput',
	props: {
		name: {
			type: String,
			default: '',
			required: true,
		},
		question: {
			type: String,
			default: '',
			required: true,
		},
		props: {
			type: Object,
			default: () => ({
				min: 0,
				max: 10,
				step: 1,
			}),
			required: true,
		},
		value: {
			type: Number,
			required: true,
			default: 0,
		},
		constraints: {
			required: false,
			default: null,
		},
	},
	methods: {
		onBlur() {
			this.beenFocused = true;
			this.validate();
		},
		validate() {
			if (this.constraints) {
				this.invalid = validate.single(this.localValue, this.constraints);
			}
			this.$emit('valid', !this.invalid);
		},
	},
	computed: {
		localValue: {
			get() {
				return this.value || null;
			},
			set(value) {
				this.$emit('input', +value);
			},
		},
	},
	data() {
		return {
			invalid: null,
			beenFocused: false,
		};
	},
};
</script>

