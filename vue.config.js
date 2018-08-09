module.exports = {
	baseUrl: "<?=$data['baseUrl']?>",
	outputDir: 'public',
	assetsDir: 'vue',
	pages: {
		application: {
			entry: 'src/vue/application.js',
			template: 'templates/application/layout.html',
			filename:'../templates/application/index.phtml'
		},
	}
}

/*
So the idea is
Build a page.phtml into the /templates folder that slim pulls from to render stuff
Create a layout.phtml that works basically the same as current, and parts where it matters.
We can ditch the ViewBuilders doing this
Just need "Object Import"

Assets go into /public/vue/js|css
*/