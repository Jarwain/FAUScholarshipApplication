# File Structure
## Routes/
Contains all routes for a given grouping
 - /scholarships

## Controller/
Instantiated by Route
Each route calls a controller function
Contains:
 - Model Calls
 - Model Transformations
Returns:
 - status => true/false (Pass/Fail)
 - data => status ? $data : $error

## Model/
Interfaces with DataAccess
Stores and manipulates Objects
Executes Business Logic

### Objects/
Data Structure and Business Logic

### DataAccess/
Database Calls, Cache calls, etc.

# Example
User Requests All Scholarships => "GET /scholarships"
Router tells Controller to get All Scholarships
Controller Requests All Scholarships from Model.
Model queries DataAccess, returns data as Objects to Controller
Controller returns Scholarships

User Requests Scholarship => "GET /scholarships/SFA120"
Router tells controller to get Scholarship 'SFA120'
Controller requests SFA120 from Model
Model queries DataAccess for Scholarship 'SFA120', returns Scholarship as Object
Controller returns Scholarship