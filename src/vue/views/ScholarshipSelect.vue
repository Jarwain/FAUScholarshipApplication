<template>
<div role="main" class="container">
	<div class="d-flex justify-content-between flex-nowrap
		align-items-center pt-3 pb-0 mb-3 border-bottom">
		<h1 class="mb-0">
			Scholarship Selection
		</h1>
		<router-link to="/" class="btn btn-secondary">
			Back
		</router-link>
		<router-link to="/apply" class="btn btn-primary">
			Next
			<span class="badge badge-light">{{selected.length}}</span>
		</router-link>
	</div>
	<p>Select the scholarships you wish to apply for.</p>
	<selectable-scholarship
		v-for="scholarship in scholarships.slice((page-1)*numPerPage,page*numPerPage)"
		:key="scholarship.code"
		v-bind="scholarship"
	>
	</selectable-scholarship>
	<nav aria-label="Scholarship Pagination">
		<ul class="pagination justify-content-center">
			<li class="page-item" :class="{ disabled: page === 1}">
				<a class="page-link" @click="page--">
					<span aria-hidden="true">&laquo;</span>
					<span class="sr-only">Previous</span>
				</a>
			</li>
			<li v-for="i in numPages" :key="i"
				class="page-item" :class="{ active: page === i}">
				<a class="page-link" @click="page = i">{{i}}</a>
			</li>
			<li class="page-item" :class="{ disabled: page === numPages}">
				<a class="page-link" @click="page++">
					<span aria-hidden="true">&raquo;</span>
					<span class="sr-only">Next</span>
				</a>
			</li>
		</ul>
	</nav>
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
	data() {
		return {
			page: 1,
			numPerPage: 10,
		};
	},
	computed: {
		numPages() {
			return Math.ceil(this.scholarships.length / this.numPerPage);
		},
		...mapState({
			scholarships: state => Array.from(state.scholarships.all.values())
				.filter(e => e.active && e.app_count < e.max),
			selected: state => state.selected_scholarships,
		}),
	},
	created() {
		this.$store.dispatch('scholarships/initialize');
	},
};
</script>
