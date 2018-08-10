const path = require('path');
const config = require('./src/config.json');

module.exports = {
	runtimeCompiler: true,
	configureWebpack: {
		resolve: {
			alias: {
				'@': path.resolve(__dirname, 'src/vue'),
			},
		},
	},
	baseUrl: process.env.NODE_ENV === 'production'
		? config.template.baseUrl
		: '/',
	pages: process.env.NODE_ENV === 'production'
		? {
			application: {
				entry: 'src/vue/application.js',
				filename: 'application.phtml',
				template: 'templates/application/layout.html',
			},
		}
		: undefined,
};
