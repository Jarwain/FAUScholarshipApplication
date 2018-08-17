import axios from 'axios';
import config from '../config.json';

const baseUrl = `${config.api}api/`;
const getItem = (item) => {
	let request = axios;

	switch (item) {
	case 'qualifiers':
		request = request.get(baseUrl + 'qualifier/');
		break;
	case 'scholarships':
		request = request.get(baseUrl + 'scholarship/?active=1');
		break;
	default:
		break;
	}
	return request.then((response) => {
		console.log(response);
		return response.data;
	});
};

/*const getQualifiers = (cb) => {
	return axios
		.get(
			`${uri}qualifier/`,
			{ headers: { Accept: 'application/json' } },
		)
		.then((response) => { cb(response.data); });
};

const getScholarships = (cb) => {
	return axios
		.get(
			`${uri}scholarship/?active=1`,
			{ headers: { Accept: 'application/json' } },
		)
		.then((response) => { cb(response.data); });
};*/

export default { getItem/*, getQualifiers, getScholarships*/ };
