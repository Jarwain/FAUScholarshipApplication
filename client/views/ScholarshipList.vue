<template>
<div>
	<div class="d-flex justify-content-between flex-nowrap
		align-items-center pt-3 pb-0 mb-3 border-bottom">
		<h1 class="mb-0">
			Scholarships
		</h1>
		<div>
			<router-link to="/search" class="btn btn-secondary mr-3">
				Search
			</router-link>
			<router-link to="/apply" class="btn btn-primary"
			:class="{disabled: !selected.length}">
				Continue
				<span class="badge badge-light">{{selected.length}}</span>
			</router-link>
		</div>
	</div>
	<p>Click the scholarship name to read more about it. Press 'Apply' to select the scholarships you wish to apply for, then press continue. </p>
	<p v-if="search">Eligible scholarships may have extra requirements. Eligibility does not guarantee acceptance. </p>
	<ul v-if="search" class="nav nav-pills nav-fill">
		<li class="nav-item">
			<a class="nav-link" :class="{active: activeList == 0}"
			@click="setActiveList(0)" href="#">All</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" :class="{active: activeList == 1}" @click="setActiveList(1)" href="#">Eligible</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" :class="{active: activeList == 2}" @click="setActiveList(2)" href="#">Ineligible</a>
		</li>
	</ul>
	<selectable-scholarship
		v-for="scholarship in scholarshipList.slice((page-1)*numPerPage,page*numPerPage)"
		:key="scholarship.code"
		v-bind="scholarship"
		:checked="selected.indexOf(scholarship.code) !== -1"
		@toggle="$store.commit('toggleSelectedScholarship', scholarship.code);"
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
import { mapState, mapGetters } from 'vuex';
import SelectableScholarship from '@/components/SelectableScholarship.vue';

export default {
	name: 'ScholarshipList',
	components: {
		SelectableScholarship,
	},
	data() {
		return {
			page: 1,
			numPerPage: 10,
			activeList: 0,
		};
	},
	methods: {
		setActiveList(val) {
			this.activeList = val;
			this.page = 1;
		},
	},
	computed: {
		scholarshipList() {
			switch (this.activeList) {
			case 1:
				return this.eligible;
			case 2:
				return this.ineligible;
			default:
				return this.scholarships;
			}
		},
		numPages() {
			return Math.ceil(this.scholarshipList.length / this.numPerPage);
		},
		...mapGetters({
			eligible: 'scholarships/eligible',
			ineligible: 'scholarships/ineligible',
		}),
		...mapState({
			search: 'search',
			selected: state => state.selected_scholarships,
			scholarships: state => Array.from(state.scholarships.all.values()),
		}),
	},
	created() {
		const { query } = this.$route;
		if (query.search) {
			if (!query.znumber
				|| Object.values(query).filter(e => e).length > 2) {
				this.$store.commit('search');
			}
			if (query.znumber && query.znumber.toUpperCase()[0] !== 'Z') {
				query.znumber = 'Z'.concat(query.znumber);
			}
		}
		this.$store.dispatch('questions/initialize');
		this.$store.dispatch('qualifiers/initialize');
		this.$store.dispatch('scholarships/initialize', query);
	},
};
</script>
