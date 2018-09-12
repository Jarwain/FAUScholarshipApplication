<template>
<div class='form-group'>
    <label>{{question}}</label>
    <textarea class="form-control" rows="3"
		v-model="localValue" @blur="beenFocused = true"
		:class="{[invalid ? 'is-invalid' : 'is-valid']: beenFocused || validated}">
    </textarea>
    <label>Word Count: {{wordCount}}{{props.max_words ? `/${props.max_words}`:''}}</label>
    <div v-if="invalid" class="invalid-feedback">
		Essay {{ invalid[0] }}
	</div>
</div>
</template>

<script>
export default {
	name: 'EssayInput',
	props: {
		id: {
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
				min_words: null,
				max_words: null,
			}),
		},
		value: {
			required: true,
			default: '',
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
		wordCount() {
			const count = this.localValue.split(/\s+/g);
			return count[count.length - 1] ? count.length : count.length - 1;
		},
	},
	data() {
		return {
			beenFocused: false,
		};
	},
};
</script>

