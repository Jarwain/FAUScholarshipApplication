<template>
<div class='form-group'>
    <label>{{question}}</label>
    <input type="hidden" v-model="filename">
    <input type="file" class="form-control-file"
		@change="handleFile" @blur="onBlur"
		:class="{[invalid ? 'is-invalid' : 'is-valid']: beenFocused}">
	<div v-if="invalid" class="invalid-feedback">
		Upload {{ invalid[0] }}
	</div>
</div>
</template>

<script>
import validate from 'validate.js';

export default {
	name: 'FileInput',
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
				filetype: null,
			}),
		},
		value: {
			required: false,
		},
		constraints: {
			required: false,
			default: () => {},
		},
	},
	computed: {
		filename() {
			return this.value ? this.value.name : '';
		},
	},
	methods: {
		handleFile(event) {
			const file = event.target.files[0];
			this.$emit('input', file);
			this.validate();
			this.beenFocused = true;
		},
		onBlur() {
			this.beenFocused = true;
		},
		validate() {
			this.invalid = validate.single(this.filename, this.constraints);
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

