<template>
	<div class="card my-2">
		<div class="card-header d-flex align-items-center justify-content-between">
			<a class="" data-toggle="collapse" :href="`#sch_${code}`">
				{{name}}
			</a>
			<button class="btn"
			v-if="applicable"
			:class="checked ? 'btn-outline-danger' : 'btn-outline-success'"
			@click="toggle">
				{{checked ? 'Remove' : 'Apply'}}
			</button>
			<button class="btn btn-secondary"
			v-if="!applicable"
			disabled
			:class="checked ? 'btn-outline-danger' : 'btn-outline-success'">
				Closed
			</button>
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
		applicable: {
			type: Boolean,
			required: false,
		},
	},
	data() {
		return {
			checked: this.$store.state.selected_scholarships.indexOf(this.code) !== -1,
		};
	},
	methods: {
		toggle() {
			this.checked = !this.checked;
			this.$store.commit('toggleSelectedScholarship', this.code);
		},
	},
};
</script>

