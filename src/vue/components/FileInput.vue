<template>
<div class='form-group row'>
    <label>{{question}}</label>
    <input type="hidden" v-model="localValue">
    <input type="file" class="form-control-file"
			:required="!props.optional" @change="getFilename">
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
			default: () => {},
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
	methods: {
		getFilename(event) {
			this.localValue = event.target.files[0].name;
		},
	},
	data() {
		return {

		};
	},
};
</script>

