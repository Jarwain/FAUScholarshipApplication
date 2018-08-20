# FAU Scholarship Application

## Deployment!
Deployment is basically the same as development. 

Pull the repository via git. Run `npm i` and `php composer.phar i` to ensure all dependencies are downloaded. Run `npm run build` to create a production build of the client. This command will generate the `dist` folder, which holds everything important. The server must have the following folders to function properly: 

- dist (*)
- src (*)
- logs
- templates
- vendor

(*) If it's not a fresh install, just copy these folders over

Be sure that `config.json` has "isProduction": true

Also make sure that the "api" key and the "template" key are accurately set. 

Examples:
Assuming the Domain Name is "boc22finaid.fau.edu"

If the scholarship application will be served from the root directory: 
```json
"api": "https://boc22finaid.fau.edu/",
"baseUrl": "/"
```

If the scholarship application will be served from a subfolder named 'scholarship': 
```json
"api": "https://boc22finaid.fau.edu/scholarship/",
"baseUrl": "scholarship"
```

## Development

### Dependencies
Make sure you have at least
 - PHP 7.1
 - Node.js 8.11+

Install @vue/cli if you don't already have it 

`npm i -g @vue/cli`

In the project root, install remaining dependencies with

```
npm i
php composer.phar
```

### Local Server
The best way to set things up locally is by running

`npm run watch`

and

`php composer.phar start`

In two different CLI windows. 

You will still need to set up or configure a database in config.json

### Database
Script to set up barebones database can be found at `sql/finaid_scholarships_structure`
