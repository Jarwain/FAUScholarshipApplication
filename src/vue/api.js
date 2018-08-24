import axios from 'axios';
import objectToFormData from 'object-to-formdata';

const instance = axios.create({
	baseURL: window.FAUObj.apiUrl,
});

const get = (item) => {
	let request = instance;

	switch (item) {
	case 'qualifiers':
		request = request.get('qualifier/');
		break;
	case 'scholarships':
		request = request.get('scholarship/?active=1');
		break;
	default:
		break;
	}
	return request.then(response => response.data);
};

const submitAnswers = (app) => {
	const data = objectToFormData(app);
	const request = instance;
	return request.post('application/', data);
};

export default { get, submitAnswers };
