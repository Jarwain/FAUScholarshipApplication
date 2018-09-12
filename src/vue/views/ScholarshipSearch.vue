<template>
<form action="/list">
	<div class="d-flex justify-content-between flex-nowrap
		align-items-center pt-3 pb-0 mb-3 border-bottom">
		<h1 class="mb-0">
			Scholarship Search
		</h1>
		<div class="btn-group">
			<a href="/list" class="btn btn-secondary" role="button">
				Skip
			</a>
			<button name="search" value="true" class="btn btn-primary"
			:disabled="!hasQuery" @click="onClick">
				Search
			</button>
		</div>
	</div>
	<p>Fill out as much as you can.</p>
	<text-input class="col" type="text" prepend="Z"
	question="Z-number" placeholder="12345678" name="znumber"
	v-model="student.znumber" @input="updateStudent(student)"
	:invalid="invalid.student.znumber">
	</text-input>
	<qualifier-input v-for="qualifier in required"
		:key="qualifier.id"
		:qualifier="qualifier"
		v-model="qualifications[qualifier.name]"
		@input="updateQualifications(qualifications)"
		:invalid="invalid.qualifications[qualifier.name]"
	>
	</qualifier-input>
	<div class="card">
		<div class="card card-header">
			<button class="btn btn-link" type="button"
				data-toggle="collapse" data-target="#filters"
				aria-expanded="false" aria-controls="filters">
				Optional Qualifications
			</button>
		</div>
		<div class="collapse multi-collapse" id="filters">
			<div class="card card-body">
				<qualifier-input v-for="qualifier in optional"
					:key="qualifier.id"
					:qualifier="qualifier"
					v-model="qualifications[qualifier.name]"
					@input="updateQualifications(qualifications)"
					:invalid="invalid.qualifications[qualifier.name]"
				>
				</qualifier-input>
			</div>
		</div>
	</div>
</form>
</template>

<script>
import { mapState, mapGetters, mapActions } from 'vuex';
import QualifierInput from '@/components/QualifierInput.vue';
import TextInput from '@/components/TextInput.vue';

export default {
	name: 'ScholarshipSearch',
	components: {
		QualifierInput,
		TextInput,
	},
	methods: {
		...mapActions([
			'updateStudent',
			'updateQualifications',
		]),
		onClick() {
			this.$set(this.student, 'znumber', `Z${this.student.znumber}`);
			this.updateStudent(this.student);
		},
	},
	computed: {
		...mapState({
			qualifications: 'qualifications',
			student: 'student',
			invalid: 'invalid',
		}),
		...mapGetters('qualifiers', [
			'required',
			'optional',
		]),
		hasQuery() {
			return this.student.znumber
				|| Object.keys(this.qualifications).length;
		},
	},
	data() {
		return {
		};
	},
	created() {
		this.$store.dispatch('qualifiers/initialize');
		this.$store.dispatch('updateQualifications', this.qualifications);
	},
};
</script>
