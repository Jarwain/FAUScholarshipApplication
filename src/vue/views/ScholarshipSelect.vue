<template>
<div role="main" class="container">
	<div class="d-flex justify-content-between flex-nowrap
		align-items-center pt-3 pb-0 mb-3 border-bottom">
        <h1 class="mb-0">
          Scholarship Selection
        </h1>
		<router-link to="/apply" class="btn btn-primary">
			Next
			<span class="badge badge-light">{{selected.length}}</span>
		</router-link>
	</div>
	<p>Select the scholarships you wish to apply for.</p>
	<selectable-scholarship
		v-for="scholarship in scholarships" :key="scholarship.code"
		v-if="scholarship.active"
		v-bind="scholarship"
	>
	</selectable-scholarship>
	<div class="d-flex justify-content-between my-3">
		<router-link to="/" class="btn btn-secondary">Back</router-link>
		<router-link to="/apply" class="btn btn-primary">
			Next
			<span class="badge badge-light">{{selected.length}}</span>
		</router-link>
	</div>
</div>
</template>

<script>
import { mapState } from 'vuex';
import SelectableScholarship from '@/components/SelectableScholarship.vue';

export default {
	name: 'ScholarshipSelect',
	components: {
		SelectableScholarship,
	},
	created() {
		this.$store.dispatch('scholarships/initialize');
	},
	computed: mapState({
		scholarships: state => Array.from(state.scholarships.all.values()),
		selected: state => state.selected_scholarships,
	}),
};
</script>
