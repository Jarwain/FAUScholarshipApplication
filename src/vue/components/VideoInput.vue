<template>
<div class='form-group'>
	<label>{{question}}</label>
	<div class="input-group mb-3">
		<div class="input-group-prepend">
			<span class="input-group-text" id="basic-addon3">https://youtu.be/</span>
		</div>
		<input type="text" class="form-control" placeholder="uqBStEIVF8o"
		v-model="localValue" @blur="beenFocused = true"
		:class="{[invalid ? 'is-invalid' : 'is-valid']: beenFocused || validated}">
		<div class="input-group-append">
			<button class="btn btn-outline-secondary" type="button"
			@click="showVideo = !showVideo">
				{{showVideo ? 'Hide' : 'Show'}}
			</button>
			<!-- <button class="btn btn-secondary" type="button">
				<font-awesome-icon icon="question-circle" />
			</button> -->
		</div>
		<div v-if="invalid" class="invalid-feedback">
			{{ invalid[0] }}
		</div>
	</div>
	<div :hidden="!showVideo">
		<p>
			Make sure your video appears below before submitting the application
		</p>
		<iframe width="560" height="315" frameborder="0"
			allow="autoplay; encrypted-media" allowfullscreen
			:src="`https://www.youtube-nocookie.com/embed/${localValue}?rel=0`"
		></iframe>
	</div>
</div>
</template>

<script>
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
			set(val) {
				const value = this.youtube_parser(val) || val;
				this.$emit('input', value);
				this.showVideo = true;
			},
		},
	},
	methods: {
		youtube_parser(url) {
			const regExp = /.*(?:youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=)([^#&?]*).*/;
			const match = url.match(regExp);
			return (match && match[1]) ? match[1] : false;
		},
	},
	data() {
		return {
			beenFocused: false,
			showVideo: false,
		};
	},
};
</script>

