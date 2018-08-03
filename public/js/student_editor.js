const createStudent = ({
	znumber = "",
	first_name = "",
	last_name = "",
	email = "",
	qualifications = [],
} = {}) => ({
	znumber,
	first_name,
	last_name,
	email,
	qualifications
});

var studentForm = new Vue({
	el: '#studentForm',
	data: {
		student: createStudent(student),
		qualifiers,
	},
	computed: {
		
	},
	methods: {
		
	}
});