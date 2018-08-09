Vue.component('SelectScholarship', {
	props: {
		code: {
			type: String,
			required: true
		},
		name: {
			type: String,
			required: true
		},
		description: {
			type: String,
			required: true
		},
		max: {
			type: Number,
			required: true
		},
		questions: {
			type: Array,
			required: true
		},
		requirements: {
			type: Array,
			required: true
		}
	},
	computed: {
		localValue: {
			get() {
				return this.selected;
			},
			set(selected) {
				this.$emit('input', selected);
			}
		}
	},
	data() {
		return {
			visibleRequirements: false
		};
	},
	template: '<div class="card mb-4">\n\t\t<div class="card-header">\n\t\t\t{{name}}\n\t\t</div>\n\t\t<div class="card-body">\n\t\t\t<p class="card-text">\n\t\t\t\t{{description}}\n\t\t\t</p>\n\t\t</div>\n\t\t<div v-if="requirements.length > 0" class="card-footer text-muted">\n\t\t\t<a data-toggle="collapse" href="#req_' + code + '">\n\t\t\t\t{{visibleRequirements ? \'Hide\' : \'View\'}} Requirements\n\t\t\t</a>\n\t\t\t<div class="collapse multi-collapse" id="req_' + code + '">\n\t\t\t\t<p>\n\t\t\t\t\t{{requirements}}\n\t\t\t\t</p>\n\t\t\t</div>\n\t\t</div>\n\t</div>'
});