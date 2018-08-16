<template>
<div>
	<div class="d-flex justify-content-between flex-nowrap
		align-items-center pt-3 pb-0 mb-3 border-bottom">
		<h1 class="mb-0">
			Scholarship Application
		</h1>
		<div>
			<button @click="backHandler" class="btn btn-secondary mr-3">
				{{isFirstCollapse ? 'Scholarship List' : 'Back'}}
			</button>
			<button @click="nextHandler" class="btn btn-primary">
				{{isLastCollapse ? 'Submit' : 'Next'}}
			</button>
		</div>
	</div>
	<p>The application does not save. You may need to reselect your file attachment if you navigate away from this page. Please ensure all information on this page is correct.</p>
	<form>
		<div class="accordion mb-3" id="applicationAccordion">
			<div class="card">
				<div class="card-header" id="studentHeader">
					<h5 class="mb-0">
						<button class="btn btn-link" @click="currentCollapse = 0"
							type="button" data-toggle="collapse"
							:data-target="`#studentBody`"
							aria-expanded="true" aria-controls="studentBody">
							Student Information
						</button>
					</h5>
				</div>
				<div id="studentBody" class="collapse show"
					aria-labelledby="studentHeader" data-parent="#applicationAccordion">
					<div class="card-body">
						<div class="form-row">
							<div class="form-group col">
								<label for="first_name">First Name</label>
								<input type="text" class="form-control" name="first_name" placeholder="First name" required
									v-model="student.first_name" @input="updateStudent">
							</div>
							<div class="form-group col">
								<label for="last_name">Last Name</label>
								<input type="text" class="form-control" name="last_name" placeholder="Last name" required
									v-model="student.last_name" @input="updateStudent">
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col">
								<label for="znumber">Z-number</label>
								<div class="input-group mb-3">
								  <div class="input-group-prepend">
								    <span class="input-group-text">Z</span>
								  </div>
									<input type="text" class="form-control" name="znumber" placeholder="12345678" required
										v-model="student.znumber" @input="updateStudent">
								</div>
							</div>
							<div class="form-group col">
								<label for="email">Email address</label>
								<input type="email" class="form-control" name="email" placeholder="name@fau.edu" required
									v-model="student.email" @input="updateStudent">
							</div>
						</div>
						<qualifier-input v-for="qualifier in required"
							:key="qualifier.id"
							:qualifier="qualifier"
							v-model="student.qualifications[qualifier.id]"
							@input="updateStudent"
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
										v-model="student.qualifications[qualifier.id]"
										@input="updateStudent"
									>
									</qualifier-input>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="card" v-for="(code, idx) in selected" :key="code">
				<div class="card-header" :id="`heading${code}`">
					<h5 class="mb-0">
						<button class="btn btn-link collapsed"
						type="button" @click="currentCollapse = idx + 1" data-toggle="collapse"
						:data-target="`#collapse${code}`"
						aria-expanded="false" aria-controls="`collapse${code}`">
							{{scholarships.get(code).name}}
						</button>
					</h5>
				</div>
				<div :id="`collapse${code}`" class="collapse"
					:aria-labelledby="`heading${code}`" data-parent="#applicationAccordion">
					<div class="card-body">
						<question-input v-for="question in scholarships.get(code).questions"
							:key="code+question.id"
							:question="question"
							:code="code"
							v-model="applications[code][question.id]"
							@input="updateApplication"
						>
						</question-input>
					</div>
				</div>
			</div>
		</div>
	</form>
<!-- 	<question-input v-for="question in scholarships.get(code).questions"
		:key="question.id"
		:question="question"
		v-model="applications[question.id]"
	>
	</question-input> -->
</div>
</template>

<script>
import { mapState, mapGetters } from 'vuex';
import QuestionInput from '@/components/QuestionInput.vue';
import QualifierInput from '@/components/QualifierInput.vue';

export default {
	name: 'ScholarshipApply',
	components: {
		QuestionInput,
		QualifierInput,
	},
	data() {
		return {
			currentCollapse: 0,
		};
	},
	methods: {
		backHandler() {
			if(this.isFirstCollapse){
				router.push({ name: 'list' });
			} else {
				this.currentCollapse--;
				$(this.collapses[this.currentCollapse]).collapse('toggle');
			}
		}
		nextHandler() {
			if(this.isLastCollapse){
				// Submission Verification
			} else {
				this.currentCollapse++;
				$(this.collapses[this.currentCollapse]).collapse('toggle');
			}
		},
		updateApplication(code, question_id, event) {
			this.$store.commit('setApplication', this.applications);
		},
		updateStudent() {
			this.$store.commit('setStudent', this.student);
		},
	},
	computed: {
		isFirstCollapse() {
			return this.currentCollapse === 0;
		},
		isLastCollapse() {
			return this.currentCollapse === this.collapses.length - 1
		},
		collapses() {
			let scholarshipIDs = this.selected.map(e => `#collapse${e}`);
			return ['#studentBody', ...scholarshipIDs];
		},
		...mapState({
			selected: state => state.selected_scholarships,
			scholarships: state => state.scholarships.all,
			qualifiers: state => Array.from(state.qualifiers.all.values()),
			applications: state => state.applications,
		}),
		...mapGetters('qualifiers', [
			'required',
			'optional',
		]),
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
		student: {
			get() {
				return this.$store.state.student;
			},
			set(val) {
				this.$store.commit('setStudent', val);
			},
		},
	},
	created() {
		this.$store.dispatch('qualifiers/initialize');
	},
};
</script>
