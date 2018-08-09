const path = require('path');

module.exports = {
	configureWebpack: {
		resolve: {
			alias: {
				'@': path.resolve(__dirname, 'src/vue'),
			},
		},
	},
	baseUrl: "<?=$data['baseUrl']?>",
	pages: {
		application: {
			entry: 'src/vue/application.js',
			template: 'templates/application/layout.html',
			filename: '../templates/application/index.phtml',
		},
	},
};
