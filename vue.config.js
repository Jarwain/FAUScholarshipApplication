const path = require('path');

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
		? "<?=$data['baseUrl']?>"
		: '/',
	/*pages: {
		application: {
			entry: 'src/vue/application.js',
			filename: '../templates/application/index.phtml',
			template: 'templates/application/layout.html',
		},
	},*/
};
