<template>
<div role="main" class="container">
	<div class="d-flex justify-content-between flex-nowrap
		align-items-center pt-3 pb-0 mb-3 border-bottom">
        <h1 class="mb-0">
          Scholarship Application
        </h1>
<!-- 		<router-link to="/apply" class="btn btn-primary">
			Next
		</router-link> -->
	</div>
	<div v-for="code in selected" :key="code">
		{{scholarships.get(code)}}
	</div>
	<div class="d-flex justify-content-between my-3">
		<router-link to="/select" class="btn btn-secondary">Back</router-link>
		<router-link to="/submit" class="btn btn-primary">Next</router-link>
	</div>
</div>
</template>

<script>
import { mapState } from 'vuex';

export default {
	name: 'ScholarshipApply',
	components: {
	},
	computed: mapState({
		selected: state => state.selected_scholarships,
		scholarships: state => state.scholarships.all,
	}),
};
</script>
