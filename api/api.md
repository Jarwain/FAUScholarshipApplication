Notes
======
POST		Create
	Collection
		201 (Created), 'Location' header with link to /customers/{id} containing new ID.
	Specific
		404 (Not Found), 409 (Conflict) if resource already exists..
GET   	Read
	Collection
		200 (OK), list of customers. Use pagination, sorting and filtering to navigate big lists.
	Specific
		200 (OK), single customer. 404 (Not Found), if ID not found or invalid.
PUT 		Update
	Collection
		405 (Method Not Allowed), unless you want to update/replace every resource in the entire collection.
	Specific
		200 (OK) or 204 (No Content). 404 (Not Found), if ID not found or invalid.
DELETE	Delete
	Collection
		405 (Method Not Allowed), unless you want to delete the whole collection—not often desirable.
	Specific
		200 (OK). 404 (Not Found), if ID not found or invalid.

API Specification
====================

GET /scholarship/:id
  code
  category
  name
  description
  url
  deadline
  active
  requirements[]
  application
    counter
    limit
    questions[]
