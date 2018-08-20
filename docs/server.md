# Server

The server is IIS. This application uses PHP 7.2. 

The tool `choco` is used to manage PHP versions, starting with version 7.2. You can google `chocolatey windows` to find its website.

PHP is in `C:\tools\php72`

NOTE: To avoid having to deal with the below setup, don't lose track of `/public/web.config`. If any changes are made to the IIS settings, it will be saved in `/dist/web.config`. Don't forget to mirror these changes into `/public/web.config` if you don't want to lose them the next time the client is built. 

## Setup
- In the IIS Manager, go to the application (right now it is `scholarship`).
- Click `Handler Mappings`
- Find the listing for `PHP_via_FastCGI` and hit Edit in the panel on the right
- Make sure the executable is set to `C:\tools\php72\php-cgi.exe`
- Make sure `Request Restrictions > Verbs` includes `GET,HEAD,POST,PUT,DELETE`
- If asked to create a FastCGI application, hit yes. 
- Back out and click `URL Rewrite`
- Click `Import Rules` in the panel on the right. 
- Import `C:\Scholarship Service\public\.htaccess`
- You may need to delete both sets of comments, and the two Rewrite lines in between the comments. The final Rewrite rules look like: 

```
<IfModule mod_rewrite.c>
  RewriteEngine On

  RewriteCond %{REQUEST_FILENAME} !-f
  RewriteRule ^ index.php [QSA,L]
</IfModule>
```

- Hit Apply in the panel on the right.

That should be everything to set up the application from scratch.
