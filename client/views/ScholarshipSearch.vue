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
			:disabled="!hasQuery">
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
	<qualifier-input v-for="qualifier in qualifiers"
		:key="qualifier.id"
		:qualifier="qualifier"
		v-model="qualifications[qualifier.name]"
		@input="updateQualifications(qualifications)"
		:invalid="invalid.qualifications[qualifier.name]"
	>
	</qualifier-input>
</form>
</template>

<script>
import { mapState, mapActions } from 'vuex';
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
	},
	computed: {
		...mapState({
			qualifiers: state => Array.from(state.qualifiers.all.values()),
			qualifications: 'qualifications',
			student: 'student',
			invalid: 'invalid',
		}),
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
