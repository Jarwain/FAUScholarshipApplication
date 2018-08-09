<template>
	<div class="card mb-4">
		<div class="card-header">
			{{name}}
		</div>
		<div class="card-body">
			<p class="card-text">
				{{description}}
			</p>
		</div>
		<div v-if="requirements.length > 0" class="card-footer text-muted">
			<a data-toggle="collapse" :href="`#req_${code}`">
				{{visible_requirements ? 'Hide' : 'View'}} Requirements
			</a>
			<div class="collapse multi-collapse" :id="`req_${code}`">
				<p>
					{{requirements}}
				</p>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	name: 'SelectableScholarship',
	props: {
		selected: {
			type: Boolean,
			required: true,
			default: false
		},
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
			type: Number,
			required: true,
		},
		questions: {
			type: Array,
			required: true
		},
		requirements: {
			type: Array,
			required: true,
		}
	},
	computed: {
		localValue: {
			get() {
				return this.selected;
			},
			set(selected) {
				this.$emit('input', selected);
			},
		}
	},
	data(){
		return {
			visibleRequirements: false,
		};
	},
}
</script>

