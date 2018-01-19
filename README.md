Search
	Student GETS Qualifiers
	Student POSTs Qualifications
	Server filters Scholarships by Qualifications, returns Results
	Student selects Scholarships to Apply For
Apply
	if Student.origin != Search
		Student GETS list of Scholarships
		Student Selects scholarships to Apply For
	Student GETS Scholarship Application(s)
	Student POSTS completed Scholarship Application(s)
	Server Verifies Scholarship Application(s)
	if verified
		Server SAVES Application
	else
		throw ERROR
View
	Splash Login
	View Application Status
	ADMIN LOGIN isValid
		Make Decisions on Applications
		Update Applications
			Scholarships
			Questions
		Update Search
			Qualifiers
			Restrictions