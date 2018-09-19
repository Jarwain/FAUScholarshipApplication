<template>
<div class='form-group'>
    <label>{{question}}</label>
    <input type="hidden" v-model="filename">
    <input type="file" class="form-control-file"
		@change="handleFile" @blur="beenFocused = true"
		:class="{[invalid ? 'is-invalid' : 'is-valid']: beenFocused || validated}">
	<div v-if="invalid" class="invalid-feedback">
		Upload {{ invalid[0] }}
	</div>
</div>
</template>

<script>
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
		filename() {
			return this.value ? this.value.name : '';
		},
	},
	methods: {
		handleFile(event) {
			const file = event.target.files[0];
			this.$emit('input', file);
		},
	},
	data() {
		return {
			beenFocused: false,
		};
	},
};
</script>

