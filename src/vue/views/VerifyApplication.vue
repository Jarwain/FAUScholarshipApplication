<template>
<div>
	<div class="d-flex justify-content-between flex-nowrap
		align-items-center pt-3 pb-0 mb-3 border-bottom">
    <h1 class="mb-0">
      Verify Application
    </h1>
    <div>
		<router-link to="/apply" class="btn btn-secondary mr-3">
			Back
		</router-link>
		<router-link to="/submit" class="btn btn-primary">
			Submit
		</router-link>
		</div>
	</div>
	<student v-bind="student" class="mb-3"></student>
	<div class="accordion mb-3" id="applicationAccordion">
		<div class="card" v-for="(code, idx) in selected" :key="code">
			<div class="card-header" :id="`heading${code}`">
				<h5 class="mb-0">
					<button class="btn btn-link" :class="{show: idx !== 0}"
						type="button" data-toggle="collapse"
						:data-target="`#collapse${code}`"
						aria-expanded="true" aria-controls="`collapse${code}`">
						{{scholarships.get(code).name}}
					</button>
				</h5>
			</div>
			<div :id="`collapse${code}`" class="collapse" :class="{show: idx === 0}"
				:aria-labelledby="`heading${code}`" data-parent="#applicationAccordion">
				<div class="card-body">
					<div v-for="question in scholarships.get(code).questions"
						:key="code+question.id">
					  <h6><strong>{{question.question}}</strong></h6>
					  <p>{{answers[code][question.id]}}</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</template>

<script>
import { mapState } from 'vuex';
import Student from '@/components/Student.vue';

export default {
	name: 'VerifyApplication',
	components: {
		Student,
	},
	computed: {
		...mapState({
			selected: state => state.selected_scholarships,
			scholarships: state => state.scholarships.all,
			answers: 'answers',
			student: 'student',
		}),
	},
};
</script>
