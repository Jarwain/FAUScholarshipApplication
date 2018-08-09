module.exports = {
	baseUrl: "<?=$data['baseUrl']?>",
	pages: {
		application: {
			entry: 'src/vue/application.js',
			template: 'templates/application/layout.html',
			filename: '../templates/application/index.phtml',
		},
	},
};
