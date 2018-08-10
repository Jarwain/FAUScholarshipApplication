<template>
<div id="app" role="main" class="container">
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
		<qualifier-input v-for="qualifier in Object.values(qualifiers).filter(e=>(e.props.required))"
			:key="qualifier.id"
			:qualifier="qualifier"
			v-model="student.qualifications[qualifier.id]"
		>
		</qualifier-input>
		<div class="card">
			<div class="card-header">
				<a data-toggle="collapse" href="">
					Scholarship Filters
				</a>
			</div>
			<div class="card-body collapsed">
				test
			</div>
		</div>
	</form>
	<div class="d-flex justify-content-end">
		<router-link to="/select" class="btn btn-primary">Next</router-link>
	</div>
</div>
</template>

<script>
import axios from 'axios';
import QualifierInput from '@/components/QualifierInput.vue';

export default {
	name: 'StudentForm',
	components: {
		QualifierInput,
	},
	created() {
		if (window.FAUobj) {
			this.qualifiers = window.FAUobj.qualifiers;
		} else {
			this.fetchData();
		}
	},
	data() {
		return {
			qualifiers: {},
			student: {
				first_name: '',
				last_name: '',
				znumber: '',
				email: '',
				qualifications: [],
			},
		};
	},
	methods: {
		fetchData() {
			axios
				.get(
					'https://boc22finaid.fau.edu/scholarship/api/qualifier/',
					{ headers: { Accept: 'application/json' } },
				)
				.then((response) => { this.qualifiers = response.data; });
		},
	},
};
</script>
