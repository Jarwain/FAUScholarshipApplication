<template>
<div class='form-group'>
    <label>{{question}}</label>
    <textarea class="form-control" rows="3"
		v-model="localValue" @blur="onBlur"
		:class="{[invalid ? 'is-invalid' : 'is-valid']: beenFocused}">
    </textarea>
    <label>Word Count: {{wordCount}}{{props.max_words ? `/${props.max_words}`:''}}</label>
    <div v-if="invalid" class="invalid-feedback">
		Essay {{ invalid[0] }}
	</div>
</div>
</template>

<script>
import validate from 'validate.js';

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
		constraints: {
			required: false,
			default: () => {},
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
			return this.localValue.split(/\s+/g).filter(e => e).length;
		},
		constraint() {
			const constraints = Object.assign({
				presence: this.props.optional ?
					false : { allowEmpty: false },
				length: {
					minimum: this.props.min_words,
					maximum: this.props.max_words,
					tooShort: 'must be at least %{count} words',
					tooLong: 'cannot be more than %{count} words',
					tokenizer: value => value.split(/\s+/g),
				},
			}, this.constraints);
			return constraints;
		},
	},
	methods: {
		onBlur() {
			this.beenFocused = true;
			this.validate();
		},
		validate() {
			this.invalid = validate.single(this.localValue, this.constraint);
			this.$emit('valid', !this.invalid);
		},
	},
	data() {
		return {
			invalid: null,
			beenFocused: false,
		};
	},
};
</script>

