<template>
	<div class='form-group'>
		<div class="custom-control-inline">
			<label class='col-auto col-form-label' :for='name'>{{question}}</label>
			<input class="form-control col-3" type="text" v-model="localValue"
			:class="{'is-invalid':invalid, 'is-valid':!invalid && invalid != null}">
			<div v-if="invalid" class="invalid-feedback">
				{{ invalid[0] }}
			</div>
		</div>
		<input v-model="localValue" type='range' class='custom-range'
		:min="props['min']" :max="props['max']" :step="props['step']">
	</div>
</template>

<script>
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
		invalid: {
			required: false,
			default: null,
		},
	},
	computed: {
		localValue: {
			get() {
				return this.value || (this.props.max + this.props.min) / 2;
			},
			set(value) {
				this.$emit('input', +value);
			},
		},
	},
	data() {
		return {
		};
	},
};
</script>

