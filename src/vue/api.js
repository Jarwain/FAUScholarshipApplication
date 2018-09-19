import axios from 'axios';
import objectToFormData from 'object-to-formdata';

const instance = axios.create({
	baseURL: window.FAUObj.apiUrl,
});

const get = (item, params = null) => {
	let request = instance;

	switch (item) {
	case 'questions':
		request = request.get('question/', { params });
		break;
	case 'qualifiers':
		request = request.get('qualifier/', { params });
		break;
	case 'scholarships':
		request = request.get('scholarship/', { params });
		break;
	default:
		break;
	}
	return request.catch((err) => { console.log(err.response); })
		.then(response => response.data);
};

const submitAnswers = (app) => {
	const data = objectToFormData(app);
	const request = instance;
	return request.post('application/', data).then(response => response.data);
};

export default { get, submitAnswers };
