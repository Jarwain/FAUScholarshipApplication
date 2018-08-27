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
	<p>
		Do not navigate away from this page. The application does not save. <br/>
		Please ensure all information on this page is correct before submitting.
	</p>
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
							<text-input class="col" type="text"
								question="First Name" name="first_name"
								:constraints="studentConstraints.first_name"
								v-model="student.first_name" @input="updateStudent(student)"
								@valid="valid.student.first_name = $event"
							>
							</text-input>
							<text-input class="col" type="text"
								question="Last Name" name="last_name"
								:constraints="studentConstraints.last_name"
								v-model="student.last_name" @input="updateStudent(student)"
								@valid="valid.student.last_name = $event"
							>
							</text-input>
						</div>
						<div class="form-row">
							<text-input class="col" type="text" prepend="Z"
								question="Z-number" placeholder="12345678" name="znumber"
								:constraints="studentConstraints.znumber"
								v-model="student.znumber" @input="updateStudent(student)"
								@valid="valid.student.znumber = $event"
							>
							</text-input>
							<text-input class="col" type="email"
								question="Email Address" placeholder="jdoe2018@fau.edu" name="email"
								:constraints="studentConstraints.email"
								v-model="student.email" @input="updateStudent(student)"
								@valid="valid.student.email = $event"
							>
							</text-input>
						</div>
						<qualifier-input v-for="qualifier in required"
							:key="qualifier.id"
							:qualifier="qualifier"
							v-model="qualifications[qualifier.id]"
							@input="updateQualifications(qualifications)"
							@valid="valid.qualifications[qualifier.id] = $event"
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
										v-model="qualifications[qualifier.id]"
										@input="updateQualifications(qualifications)"
										@valid="valid.qualifications[qualifier.id] = $event"
									>
									</qualifier-input>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="card" v-for="(code, idx) in selected" :key="code">
				<div class="card-header d-flex justify-content-between"
				:id="`heading${code}`">
					<h5 class="mb-0">
						<button class="btn btn-link collapsed"
						type="button" @click="currentCollapse = idx + 1" data-toggle="collapse"
						:data-target="`#collapse${code}`"
						aria-expanded="false" aria-controls="`collapse${code}`">
							{{scholarships.get(code).name}}
						</button>
					</h5>
					<button class="btn btn-danger" type="button" v-if="removeCursor != code"
					@click="removeCursor = code">
						Remove
					</button>
					<div class="btn-group" role="group" v-if="removeCursor == code">
						<button type="button" class="btn btn-outline-primary" @click="removeCursor = null">
							No Wait
						</button>
						<button type="button" class="btn btn-warning" @click="removeScholarship(code)">
							I'm Sure
						</button>
					</div>
				</div>
				<div :id="`collapse${code}`" class="collapse"
				:aria-labelledby="`heading${code}`" data-parent="#applicationAccordion">
					<div class="card-body">
						<question-input v-for="question in scholarships.get(code).questions"
							:key="question.id"
							:question="question"
							:code="code"
							v-model="answers[code][question.id]"
							@input="updateAnswers(answers)"
							@valid="valid.answers[code+question.id] = $event"
						>
						</question-input>
					</div>
				</div>
			</div>
		</div>
	</form>
	<!-- Submission -->
	<div class="modal fade" id="submitModal" tabindex="-1" role="dialog"
	aria-labelledby="submitModalTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="submitModalTitle">Submit Application</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body" v-if="result">
					<h5 class="text-center">
						{{ result.status }}
					</h5>
					<p  v-for="(value, key) in result.message" :key="key">
						<strong v-if="!Number.isInteger(key)">
							{{ key }}:
						</strong>
						{{ value }}
					</p>
				</div>
				<div class="modal-body" v-if="submit && !result">
					<h5 class="text-center">
						Submitting Application... <br/>
						<font-awesome-icon icon="spinner" />
					</h5>
				</div>
				<div class="modal-body" v-if="!submit">
					<h5>Information Release Authorization</h5>
					<p>
						In compliance with the Federal Family Educational Rights and Privacy Act of 1974, Florida Atlantic University (FAU) may not release personally identifiable information from education records without the consent of the student.
					</p>
					<p>
						With this scholarship application, the following information will be released to the Financial Aid Scholarship Committee members:
					</p>
					<ul>
						<li>Grade Point Average (GPA)</li>
						<li>FAU Student ID # (Z#)</li>
					</ul>
					<div v-if="hasVideo">
						<h5>Photo/Video Release Authorization</h5>
						<p>
							I hereby authorize Florida Atlantic University (University) and those acting pursuant to its authority to: (i) record my likeness and/or voice on a video, audio, photographic, digital, electronic or any other medium; (ii) use my name and biographical material in connection with such recordings; and (iii) use, reproduce, exhibit, and/or distribute my name, biographical material, and such recordings in any medium (e.g., print publications, video, internet, etc.) for promotional, advertising, educational, and/or other lawful purposes. I release and waive any claims or rights of compensation or ownership regarding such uses and understand that all such recordings shall remain the property of the University.
						</p>
						<div class="radio">
							<label>
								<input type="radio" name="videoAuth" value="0"
								v-model="student.videoAuth" @input="updateStudent(student)">
								I (Parent/guardian of the student) acknowledge that I understand and agree to the statements above.
							</label>
						</div>
						<div class="radio">
							<label>
								<input type="radio" name="videoAuth" value="1"
								v-model="student.videoAuth" @input="updateStudent(student)">
								I certify that I am 18 years of age or older and that I understand and agree to the statements above.
							</label>
						</div>
					</div>
					<p>
						By clicking Submit, you agree that all information on this page is correct. <br>
						Inaccurate information <em>will</em> make you ineligible for consideration for your scholarship. <br>
						You will not be able to make any changes to your scholarship application after submission.
					</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary"
					v-if="!submit" @click="submitHandler">
						Submit
					</button>
				</div>
			</div>
		</div>
	</div>
