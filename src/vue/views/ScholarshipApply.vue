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
							<div class="form-group col">
								<label for="first_name">First Name</label>
								<input type="text" class="form-control" name="first_name"
								placeholder="First name" required
								v-model="student.first_name" @input="updateStudent(student)"
								:class="{
									'is-invalid':invalid.student && invalid.student.first_name,
									'is-valid':invalid.student != null && !invalid.student.first_name,
								}">
								<div v-if="invalid.student && invalid.student.first_name"
								class="invalid-feedback">
									{{ invalid.student.first_name[0] }}
								</div>
							</div>
							<div class="form-group col">
								<label for="last_name">Last Name</label>
								<input type="text" class="form-control" name="last_name"
								placeholder="Last name" required
								v-model="student.last_name" @input="updateStudent(student)"
								:class="{
									'is-invalid':invalid.student && invalid.student.last_name,
									'is-valid':invalid.student != null && !invalid.student.last_name,
								}">
								<div v-if="invalid.student && invalid.student.last_name"
								class="invalid-feedback">
									{{ invalid.student.last_name[0] }}
								</div>
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col">
								<label for="znumber">Z-number</label>
								<div class="input-group mb-3">
									<div class="input-group-prepend">
										<span class="input-group-text">Z</span>
									</div>
									<input type="text" class="form-control" name="znumber"
									placeholder="12345678" required
									v-model="student.znumber" @input="updateStudent(student)"
									:class="{
										'is-invalid':invalid.student && invalid.student.znumber,
										'is-valid':invalid.student != null && !invalid.student.znumber,
									}">
									<div v-if="invalid.student && invalid.student.znumber"
									class="invalid-feedback">
										{{ invalid.student.znumber[0] }}
									</div>
								</div>
							</div>
							<div class="form-group col">
								<label for="email">Email address</label>
								<input type="email" class="form-control"
								name="email" placeholder="name@fau.edu" required
								v-model="student.email" @input="updateStudent(student)"
								:class="{
									'is-invalid':invalid.student && invalid.student.email,
									'is-valid':invalid.student != null && !invalid.student.email,
								}">
								<div v-if="invalid.student && invalid.student.email"
								class="invalid-feedback">
									{{ invalid.student.email[0] }}
								</div>
							</div>
						</div>
						<qualifier-input v-for="qualifier in required"
							:key="qualifier.id"
							:qualifier="qualifier"
							v-model="qualifications[qualifier.id]"
							@valid="updateQualifications(qualifications)"
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
										@valid="updateQualifications(qualifications)"
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
					<button class="btn btn-danger" type="button"
						@click="currentCollapse = 0; $store.commit('toggleSelectedScholarship', code)">
							Remove
						</button>
				</div>
				<div :id="`collapse${code}`" class="collapse"
					:aria-labelledby="`heading${code}`" data-parent="#applicationAccordion">
					<div class="card-body">
						<question-input v-for="question in scholarships.get(code).questions"
							:key="code+question.id"
							:question="question"
							:code="code"
							v-model="answers[code][question.id]"
							@valid="updateAnswers(answers)"
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
		]),
	},
	computed: {
		valid() {
			if (this.invalid.student && this.qualifications.invalid) {
				return false;
			}
			return true;
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
			invalid: 'invalid',
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
