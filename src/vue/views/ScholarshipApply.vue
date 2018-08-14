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
	<question-input v-for="question in questions"
		:key="question.id"
		:question="question"
		v-model="answers[question.id]"
	>
	</question-input>
	<div class="d-flex justify-content-between my-3">
		<router-link to="/select" class="btn btn-secondary">Back</router-link>
		<router-link to="/submit" class="btn btn-primary">Next</router-link>
	</div>
</div>
</template>

<script>
import { mapState } from 'vuex';
import QuestionInput from '@/components/QuestionInput.vue';

export default {
	name: 'ScholarshipApply',
	components: {
		QuestionInput,
	},
	computed: {
		...mapState({
			selected: state => state.selected_scholarships,
			scholarships: state => state.scholarships.all,
		}),
		questions() {
			return this.selected.reduce((a, e) => {
				this.scholarships.get(e).questions.forEach((question) => {
					if (!(question in a)) {
						a[question.id] = question;
					}
				});
				return a;
			}, {});
		},
		answers: {
			get() {
				return this.$store.state.answers;
			},
			set(val) {
				this.$store.commit('setAnswer', val);
			},
		},
	},
};
</script>
