<template>
<div>
	<div class="d-flex justify-content-between flex-nowrap
		align-items-center pt-3 pb-0 mb-3 border-bottom">
		<h1 class="mb-0">
			Scholarship Selection
		</h1>
		<div>
			<router-link to="/" class="btn btn-secondary mr-3">
				Back
			</router-link>
			<router-link to="/apply" class="btn btn-primary">
				Next
				<span class="badge badge-light">{{selected.length}}</span>
			</router-link>
		</div>
	</div>
	<p>Select the scholarships you wish to apply for.</p>
	
	<ul class="nav nav-tabs" id="myTab" role="tablist">
		<li class="nav-item">
			<a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">All</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Eligible</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Ineligible</a>
		</li>
	</ul>
	<div class="tab-content" id="myTabContent">
		<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
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
			<selectable-scholarship
				v-for="scholarship in scholarships.slice((page-1)*numPerPage,page*numPerPage)"
				:key="scholarship.code"
				v-bind="scholarship"
			>
			</selectable-scholarship>
		</div>
		<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
			<selectable-scholarship
				v-for="scholarship in qualifying.pass"
				:key="scholarship.code"
				v-bind="scholarship"
			>
			</selectable-scholarship>
		</div>
		<div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
			<selectable-scholarship
				v-for="scholarship in qualifying.fail"
				:key="scholarship.code"
				v-bind="scholarship"
			>
			</selectable-scholarship>
		</div>
	</div>

</div>
</template>

<script>
import { mapState, mapGetters } from 'vuex';
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
		...mapGetters({
			scholarships: 'scholarships/categorizedRequirements',
			qualifying: 'scholarships/qualifying',
		}),
		...mapState({
			selected: state => state.selected_scholarships,
			scholarships: state => Array.from(state.scholarships.all.values()),
		}),
	},
	created() {
		this.$store.dispatch('qualifiers/initialize');
		this.$store.dispatch('scholarships/initialize');
	},
};
</script>
