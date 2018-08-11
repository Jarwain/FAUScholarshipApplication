<template>
<div role="main" class="container">
	<h2>Student Information</h2>
	<p>Fill out as much as you can.</p>
	<form>
		<div class="form-row">
			<div class="form-group col">
				<label for="first_name">First Name</label>
				<input type="text" class="form-control" name="first_name" placeholder="First name" required
					v-model="student.first_name">
			</div>
			<div class="form-group col">
				<label for="last_name">Last Name</label>
				<input type="text" class="form-control" name="last_name" placeholder="Last name" required
					v-model="student.last_name">
			</div>
		</div>
		<div class="form-row">
			<div class="form-group col">
				<label for="znumber">Z-number</label>
				<input type="text" class="form-control" name="znumber" placeholder="Z12345678" required
					v-model="student.znumber">
			</div>
			<div class="form-group col">
				<label for="email">Email address</label>
				<input type="email" class="form-control" name="email" placeholder="name@fau.edu" required
					v-model="student.email">
			</div>
		</div>
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
	<div class="d-flex justify-content-end my-3">
		<router-link to="/select" class="btn btn-primary">Next</router-link>
	</div>
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
	created() {
		this.$store.dispatch('qualifiers/initialize');
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
};
</script>
