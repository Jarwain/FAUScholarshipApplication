import axios from 'axios';
import objectToFormData from 'object-to-formdata';
import config from '../config.json';

const instance = axios.create({
	baseURL: `${config.api}api/`,
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
	console.log(data);
	const request = axios;
	return request.post('http://localhost:8080/api/application/', data);
};

export default { get, submitAnswers };
