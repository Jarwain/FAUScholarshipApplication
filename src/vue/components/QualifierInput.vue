<template>
	<component :is="component"  v-bind="qualifier"
		v-model="localValue" :invalid="invalid">
	</component>
		<!-- <bool-input v-if="qualifier.type == 'bool'" v-bind="qualifier"
		v-model="localValue" :invalid="invalid">
		</bool-input>
		<range-input v-if="qualifier.type == 'range'" v-bind="qualifier"
		v-model="localValue" :invalid="invalid">
		</range-input>
		<select-input v-if="qualifier.type == 'select'" v-bind="qualifier"
		v-model="localValue" :invalid="invalid">
		</select-input> -->
</template>

<script>
import validate from 'validate.js';
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
				this.invalid = validate.single(value, this.qualifier.constraint) || false;
				if (!this.invalid) {
					this.$emit('valid');
				}
			},
		},
	},
	data() {
		return {
			invalid: null,
		};
	},
};
</script>

