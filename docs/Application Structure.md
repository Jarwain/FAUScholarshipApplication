# Application Structure

There are Three Core Solutions this Application provides
 - Scholarship Search
 - Scholarship Applications
 - Scholarship Administration

To provide these solutions, the application is broken into the Client and the Server. 
The Client is the UI/UX for the solutions. It interacts with the Server to actually carry out the solutions. 
The Server serves an API that the Client consumes. It acts as a layer between the Client and all Data. 

## Server
The API provides the following services
 - Scholarship Service: CRUD for scholarships and Requirements
 - Student Service: CRUD for Students and Qualifiers
 - Application Service: CRUD for Scholarship Applications, and application settings. 

Services contain most of the business logic, and interact with the Repositories. 
Repositories contain the data access logic. They determine whether to pull from the cache or the database, update the cache, etc. 


Search
    Student Qualifiers, All Online Scholarships Requirements
Apply 
    All Online Scholarships Questions 
    

/scholarship/       returns all online and offline scholarships 
/scholarship/:code  returns scholarship with :code 
/scholarship/?


part: Core, Online, Offline 

All Scholarships' Core
All Scholarships' Full

Online Scholarship Full
Offline Scholarship Full

/scholarship/           All Scholarships' Full
/scholarship/?part=core All Scholarships' Core 
/scholarship/?type

?part= (core || full)
?type= (online || offline)