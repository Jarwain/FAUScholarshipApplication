<template>
	<div class='form-group'>
    <label>{{question}}</label>
    <textarea class="form-control" rows="3"
    	:required="!props.optional" v-model="localValue">
    </textarea>
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
			default: () => {},
		},
		value: {
			required: true,
			default: '',
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

