# Services

# NOTE:
This may not be relevant. Or be worth building out. 

## Scholarship Eligibility Search (S)
/scholarship/api/search?stuff
 - Get Qualifiers
 - Get Scholarship Requirements
 - Filter based on the above

## Scholarship Application (A)
 - Get Student Information
 - Get Qualifiers
 - Get Scholarship List to pick from
 - Get Scholarship Question
 - Post Scholarship Application
 /scholarship/api/application == /scholarship/api/scholarship/:code/application

## Scholarship Administration (C)
 - CRUD ALL THE THINGS

# API
## Key
(+) High Priority
() Norm
(-) Low Priority
(?) is this even needed

(!) Admin Required
(*) Su Required

### Default
    POST     Create Something
    GET     Return Something
    PUT     Update Something 
    DELETE     Delete Something

## Endpoints

### /scholarship/api/
    ~ Root

### ~/scholarship/[code]
    GET         Return scholarship info & Requirements
        ?part(core || requirements || questions) 
    POST        Create(/Update ?)
    PUT         Update
    DELETE      Mark Scholarship Inactive

### ~/student/[znumber]
    GET         Student information & Applications
    POST        Create Student
    PUT         Update Student    

### ~/application/
    GET         Return Applications     ?undecided ?sch(code) ?student
    POST        Submit Application
### ~/application/{id}
    GET         Return Application
    POST        Submit Decision
    DELETE      Delete Application

### ~/question/[id]
    GET, POST, PUT, DELETE

### ~/qualifier/[id]
    GET, POST, PUT, DELETE
