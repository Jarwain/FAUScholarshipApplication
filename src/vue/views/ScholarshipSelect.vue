<template>
<div>
	<selectable-scholarship v-for="(scholarship, code) in scholarships" :key="code"
		v-if="scholarship.active"
		v-bind="scholarship"
	>
	</selectable-scholarship>
	<div class="d-flex justify-content-between my-3">
		<router-link to="/" class="btn btn-secondary">Back</router-link>
		<router-link to="/apply" class="btn btn-primary">Next</router-link>
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
		this.$store.dispatch('getAllScholarships');
	},
	computed: mapState([
		'scholarships',
	]),
};
</script>
