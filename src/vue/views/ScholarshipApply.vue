<template>
<div>
	<div class="d-flex justify-content-between my-3">
		<router-link to="/" class="btn btn-secondary">Back</router-link>
		<router-link to="/apply" class="btn btn-primary">Next</router-link>
	</div>
</div>
</template>

<script>
import { mapState } from 'vuex';

export default {
	name: 'ScholarshipApply',
	components: {
	},
	computed: mapState([
		'selected_scholarships',
	]),
};
</script>
