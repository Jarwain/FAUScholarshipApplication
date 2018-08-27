<template>
	<div class='form-group'>
		<label class='col col-form-label' :for="name">{{question}}</label>
		<select v-model="localValue" :multiple="props['multi']" class='form-control'
		@blur="onBlur"
		:class="{[invalid ? 'is-invalid' : 'is-valid']: beenFocused}">
			<option v-if="!props['multi']" disabled selected value>{{question}}</option>
			<option v-for="option in props['haystack']" :key='option'
				:value='option'>{{option}}</option>";
		</select>
		<div v-if="invalid" class="invalid-feedback">
			{{name}} {{ invalid[0] }}
		</div>
	</div>
</template>

<script>
import validate from 'validate.js';

export default {
	name: 'SelectInput',
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
			required: true,
		},
		value: {
			required: true,
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
				return this.value || (this.props.multi ? [] : '');
			},
			set(value) {
				this.$emit('input', value);
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

