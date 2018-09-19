<template>
	<div class="card my-2">
		<div class="card-header d-flex align-items-center justify-content-between">
			<a class="" data-toggle="collapse" :href="`#sch_${code}`">
				{{name}}
			</a>
			<button class="btn"
			v-if="!not_applicable"
			:class="[checked ? 'btn-outline-danger' : 'btn-outline-success']"
			@click="toggle">
				{{checked ? "Remove" : "Apply"}}
			</button>
			<span v-if="not_applicable" class="d-inline-block" tabindex="0"
			data-toggle="tooltip" :title="not_applicable[0]">
				<button class="btn btn-secondary" disabled>
					Closed
				</button>
			</span>
		</div>
		<div class="collapse" :id="`sch_${code}`">
			<div class="card-body">
				<p class="card-text">
					{{description}}
				</p>
			</div>
			<div v-if="requirements" class="card-footer text-muted">
				{{requirements}}
			</div>
		</div>
	</div>
</template>

<script>
export default {
	name: 'SelectableScholarship',
	props: {
		code: {
			type: String,
			required: true,
		},
		name: {
			type: String,
			required: true,
		},
		description: {
			type: String,
			required: true,
		},
		max: {
			/* type: Number, */
			required: true,
		},
		questions: {
			type: Array,
			required: true,
		},
		requirements: {
			required: true,
		},
		not_applicable: {
			required: false,
		},
		checked: {
			type: Boolean,
			required: true,
		},
	},
	data() {
		return {
		};
	},
	methods: {
		toggle() {
			this.$emit('toggle');
		},
	},
};
</script>

