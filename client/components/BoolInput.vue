<template>
	<fieldset class='form-group row'>
		<label class='col-sm-3 col-form-label' :for='name'>{{question}}</label>
		<div class='col-sm-9'>
			<div class='form-check form-check-inline'>
				<input class='form-check-input' type='radio'
				v-model="localValue" :name='name' value='true'
				:class="{[invalid ? 'is-invalid' : 'is-valid']: validated}">
				<label class='form-check-label' :for='name'>Yes</label>
			</div>
			<div class='form-check form-check-inline'>
				<input class='form-check-input' type='radio'
				v-model="localValue" :name='name' value='false'
				:class="{[invalid ? 'is-invalid' : 'is-valid']: validated}">
				<label class='form-check-label' :for='name'>No</label>
				<div v-if="invalid" class="invalid-feedback">
					{{ invalid[0] }}
				</div>
			</div>
		</div>
	</fieldset>
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
		validated: {
			type: Boolean,
			required: false,
			default: false,
		},
		invalid: {
			type: Array,
			required: false,
		},
	},
	computed: {
		localValue: {
			get() {
				return this.value;
			},
			set(value) {
				this.$emit('input', value);
			},
		},
	},
	data() {
		return {
		};
	},
};
</script>

