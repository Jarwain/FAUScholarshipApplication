<template>
	<div class='form-group'>
		<label class='col-sm-3 col-form-label' :for='name'>{{question}}</label>
		<div class='col-sm-9'>
			<div class='form-check form-check-inline'>
				<input class='form-check-input' type='radio'
				v-model="localValue" :name='name' value='true'
				:class="{[invalid ? 'is-invalid' : 'is-valid']: localValue}">
				<label class='form-check-label' :for='name'>Yes</label>
			</div>
			<div class='form-check form-check-inline'>
				<input class='form-check-input' type='radio'
				v-model="localValue" :name='name' value='false'
				:class="{[invalid ? 'is-invalid' : 'is-valid']: localValue}">
				<label class='form-check-label' :for='name'>No</label>
				<div v-if="invalid" class="invalid-feedback">
					{{name}} {{ invalid[0] }}
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import validate from 'validate.js';

export default {
	name: 'BoolInput',
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
		value: {
			required: true,
			default: '',
		},
		props: {
			// type: Object,
			default: () => {},
		},
		constraints: {
			required: false,
			default: () => {},
		},
	},
	methods: {
		validate() {
			this.invalid = validate.single(this.localValue, this.constraints);
			this.$emit('valid', !this.invalid);
		},
	},
	computed: {
		localValue: {
			get() {
				return this.value;
			},
			set(value) {
				this.$emit('input', value);
				this.validate();
			},
		},
	},
	data() {
		return {
			invalid: false,
		};
	},
};
</script>