</div>
</template>

<script>
import { mapState, mapGetters, mapActions } from 'vuex';
import QuestionInput from '@/components/QuestionInput.vue';
import QualifierInput from '@/components/QualifierInput.vue';
import TextInput from '@/components/TextInput.vue';

export default {
	name: 'ScholarshipApply',
	components: {
		QuestionInput,
		QualifierInput,
		TextInput,
	},
	data() {
		return {
			currentCollapse: 0,
			removeCursor: null,
			valid: {
				student: {},
				qualifications: {},
				answers: {},
			},
		};
	},
	methods: {
		removeScholarship(code) {
			this.currentCollapse -= 1;
			this.removeCursor = null;
			this.$store.commit('toggleSelectedScholarship', code);
		},
		submitHandler() {
			this.$store.dispatch('submitAnswers');
		},
		backHandler() {
			if (this.isFirstCollapse) {
				this.$router.push({ name: 'list' });
			} else {
				this.currentCollapse -= 1;
				window.$(this.collapses[this.currentCollapse]).collapse('toggle');
			}
		},
		nextHandler() {
			if (this.isLastCollapse && this.valid) {
				window.$('#submitModal').modal('show');
			} else {
				this.currentCollapse += 1;
				window.$(this.collapses[this.currentCollapse]).collapse('toggle');
			}
		},
		...mapActions([
			'updateStudent',
			'updateAnswers',
			'updateQualifications',
			'updateInvalid',
		]),
	},
	computed: {
		isValid() {
			const student = Object.values(this.valid.student).reduce((a, e) =>
				(!a ? a : e), true); // If all values are true

			return student;
		},
		isFirstCollapse() {
			return this.currentCollapse === 0;
		},
		isLastCollapse() {
			return this.currentCollapse === this.collapses.length - 1;
		},
		collapses() {
			const scholarshipIDs = this.selected.map(e => `#collapse${e}`);
			return ['#studentBody', ...scholarshipIDs];
		},
		...mapState({
			qualifiers: state => Array.from(state.qualifiers.all.values()),
			scholarships: state => state.scholarships.all,
			selected: 'selected_scholarships',
			qualifications: 'qualifications',
			answers: 'answers',
			student: 'student',
			studentConstraints: 'studentConstraints',
			submit: 'submit',
			result: 'result',
		}),
		...mapGetters('qualifiers', [
			'required',
			'optional',
		]),
		hasVideo() {
			return this.selected.reduce((a, code) =>
				(a || this.scholarships.get(code).questions.reduce((b, question) =>
					(b || question.type === 'video'), false)
				), false);
		},
	},
	created() {
		this.$store.dispatch('qualifiers/initialize');
	},
};
</script>

<style>
.fa-spinner {
	-webkit-animation-name: spin;
		-webkit-animation-duration: 500ms;
		-webkit-animation-iteration-count: infinite;
		-webkit-animation-timing-function: linear;
		-moz-animation-name: spin;
		-moz-animation-duration: 500ms;
		-moz-animation-iteration-count: infinite;
		-moz-animation-timing-function: linear;
		-ms-animation-name: spin;
		-ms-animation-duration: 500ms;
		-ms-animation-iteration-count: infinite;
		-ms-animation-timing-function: linear;

		animation-name: spin;
		animation-duration: 500ms;
		animation-iteration-count: infinite;
		animation-timing-function: linear;
}

@-moz-keyframes spin {
		from { -moz-transform: rotate(0deg); }
		to { -moz-transform: rotate(360deg); }
}
@-webkit-keyframes spin {
		from { -webkit-transform: rotate(0deg); }
		to { -webkit-transform: rotate(360deg); }
}
@keyframes spin {
		from {transform:rotate(0deg);}
		to {transform:rotate(360deg);}
}
</style>
