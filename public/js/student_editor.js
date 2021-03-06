const createStudent = ({
	znumber = "",
	first_name = "",
	last_name = "",
	email = "",
	qualifications = {}
} = {}) => ({
	znumber,
	first_name,
	last_name,
	email,
	qualifications
});

var studentForm = new Vue({
	el: '#studentForm',
	data() {
		return {
			student: createStudent(student),
			qualifiers
		};
	},
	methods: {}
});