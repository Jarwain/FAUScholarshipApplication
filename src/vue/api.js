import axios from 'axios';
import config from '../config.json';

const uri = `${config.api}api/`;

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
			`${uri}scholarship/?active=1`,
			{ headers: { Accept: 'application/json' } },
		)
		.then((response) => { cb(response.data); });
};

export default { getQualifiers, getScholarships };
