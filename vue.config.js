const path = require('path');
const config = require('./config.json');

module.exports = {
	runtimeCompiler: true,
	configureWebpack: {
		resolve: {
			alias: {
				'@': path.resolve(__dirname, 'src/vue'),
			},
		},
	},
	baseUrl: config.baseUrl,
	pages: {
		application: {
			entry: 'src/vue/application.js',
			filename: 'application.phtml',
			template: 'templates/application.html',
		},
		admin: {
			entry: 'src/vue/admin.js',
			filename: 'admin.phtml',
			template: 'templates/admin.html',
		},
	},
};
