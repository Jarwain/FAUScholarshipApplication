<template>
<div>
	<div class="d-flex justify-content-between flex-nowrap
		align-items-center pt-3 pb-0 mb-3 border-bottom">
		<h1 class="mb-0">
			Scholarship Application
		</h1>
		<div>
			<router-link :to="{ name: 'list' }" class="btn btn-secondary mr-3">
				Scholarship List
			</router-link>
			<div class="btn-group" role="group">
				<button v-if="!isFirstCollapse" @click="backHandler" class="btn btn-secondary">
					Back
				</button>
				<button @click="nextHandler" class="btn btn-primary">
					{{isLastCollapse ? 'Submit' : 'Next'}}
				</button>
			</div>
		</div>
	</div>
	<p>
		Do not navigate away from this page. The application does not save. <br/>
		Please ensure all information on this page is correct before submitting.
	</p>
	<div class="accordion mb-3" id="applicationAccordion">
		<div class="card"
		:class="{[invalid.student || invalid.qualifications ?
			'border-danger' : 'border-success']: validated.student}"
		>
			<div id="studentHeader"
			class="card-header d-flex justify-content-between"
			:class="{[invalid.student || invalid.qualifications ?
				'border-danger' : 'border-success']: validated.student}"
			>
				<h5 class="mb-0">
					<button class="btn btn-link" @click="currentCollapse = 0"
						type="button" data-toggle="collapse"
						data-target="#studentBody"
						aria-expanded="true" aria-controls="studentBody">
						Student Information
						<span v-if="validated.student" class="badge"
						:class="[invalid.student || invalid.qualifications ?
							'badge-danger' : 'badge-success']">
							{{invalid.student || invalid.qualifications ? 'Error' : 'Valid'}}
						</span>
					</button>
				</h5>
			</div>
			<div id="studentBody" class="collapse show"
				aria-labelledby="studentHeader" data-parent="#applicationAccordion">
				<div class="card-body">
					<div class="form-row">
						<text-input class="col" type="text"
							question="First Name" name="first_name"
							v-model="student.first_name" @input="updateStudent(student)"
							:invalid="invalid.student.first_name" :validated="validated.student">
						</text-input>
						<text-input class="col" type="text"
						question="Last Name" name="last_name"
						v-model="student.last_name" @input="updateStudent(student)"
						:invalid="invalid.student.last_name" :validated="validated.student">
						</text-input>
					</div>
					<div class="form-row">
						<text-input class="col" type="text" prepend="Z"
						question="Z-number" placeholder="12345678" name="znumber"
						v-model="student.znumber" @input="updateStudent(student)"
						:invalid="invalid.student.znumber" :validated="validated.student">
						</text-input>
						<text-input class="col" type="email"
						question="Email Address" placeholder="jdoe2018@fau.edu" name="email"
						v-model="student.email" @input="updateStudent(student)"
						:invalid="invalid.student.email" :validated="validated.student">
						</text-input>
					</div>
					<qualifier-input v-for="qualifier in required"
						:key="qualifier.id"
						:qualifier="qualifier"
						v-model="qualifications[qualifier.name]"
						@input="updateQualifications(qualifications)"
						:invalid="invalid.qualifications[qualifier.name]"
						:validated="validated.student"
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
									:validated="validated.student"
								>
								</qualifier-input>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="card" v-for="(code, idx) in selected" :key="code"
		:class="{[invalid.answers[code] ?
			'border-danger' : 'border-success']: validated.answers[code]}"
		>
			<div :id="`heading${code}`"
			class="card-header d-flex justify-content-between"
			:class="{[invalid.answers[code] ?
				'border-danger' : 'border-success']: validated.answers[code]}"
			>
				<h5 class="mb-0">
					<button class="btn btn-link collapsed"
					type="button" @click="currentCollapse = idx + 1" data-toggle="collapse"
					:data-target="`#collapse${code}`"
					aria-expanded="false" aria-controls="`collapse${code}`">
						{{scholarships.get(code).name}}
						<span v-if="validated.answers[code]" class="badge"
						:class="[invalid.answers[code] ?
							'badge-danger' : 'badge-success']">
							{{invalid.answers[code] ? 'Error' : 'Valid'}}
						</span>
					</button>
				</h5>
				<button class="btn btn-danger" type="button"
				v-else-if="currentCollapse <= idx && removeCursor != code"
				@click="removeCursor = code">
					Remove
				</button>
				<div class="btn-group" role="group" v-else-if="removeCursor == code">
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
					<question-input v-for="question_id in scholarships.get(code).questions"
						:key="question_id"
						:question="questions.get(question_id)"
						:code="code"
						v-model="answers[code][question_id]"
						@input="updateAnswers(answers)"
						:invalid="invalid.answers[code][question_id]"
						:validated="validated.answers[code]"
					>
					</question-input>
				</div>
			</div>
		</div>
	</div>
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
				<template v-if="submit">
					<div class="modal-body" v-if="!result">
						<h5 class="text-center">
							Submitting... <br/>
							<font-awesome-icon icon="spinner" />
						</h5>
					</div>
					<div class="modal-body" v-else-if="!result.status">
						<h5>
							Error!
						</h5>
						<p>
							{{result.message}}
						</p>
					</div>
					<div class="modal-body" v-else>
						<h5>
							Applications Submitted:
						</h5>
						<p>
							<span v-for="(value, key) in result.message" :key="key"
						:class="[value.status ? 'text-success' : 'text-danger']">
								<strong>
									{{ scholarships.get(key).name }}:
								</strong>
								{{ value.message }} <br/>
							</span>
						</p>
					</div>
				</template>
				<div class="modal-body" v-else>
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
						<fieldset class="form-group">
							<div class="form-check">
								<input class="form-check-input" type="radio"
								name="videoAuth" value="0" required
								:class="{[student.videoAuth === null ? 'is-invalid' : 'is-valid']: authRequired}"
								v-model="student.videoAuth" @input="updateStudent(student)">
								<label>
									I (Parent/guardian of the student) acknowledge that I understand and agree to the statements above.
								</label>
							</div>
							<div class="form-check">
								<input class="form-check-input" type="radio"
								name="videoAuth" value="1" required
								:class="{[student.videoAuth === null ? 'is-invalid' : 'is-valid']: authRequired}"
								v-model="student.videoAuth" @input="updateStudent(student)">
								<label>
									I certify that I am 18 years of age or older and that I understand and agree to the statements above.
								</label>
								<div v-if="authRequired" class="invalid-feedback">
									Authorization is required.
								</div>
							</div>
						</fieldset>
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
					@click="submitHandler">
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
			validated: {
				student: false,
				answers: {},
			},
			authRequired: false,
		};
	},
	methods: {
		showAllValidation() {
			this.validated.student = true;
			Object.keys(this.validated.answers).forEach((e) => {
				this.validated.answers[e] = true;
			});
		},
		removeScholarship(code) {
			this.currentCollapse -= 1;
			this.removeCursor = null;
			this.$store.commit('toggleSelectedScholarship', code);
		},
		submitHandler() {
			if (this.hasVideo && this.student.videoAuth === null) {
				this.authRequired = true;
			} else {
				this.$store.dispatch('submitAnswers');
			}
		},
		backHandler() {
			this.currentCollapse -= this.currentCollapse ? 1 : 0;
			window.$(this.collapses[this.currentCollapse]).collapse('toggle');
		},
		nextHandler(event) {
			if (this.isFirstCollapse) {
				// Show Student Validation
				this.validated.student = true;
			} else {
				// Show Scholarship Validation
				const code = this.selected[this.currentCollapse - 1];
				this.validated.answers[code] = true;
			}
			// Move Student into next section
			if (!this.isLastCollapse) {
				this.currentCollapse += 1;
				window.$(this.collapses[this.currentCollapse]).collapse('toggle');
			} else {
				// Try to submit!
				this.showAllValidation();
				if (this.isValid) {
					window.$('#submitModal').modal('show');
				} else {
					event.target.classList.toggle('headShake');
				}
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
			return !this.invalid.student
				&& !this.invalid.qualifications
				&& Object.values(this.invalid.answers).every(e => !e);
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
			scholarships: state => state.scholarships.all,
			questions: state => state.questions.all,
			selected: 'selected_scholarships',
			qualifications: 'qualifications',
			answers: 'answers',
			student: 'student',
			studentConstraints: 'studentConstraints',
			submit: 'submit',
			result: 'result',
			invalid: 'invalid',
		}),
		...mapGetters('qualifiers', [
			'required',
			'optional',
		]),
		...mapGetters('questions', [
			'video',
		]),
		hasVideo() {
			return this.selected
				.some(code => this.scholarships.get(code).questions
					.some(q => this.questions.get(q).type === 'video'));
		},
	},
	created() {
		this.$store.dispatch('updateInvalid');
		this.selected.forEach((e) => {
			this.$set(this.validated.answers, e, false);
		});
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

@-webkit-keyframes headShake {
  0% {
    -webkit-transform: translateX(0);
    transform: translateX(0);
  }

  6.5% {
    -webkit-transform: translateX(-6px) rotateY(-9deg);
    transform: translateX(-6px) rotateY(-9deg);
  }

  18.5% {
    -webkit-transform: translateX(5px) rotateY(7deg);
    transform: translateX(5px) rotateY(7deg);
  }

  31.5% {
    -webkit-transform: translateX(-3px) rotateY(-5deg);
    transform: translateX(-3px) rotateY(-5deg);
  }

  43.5% {
    -webkit-transform: translateX(2px) rotateY(3deg);
    transform: translateX(2px) rotateY(3deg);
  }

  50% {
    -webkit-transform: translateX(0);
    transform: translateX(0);
  }
}

@keyframes headShake {
  0% {
    -webkit-transform: translateX(0);
    transform: translateX(0);
  }

  6.5% {
    -webkit-transform: translateX(-6px) rotateY(-9deg);
    transform: translateX(-6px) rotateY(-9deg);
  }

  18.5% {
    -webkit-transform: translateX(5px) rotateY(7deg);
    transform: translateX(5px) rotateY(7deg);
  }

  31.5% {
    -webkit-transform: translateX(-3px) rotateY(-5deg);
    transform: translateX(-3px) rotateY(-5deg);
  }

  43.5% {
    -webkit-transform: translateX(2px) rotateY(3deg);
    transform: translateX(2px) rotateY(3deg);
  }

  50% {
    -webkit-transform: translateX(0);
    transform: translateX(0);
  }
}

.headShake {
  -webkit-animation-timing-function: ease-in-out;
  animation-timing-function: ease-in-out;
  -webkit-animation-name: headShake;
  animation-name: headShake;

   -webkit-animation-duration: 1s;
  animation-duration: 1s;
  -webkit-animation-fill-mode: both;
animation-fill-mode: both;
}
</style>
