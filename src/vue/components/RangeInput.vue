<template>
	<div class="form-group">
		<div class="custom-control-inline">
			<label class="col-auto col-form-label" :for="name">{{question}}</label>
			<input class="form-control col-3" type="text" :name="name"
			v-model="localValue" @blur="beenFocused = true"
			:class="{[invalid ? 'is-invalid' : 'is-valid']: beenFocused || validated}">
			<div v-if="invalid" class="invalid-feedback">
				{{ invalid[0] }}
			</div>
		</div>
		<input type="range" class="custom-range"
		v-model="localValue" @blur="beenFocused = true"
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
				return this.value || null;
			},
			set(value) {
				this.$emit('input', +value);
			},
		},
	},
	data() {
		return {
			beenFocused: false,
		};
	},
};
</script>

