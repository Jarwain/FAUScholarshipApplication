<template>
	<component :is="component"  v-bind="question"
	v-model="localValue" :invalid="invalid" :validated="validated">
	</component>
</template>

<script>
import EssayInput from './EssayInput.vue';
import FileInput from './FileInput.vue';
import VideoInput from './VideoInput.vue';

export default {
	name: 'QuestionInput',
	components: {
		EssayInput,
		FileInput,
		VideoInput,
	},
	props: {
		question: {
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
			switch (this.question.type) {
			case 'essay':
				return EssayInput;
			case 'file':
				return FileInput;
			case 'video':
				return VideoInput;
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

