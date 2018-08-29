<template>
<div class='form-group'>
	<label>{{question}}</label>
	<div class="input-group mb-3">
		<div class="input-group-prepend">
			<span class="input-group-text" id="basic-addon3">https://youtu.be/</span>
		</div>
		<input type="text" class="form-control" placeholder="uqBStEIVF8o"
		v-model="localValue" @blur="onBlur"
		:class="{[invalid ? 'is-invalid' : 'is-valid']: beenFocused}">
		<div class="input-group-append">
			<button class="btn btn-outline-secondary" type="button"
			@click="showVideo = !showVideo">
				Test
			</button>
		</div>
		<div v-if="invalid" class="invalid-feedback">
			{{ invalid[0] }}
		</div>
	</div>
	<iframe width="560" height="315" frameborder="0" :hidden="!showVideo"
		allow="autoplay; encrypted-media" allowfullscreen
		:src="`https://www.youtube-nocookie.com/embed/${localValue}?rel=0`"
	></iframe>
</div>
</template>

<script>
import validate from 'validate.js';

export default {
	name: 'VideoInput',
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
				this.validate(value);
			},
		},
	},
	methods: {
		onBlur() {
			this.beenFocused = true;
			this.validate();
		},
		validate(val = null) {
			const value = val || this.localValue;
			this.invalid = validate.single(value, this.constraints);
			this.$emit('valid', !this.invalid);
		},
	},
	data() {
		return {
			invalid: null,
			beenFocused: false,
			showVideo: false,
		};
	},
};
</script>

