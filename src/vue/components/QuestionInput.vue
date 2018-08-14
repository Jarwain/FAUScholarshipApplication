<template>
	<div>
		<essay-input v-if="question.type == 'essay'" v-bind="question" v-model="localValue">
		</essay-input>
		<file-input v-if="question.type == 'file'" v-bind="question" v-model="localValue">
		</file-input>
		<video-input v-if="question.type == 'video'" v-bind="question" v-model="localValue">
		</video-input>
	</div>
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

