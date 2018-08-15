<template>
<div>
	<div class="d-flex justify-content-between flex-nowrap
		align-items-center pt-3 pb-0 mb-3 border-bottom">
    <h1 class="mb-0">
      Student Information
    </h1>
		<router-link to="/select" class="btn btn-primary">Next</router-link>
	</div>
	<p>Fill out as much as you can.</p>
	<form class="mb-4">
		<qualifier-input v-for="qualifier in required"
			:key="qualifier.id"
			:qualifier="qualifier"
			v-model="student.qualifications[qualifier.id]"
		>
		</qualifier-input>

		<div class="card">
			<div class="card card-header">
				<button class="btn btn-link" type="button"
					data-toggle="collapse" data-target="#filters"
					aria-expanded="false" aria-controls="filters">
					Scholarship Filters
				</button>
			</div>
			<div class="collapse multi-collapse" id="filters">
				<div class="card card-body">
					<qualifier-input v-for="qualifier in optional"
						:key="qualifier.id"
						:qualifier="qualifier"
						v-model="student.qualifications[qualifier.id]"
					>
					</qualifier-input>
				</div>
			</div>
		</div>
	</form>
</div>
</template>

<script>
import { mapGetters } from 'vuex';
import QualifierInput from '@/components/QualifierInput.vue';

export default {
	name: 'StudentForm',
	components: {
		QualifierInput,
	},
	computed: {
		student: {
			get() {
				return this.$store.state.student;
			},
			set(val) {
				this.$store.commit('setStudent', val);
			},
		},
		...mapGetters('qualifiers/', [
			'required',
			'optional',
		]),
	},
	data() {
		return {
		};
	},
	created() {
		this.$store.dispatch('qualifiers/initialize');
	},
};
</script>
