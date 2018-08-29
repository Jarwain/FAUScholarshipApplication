<template>
<div class="form-group col">
	<label :for="name">{{question}}</label>
	<div class="input-group mb-3">
		<div v-if="prepend" class="input-group-prepend">
			<span class="input-group-text">{{prepend}}</span>
		</div>
		<input :type="type" class="form-control" :name="name"
		:placeholder="placeholder ? placeholder : question"
		v-model="localValue" @blur="onBlur"
		:class="{[invalid ? 'is-invalid' : 'is-valid']: beenFocused}">
		<div v-if="invalid"	class="invalid-feedback">
			{{name}} {{ invalid[0] }}
		</div>
	</div>
</div>
</template>

<script>
import validate from 'validate.js';

export default {
	name: 'TextInput',
	props: {
		question: {
			type: String,
			required: true,
		},
		name: {
			type: String,
			required: true,
		},
		type: {
			type: String,
			required: false,
			default: 'text',
		},
		placeholder: {
			type: String,
			required: false,
		},
		value: {
			required: true,
		},
		prepend: {
			type: String,
			required: false,
		},
		constraints: {
			type: Object,
			required: false,
			default: () => {},
		},
	},
	computed: {
		localValue: {
			get() {
				return this.value || '';
			},
			set(value) {
				this.$emit('input', value);
				this.validate(value);
			},
		},
	},
	methods: {
		onBlur() {
			this.beenFocused = true;
			this.validate();
		},
		validate(val = null) {
			const value = val || this.localValue;
			this.invalid = validate.single(value, this.constraints);
			this.$emit('valid', !this.invalid);
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

