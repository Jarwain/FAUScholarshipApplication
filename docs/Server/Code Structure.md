# Structure
## /public
Contains server settings (web.config for IIS) and the index.php

The index just loads the external dependencies, loads the container, starts the session, `require` everything else, and runs the Slim application.

## /src
Contains the majority of source code. Fun stuff.
### Settings
Application settings. Configuration for the Database, Logger, and Renderer
### Routes
URL Routes. Calls the controller to complete an action
### Middleware
Application Middleware
### Dependencies
Application Dependencies
### Controllers
Called by a Route. 
### Repository

### Models