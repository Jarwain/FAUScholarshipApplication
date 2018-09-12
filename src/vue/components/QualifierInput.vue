<template>
	<component :is="component"  v-bind="qualifier"
	v-model="localValue" :invalid="invalid" :validated="validated">
	</component>
</template>

<script>
import BoolInput from './BoolInput.vue';
import RangeInput from './RangeInput.vue';
import SelectInput from './SelectInput.vue';

export default {
	name: 'QualifierInput',
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
		value: {
			required: false,
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
		component() {
			switch (this.qualifier.type) {
			case 'bool':
				return BoolInput;
			case 'range':
				return RangeInput;
			case 'select':
				return SelectInput;
			default:
				return '';
			}
		},
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

