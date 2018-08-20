<template>
	<div class='form-group'>
		<label class='col col-form-label' :for="name">{{question}}</label>
		<select v-model="localValue" :multiple="props['multi']" class='form-control'
		:class="{'is-invalid':invalid, 'is-valid':!invalid && invalid != null}">
			<option v-if="!props['multi']" disabled selected value>{{question}}</option>
			<option v-for="option in props['haystack']" :key='option'
				:value='option'>{{option}}</option>";
		</select>
		<div v-if="invalid" class="invalid-feedback">
			{{ invalid[0] }}
		</div>
	</div>
</template>

<script>
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
		invalid: {
			required: false,
			default: null,
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
		};
	},
};
</script>

