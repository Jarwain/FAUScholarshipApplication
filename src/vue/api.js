import axios from 'axios';
import config from '../config.json';

const base = config.template.baseUrl ? `${config.template.baseUrl}/` : '';
const uri = `${config.api}${base}api/`;

const getQualifiers = (cb) => {
	axios
		.get(
			`${uri}qualifier/`,
			{ headers: { Accept: 'application/json' } },
		)
		.then((response) => { cb(response.data); });
};

const getScholarships = (cb) => {
	axios
		.get(
			`${uri}scholarship/`,
			{ headers: { Accept: 'application/json' } },
		)
		.then((response) => { cb(response.data); });
};

export default { getQualifiers, getScholarships };
