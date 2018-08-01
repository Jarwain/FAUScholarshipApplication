const createScholarship = ({
	id = null,
	code = "",
	name = "",
	description = "",
	active = false,
	max = 0,
	questions = [],
	requirements = []
} = {}) => ({
	id,
	code,
	name,
	description,
	active,
	max,
	questions: questions.map(q => q.id),
	requirements/*: Object.keys(requirements).reduce(function(a, e){
		a[e] = requirements[e].map((el)=>{el.qualifier = el.qualifier.id; return el;});
		return a;
	})*/
});



var editor = new Vue({
	el: '#editor',
	data: {
		scholarship: createScholarship(sch),
		questions,
		qualifiers,
		categoryCursor: '',
		requirementCursor: {
			category: '',
			qualifierId: 0,
			valid: []
		}
	},
	computed: {
		addOrDeleteCategory(){
			return typeof this.scholarship.requirements[this.categoryCursor] == "undefined" || this.categoryCursor == '';
		},
		requirementQualifier(){
			return this.qualifiers[this.requirementCursor.qualifierId] || false;
		}
	},
	methods: {
		category(){
			if(this.addOrDeleteCategory){
				this.scholarship.requirements[this.categoryCursor] = [];
			} else {
				delete this.scholarship.requirements[this.categoryCursor];
			}
			this.categoryCursor = '';
		},
		initializeRequirementModal(req){
			this.requirementCursor.qualifierId = req.qualifier.id;
			this.requirementCursor.valid = req.valid;
		}/*,
		addRequirement(){
			let requirement = {
				category: this.requirementCursor.category,
				qualifier: this.requirementCursor.qualifierId,
				valid: this.requirementCursor.valid
			};
			this.scholarship.requirements[this.requirementCursor.category].push(requirement);
		}*/
	}
});