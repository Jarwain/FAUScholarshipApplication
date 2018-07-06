Security
=========

## Authentication
Authentication inspired by this [StackOverflow answer](https://stackoverflow.com/a/28953341)
    - $username and $password will be submitted via POST to /admin/login/
    - JWT Token is generated and saved to session/cookie
    - Token is checked for/required by all future requests. 

## CSRF
NOT IMPLEMENTED YET. 
There is middleware for Slim available at the following [link](https://github.com/slimphp/Slim-Csrf)
