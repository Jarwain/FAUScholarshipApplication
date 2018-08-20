<template>
<div class='form-group'>
    <label>{{question}}</label>
    <input type="hidden" v-model="filename">
    <input type="file" class="form-control-file"
		:required="!props.optional" @change="handleFile"
		:class="{'is-invalid':invalid, 'is-valid':!invalid && invalid != null}">
	<div v-if="invalid" class="invalid-feedback">
		{{ invalid[0] }}
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
				filetype: 'pdf',
			}),
		},
		value: {
			required: false,
		},
	},
	computed: {
	},
	methods: {
		handleFile(event) {
			const file = event.target.files[0];
			this.$emit('input', file);
			this.filename = file ? file.name : '';
		},
	},
	data() {
		return {
			filename: '',
		};
	},
};
</script>

