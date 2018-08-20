<template>
	<component :is="component"  v-bind="question"
		v-model="localValue" :invalid="invalid">
	</component>
		<!-- <essay-input v-if="question.type == 'essay'" v-bind="question" v-model="localValue">
		</essay-input>
		<file-input v-if="question.type == 'file'" v-bind="question" v-model="localValue">
		</file-input>
		<video-input v-if="question.type == 'video'" v-bind="question" v-model="localValue">
		</video-input> -->
</template>

<script>
import validate from 'validate.js';
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
				let val = value;
				let constraint = {
					presence: this.question.optional ? false : { allowEmpty: false },
				};
				switch (this.question.type) {
				case 'essay':
					// constraint = {};
					break;
				case 'file':
					// constraint = {};
					val = val ? val.name : '';
					break;
				case 'video':
					// constraint = {};
					break;
				default:
					throw new Error('Unknown Question Type in QuestionInput');
				}
				this.invalid = validate.single(val, constraint) || false;
				if (this.invalid != null) {
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

