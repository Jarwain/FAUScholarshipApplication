module.exports = {
    baseUrl: "<?=$data['baseUrl']?>",
    outputDir: 'dist/public',
    assetsDir: 'vue',
    pages: {
        application_form: {
            entry: 'src/application_form.js',
            filename:'../templates/application_form.phtml'
        },
        //scholarship_select: 'src/scholarship_select.js',
        app: {
            entry: 'src/main.js',
            filename: '../templates/main.phtml'
        }
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