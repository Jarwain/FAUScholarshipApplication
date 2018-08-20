<template>
<div class='form-group'>
    <label>{{question}}</label>
    <textarea class="form-control" rows="3"
	:required="!props.optional" v-model="localValue"
	:class="{'is-invalid':invalid, 'is-valid':!invalid && invalid != null}">
    </textarea>
    <div v-if="invalid" class="invalid-feedback">
		{{ invalid[0] }}
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
		invalid: {
			required: false,
			default: null,
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

