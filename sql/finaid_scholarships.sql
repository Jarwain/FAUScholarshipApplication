-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 17, 2018 at 09:19 PM
-- Server version: 5.7.10-log
-- PHP Version: 5.6.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `finaid_scholarships`
--

-- --------------------------------------------------------

--
-- Table structure for table `application`
--

CREATE TABLE `application` (
  `id` int(11) NOT NULL,
  `znumber` varchar(9) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `decision` tinyint(1) DEFAULT NULL,
  `submitted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `application_answers`
--

CREATE TABLE `application_answers` (
  `id` int(11) NOT NULL,
  `application_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `answer` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `file`
--

CREATE TABLE `file` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `md5` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` mediumblob NOT NULL,
  `size` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `qualifier`
--

CREATE TABLE `qualifier` (
  `id` int(11) NOT NULL,
  `name` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `question` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `props` varchar(4096) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `qualifier`
--

INSERT INTO `qualifier` (`id`, `name`, `type`, `question`, `props`) VALUES
(1, 'fafsa', 'bool', 'Completed FAFSA', NULL),
(2, 'need', 'bool', 'Demonstrates Financial Need', NULL),
(3, 'gpa', 'range', 'GPA', '{ "min": 0, "max": 4, "step": 0.01, "required":true}'),
(4, 'year', 'select', 'Class Standing', '{ "haystack": ["Freshman","Sophomore","Junior","Senior","Graduate","Other"], "required":true }'),
(5, 'credits', 'range', 'Upcoming Credit Hours', '{ "min": 0, "max": 18, "required":true}'),
(6, 'standing', 'select', 'Academic Standing', '{"haystack":["Good","Warning","Probationary","Dismissed"], "required":true}'),
(7, 'study', 'select', 'Area of Study', '{"haystack":["Accounting", "Actuarial Science", "Adult/ Gerontological Nurse Practitioner", "Advanced Holistic Nursing", "Aging", "Anthropology", "Applied Mathematics and Statistics", "Applied Mental Health Services", "Architecture", "Art", "Art History", "Art: Ceramics, Painting, Photography, Printmaking, Sculpture", "Art: Graphic Design", "Art: Studio Art", "Asian Studies", "Big Data Analytics", "Bioengineering", "Biological Sciences", "Biomedical Sciences", "Biotechnology", "Business Administration (General MBA)", "Business Analytics", "Business Biotechnology", "Caribbean and Latin American Studies", "Chemistry", "Child Welfare", "Civil Engineering", "Classical Studies", "Clinical Nurse Leader", "Club Management", "Commercial Music", "Communication", "Communication Studies", "Computer Engineering", "Computer Science", "Corrosion", "Counselor Education", "Creative Writing", "Criminal Justice", "Criminology and Criminal Justice", "Curriculum and instruction", "Cyber Security", "Digital Marketing", "Early Care and Education", "Economic Development and Tourism", "Economics", "Educational Leadership", "Educational Psychology", "Electrical Engineering", "Elementary Education", "English", "English as a Second Language (ESL) Studies", "Environmental Education", "Environmental Engineering", "Environmental Restoration", "Environmental Science", "Environmental Studies", "Ethnic Studies", "Exceptional Student Education", "Executive Accounting", "Executive Health Administration", "Executive M.B.A.", "Executive Taxation", "Exercise Science and Health Promotion", "Family Nurse Practitioner", "Film and Culture", "Finance", "Finance (Executive Program)", "French", "General Studies", "Geographic Information Systems", "Geography", "Geology", "Geomatics Engineering", "Geosciences", "Gerontology", "Health Administration", "Healthcare Information Systems", "History", "Hospitality Management", "Information Security", "Information Technology and Management", "Innovation Entrepreneurship", "Instructional Technology", "Interdisciplinary Studies", "International Business", "International Business and Trade", "Jewish Studies", "Languages and Linguistics", "Languages and Linguistics: Italian", "Languages, Linguistics and Comparative Literature", "Liberal Arts and Science (Honors College Only)", "Linguistics", "Management", "Management Information Systems", "Marine Engineering Management", "Marketing", "Mathematical Sciences", "Mathematics", "Mechanical Engineering", "Media, Technology, and Entertainment", "Medical Physics", "Meetings and Events Management", "Multimedia Studies", "Music", "Music Education", "Neuroscience", "Neuroscience and Behavior", "Nonprofit Management", "Nurse Educator", "Nursing", "Nursing Administration and Financial Leadership", "Ocean Engineering", "Online B.B.A.", "Online BBA", "Online Executive M.B.A.", "Peace, Justice and Human Rights", "Performance ", "Philosophy", "Physics", "Political Science", "Pre-Health Professions Studies", "Professional Accounting", "Professional and Technical Writing", "Professional M.B.A.", "Psychology", "Public Administration", "Public Management", "Public Safety Administration", "Reading Education", "Religious Studies", "Remote Sensing", "Risk Management", "Risk Management and Insurance", "Secondary Education", "Secondary Education plus Certification", "Social Work", "Sociology", "Spanish", "Speech - Language Pathology/Audiology", "Statistics", "Surveying and Mapping", "Sustainable Community Planning", "Taxation", "Teacher Certification", "Teacher Leadership", "Theatre", "Transportation Engineering", "Urban and Regional Planning", "Urban Design", "Visual Art - Ceramics, Computer Art, Graphic Design, Painting", "Visual Art: Fine Art, Graphic Design", "Women, Gender, and Sexuality Studies"], "multi":true, "other":true}'),
(8, 'college', 'select', 'College', '{"haystack":["College For Design and Social Inquiry", "Dorothy F. Schmidt College of Arts and Letters", "Charles E. Schmidt College of Medicine", "College of Business", "College of Education", "College of Engineering and Computer Science", "Christine E. Lynn College of Nursing", "Charles E. Schmidt College of Science", "Harriet L. Wilkes Honors College"], "multi":true, "required":true}'),
(9, 'transfer', 'bool', 'Transfer Student', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `id` int(11) NOT NULL,
  `question` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `props` varchar(1024) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`id`, `question`, `type`, `props`) VALUES
(1, 'Write a personal statement essay in the space below. The essay should detail your goals for the future.', 'essay', '{"min_words":1,"max_words":250}'),
(2, 'Write a personal statement essay in the space below, detailing your Greek Heritage and your goals for the future.', 'essay', '{"min_words":1,"max_words":250}'),
(3, 'Write a personal statement essay in the space below. The essay should detail your military or parent’s military service information along with your goals for the future.  Students who are the child of a firefighter or police officer killed in the line of duty, should detail their parent’s career in public service in their essay. ', 'essay', '{"min_words":1,"max_words":250}'),
(4, 'Scan and upload a PDF Copy of your High School Transcript, or any other evidence that you went to school in Palm beach County.', 'file', '{"filetype":"pdf"}'),
(5, 'If you are an Eagle Scout, Please upload a copy of your Eagle Scout Certificate. DOC, PDF, PNG, and JPG are supported.', 'file', '{"filetype":"docx?|pdf|png|jpe?g"}'),
(6, 'If you are a  "Returning" Undergraduate Student 25 years old or older, Please explain your absence of two or more years from college. Otherwise, put "N/A".', 'essay', '{"optional":true,"max_words":250}'),
(7, 'Write a personal statement essay in the space below. The essay should detail any unexpected financial needs or unusual circumstances that have impacted your education at this time.', 'essay', '{"min_words":1,"max_words":250}'),
(8, 'Write a personal statement essay in the space below. The essay should detail your leadership qualities, activities and goals for the future.', 'essay', '{"min_words":1,"max_words":250}'),
(9, 'Scan and upload a PDF Copy of a letter of recommendation from academic advisor, faculty member, instructor or principal. ', 'file', '{"filetype":"pdf"}'),
(10, 'Scan and upload a PDF Copy of a letter of recommendation from a FAU advisor or Faculty member.', 'file', '{"filetype":"pdf"}'),
(11, 'List your Leadership Activities from High School or College, as well as the Academic Year that they occurred in', 'essay', '{"optional":true,"max_words":250}'),
(12, 'Write an essay of at LEAST 500 words explaining what you have accomplished with you leadership skills and how it benefited your classmates.  It should also include a statement as to how you value the role of higher education. ', 'essay', '{"min_words":500,"max_words":750}'),
(13, 'Scan and upload a PDF Copy of a letter of recommendation from a faculty advisor of a campus club or organization in which you participated', 'file', '{"filetype":"pdf"}'),
(14, 'Scan and upload a PDF Copy of a letter from the organization confirming eligibility. ', 'file', '{"filetype":"pdf"}'),
(15, 'Scan and upload a PDF Copy of a letter of recommendation from the SAEN culinary director. ', 'file', '{"filetype":"pdf"}'),
(16, 'Write a personal statement essay in the space below. The essay should detail why you feel you are a good scholarship candidate, what you have accomplished personally and at FAU, and what you intend to accomplish in the future', 'essay', '{"min_words":1,"max_words":250}'),
(17, 'Describe your most recent community service experiences, including leadership positions if you have held any, and what they have meant to you. Please include contact information for the  place/organization where you served. ', 'essay', '{"min_words":1,"max_words":250}'),
(18, 'Write an essay based on your interest in field of consumer package goods and food industry. ', 'essay', '{"min_words":1,"max_words":250}'),
(19, 'This scholarship requires that your parent or grandparent be an FAU alumni. Tell us about that parent or grandparent and how their achievements have impacted you and your future goals. Include the date on which they graduated from FAU.', 'essay', '{"min_words":1,"max_words":250}'),
(20, 'This scholarship requires that your parent or grandparent be a current or retired member of the faculty and staff of FAU. Tell us about that parent or grandparent and how their achievements have impacted you and your future goals.', 'essay', '{"min_words":1,"max_words":250}'),
(22, 'Please submit an essay that outlines your future goals and how it relates to your interest in obtaining a degree in criminal justice, law enforcement, or pre-law.', 'essay', '{"min_words":1,"max_words":250}'),
(23, 'Scan and upload a PDF Copy of proof that you are a current or former staff or faculty member at Rolling Green or Crosspointe Elementary Schools. Or upload proof that you were a prior student at Rolling Green Elementary School. ', 'file', '{"filetype":"pdf"}'),
(24, 'Which Chick-fil-a location do you work at?', 'essay', '{"min_words":1,"max_words":20}'),
(25, 'Write a personal statement essay in the space below. The essay should detail your Native American/Indian Heritage and your goals for the future.', 'essay', '{"min_words":1,"max_words":250}'),
(26, 'Write a personal statement essay in the space below. The essay should detail your Haitian Heritage and your goals for the future.', 'essay', '{"min_words":1,"max_words":250}'),
(27, 'Please upload proof of tribe membership. Supported filetypes: PDF, PNG, JPG ', 'file', '{"filetype":"pdf|png|jpe?g"}'),
(28, 'Upload a Youtube Video detailing your goals for the future.', 'video', '{"minLength":90}');

-- --------------------------------------------------------

--
-- Table structure for table `scholarship`
--

CREATE TABLE `scholarship` (
  `id` int(11) NOT NULL,
  `code` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `open` datetime DEFAULT NULL,
  `close` datetime DEFAULT NULL,
  `max` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `scholarship`
--

INSERT INTO `scholarship` (`id`, `code`, `name`, `description`, `active`, `open`, `close`, `max`) VALUES
(1, 'ADV786', 'St. Andrews Estates North & Evelyn and Stanford King Scholarship', 'This scholarship is for students who have a high school senior GPA of 3.0+, are accepted for enrollment in and meet the scholarship criteria of FAU. Applicants must have worked at SAEN for at least 90 days, have a recommendation from the SAEN Culinary Department Director, and must continue working at SAEN for a minimum of 192 hours per semester while in school under this scholarship.', 1, NULL, NULL, 100),
(2, 'ADV996', 'The Kelly Family Scholarship', 'Established in 2014 by FAU President John Kelly and First Lady Carolyn Kelly, the Kelly Family Scholarship Fund will help make the dream of higher education a reality for some of FAU\'s most deserving students. Generous gifts to this fund will be matched dollar for dollar by President and Mrs. Kelly. Undergraduates and graduates who apply must in be in good academic standing with demonstrated financial need. A completed FAFSA is required to be considered for this scholarship.', 1, NULL, NULL, 786),
(3, 'ADV998', 'President\'s Challenge Scholarship', 'This scholarship is open to students in good academic standing at FAU who have financial need.', 0, NULL, NULL, 0),
(4, 'BUS836', 'Florida Grocery Manufacturers Scholarship', 'This scholarship is for the fulltime student who is a Junior, Senior or Graduate Business major with a 3.0 and above GPA. Students must be in good standing with University. Students are encouraged to attend one of Florida grocery Manufacturer\'s Association network events.', 0, NULL, NULL, 0),
(5, 'BUSSCH', 'Guggenheim Scholarship', 'The Guggenheim Scholarship is awarded to degree seeking students pursuing a graduate degree. Preference will be given to former FAU athletic students, with priority given to former members of the FAU football team, followed by former members of FAU\'s women\'s athletic teams. Additional preference will be given to graduate students seeking a degree in the College of Business.', 1, NULL, NULL, 100),
(6, 'MEMSCH', 'FAU Memorial Scholarship', 'This scholarship is established to memorialize students who have passed away during the academic year. Applicants must be enrolled in the same college as the memorialized student. Recipient must also have at least a 2.5 GPA and demonstrated financial need. A completed FAFSA is required to be considered for this scholarship. All applicants must upload or include a letter or recommendation from an FAU advisor or Faculty member.', 1, NULL, NULL, 100),
(7, 'MLKSCH', 'Martin Luther King Jr. Award', 'The Martin Luther King Jr. Award is for first-time-in-college freshmen who meet the academic requirements for admission to FAU and demonstrate financial need. Renewable up to eight consecutive semesters based on academic achievement. To be eligible, students must complete the Free Application for Federal Student Aid (FAFSA) and have a minimum score of 1450 SAT (all three sections) or a 21 ACT.', 0, NULL, NULL, 300),
(8, 'RGESCH', 'Rolling Green Elementary School Scholarship', 'The Rolling Green Elementary School Scholarship is open to any FAU student that is currently or has been a faculty or staff member of Rolling Green Elementary School or Crosspointe Elementary School. It is also open to former students of Rolling Green Elementary School. ', 1, NULL, NULL, 25),
(9, 'SFA010', 'Chick-fil-a Scholarship', 'The Chick-fil-a Scholarship is awarded to FAU students that are employed at either the Town Center Chick-fil-a or FAU on-campus Chick-fil-a.', 0, NULL, NULL, 25),
(10, 'SFA020', 'Kay S. Lioy/FAU club Scholarship', 'The Kay S. Lioy/FAU Club Scholarship is given to an FAU employee, their spouse, or their child so long as they are enrolled at least half time, demonstrate financial need, and maintain a 2.0 GPA. A completed FAFSA is required to be considered for this scholarship.', 1, NULL, NULL, 100),
(11, 'SFA025', 'Eleanor R. Baldwin Endowment Fund', 'The Eleanor R. Baldwin Endowment Fund supports students in the FAU College of Education. Preference will be given to undergraduate students enrolled in student teaching in the upcoming academic year and have a minimum 3.2 GPA. Graduate students enrolled in the College of Education with a minimum GPA of 3.5 are also eligible to apply. Students will be awarded on the basis of merit with consideration given to scholarship, leadership, and leadership potential in the field of education, and then for financial need. A completed FAFSA is required to be considered for this scholarship.', 1, NULL, NULL, 300),
(12, 'SFA035', 'Arnold and Ruth Greenberg Scholarship Fund', 'The Arnold and Ruth Greenberg Scholarship is awarded to assist students in good standing at FAU, based on demonstrated financial need. A completed FAFSA is required to be considered for this scholarship.', 1, NULL, NULL, 306),
(13, 'SFA041', 'David & Sandy Lowe Faculty & Staff Legacy Scholarship', 'This scholarship is awarded to qualified children and grandchildren of FAU current, retired and emeritus faculty and staff. Applicants must have a 3.0 GPA and be enrolled as a sophomore, junior, senior or graduate student. Preference will be given to students who demonstrate financial need. A completed FAFSA is required to be considered for this scholarship.', 1, NULL, NULL, 100),
(14, 'SFA050', 'Alumni Legacy Scholarship', 'This scholarship is awarded to qualified children and grandchildren of FAU alumni (former students who have earned at least 32 credit hours at the University). The applicants must be enrolled as sophomores, juniors, seniors, or graduate students at FAU and have at least a 3.0 cumulative GPA. Preference will be given to students who demonstrate financial need. A completed FAFSA is required to be considered for this scholarship.', 1, NULL, NULL, 100),
(15, 'SFA055', 'Snell Family Scholarship Fund', 'The Snell Family Scholarship Fund will be used to support three individual scholarship awards of up to $10,000 per student for one year. The scholarship awards may be used for tuition and fees as well as books associated with the recipient\'s education. To be eligible for this scholarship students must demonstrate financial need, be enrolled full time (minimum of 12 credit hours per semester), be a Florida resident, and maintain a 3.0 cumulative GPA.', 1, NULL, NULL, 300),
(16, 'SFA060', 'Daniel A. & Martha F. Mica Scholarship Endowment', 'The Daniel A & Martha F. Mica Scholarship Endowment is given to a student who demonstrates leadership capabilities and financial need. The recipient must be enrolled full time with a minimum 2.5 cumulative GPA. A completed FAFSA is required to be considered for this scholarship.', 1, NULL, NULL, 254),
(17, 'SFA070', 'Dar Indian Scholarship', 'The Dar Indian Scholarship are for members of the Seminole or Miccosukee Indian Tribes. Available to members of tribes living in Florida. A completed FAFSA is required to be considered for this scholarship.', 1, NULL, NULL, 106),
(18, 'SFA085', 'Gabor Agency Scholarship', 'The Gabor Agency Scholarship will be awarded on an annual basis to students at FAU whose parents are currently members of FAU faculty or staff, are maintaining at least a 3.0 GPA, and have a stated and demonstrated interest in an area of study. A completed FAFSA is required to be considered for this scholarship.', 1, NULL, NULL, 300),
(19, 'SFA100', 'Woodford Zimmerman Memorial Scholarship Endowment', 'The Woodford Zimmerman Memorial Scholarship Endowment is awarded to students 25 years or older with demonstrated financial need. The selected recipient must be enrolled at least half time either as an undergraduate or graduate student. A completed FAFSA is required to be considered for this scholarship.', 1, NULL, NULL, 123),
(20, 'SFA120', 'Marilyn and Jay Weinberg Scholarship', 'The Marilyn and Jay Weinberg Scholarship is awarded to assist students in good standing at FAU, based on demonstrated financial need. A completed FAFSA is required to be considered for this scholarship.', 1, NULL, NULL, 300),
(21, 'SFA125', 'Deborah \'Mikki\' Minney Minority Scholarship', 'This scholarship is provided to undergraduate students with special consideration for \'First Generation\' students who are members of an underrepresented group. Preference will be given to African Americans, then to Native Americans or Hispanics or Caribbean Americans.', 1, NULL, NULL, 100),
(22, 'SFA135', 'Richard and Mary Cook Business Scholarship Endowment Fund', 'The Richard and Mary Cook Business Scholarship is awarded to an incoming undergraduate freshman or a first year or transfer student, who are business graduates of Northeast High School in Ft. Lauderdale, Florida. Student must have demonstrated need. A completed FAFSA is required to be considered for this scholarship.', 1, NULL, NULL, 100),
(23, 'SFA140', 'Rotary Club of Boca Raton Scholarship', 'The Rotary Club of Boca Raton has established this scholarship to provide educational or research opportunities to students of Florida Atlantic University. Scholarship recipients must have attended high school in Palm Beach County, must be a degree-seeking undergraduate attending FAU at least half-time (6 credits), have a minimum 2.5 GPA, demonstrated a strong commitment to community service, have a completed FAFSA, demonstrate financial need, and be willing to participate in a mentorship program administered by the Boca Raton Rotary Club.', 1, NULL, NULL, 250),
(24, 'SFA150', 'Adelaide R. & Joseph G. Snyder Scholarship', 'The Adelaide R. & Joseph G. Snyder Scholarship is given to a full-time student who demonstrates outstanding academic achievement and financial need. A completed FAFSA is required to be considered for this scholarship.', 1, NULL, NULL, 150),
(25, 'SFA155', 'Stewart and Wendy Martin Scholarship Endowment', 'The Stewart and Wendy Martin Scholarship is to support scholarships for students at the University who are active military veterans, or who are first time college attendees. A completed FAFSA is required to be considered for this scholarship.', 1, NULL, NULL, 100),
(26, 'SFA170', 'Emily & Robert Murdick Memorial Scholarship', 'The Emily & Robert Murdick Memorial Scholarship is available to full-time students with a minimum 3.0 cumulative GPA and demonstrated financial need. This scholarship is not available to students in the College of Education. Preference is given to U.S. born African Americans or Native Americans. Renewal of the award is based on maintaining satisfactory academic progress. A completed FAFSA is required to be considered for this scholarship.', 1, NULL, NULL, 174),
(27, 'SFA210', 'Minnie Hyman Scholarship Fund', 'The Minnie Hyman Scholarship Fund grants awards to a student who is a sophomore, junior, or senior with demonstrated financial need. Award is renewable upon application. A completed FAFSA is required to be considered for this scholarship.', 1, NULL, NULL, 225),
(28, 'SFA215', 'Brudzinski Scholarship Fund', 'The Brudzinski Scholarship is available to FAU students seeking undergraduate degrees in Hospitality, who maintain at least a 2.5 GPA, and are considered part-time(6 credits) or full-time students(12 credits). They must also demonstrate financial need. A completed FAFSA is required to be considered for this scholarship.', 1, NULL, NULL, 100),
(29, 'SFA220', 'Reid Nix Endowed Scholarship Fund', 'The Reid Nix Endowed Scholarship Fund supports students who have shown leadership potential by obtaining the rank of Eagle Scout via the Boy Scouts of America, as well as undergraduate students, 25 years or older, who are returning to college after an absence of two or more years. All applicants must have demonstrated financial need, a minimum 3.0 GPA and must be enrolled in a minimum of 6 credits. A completed FAFSA is required to be considered for this scholarship.', 1, NULL, NULL, 200),
(30, 'SFA240', 'Coca Cola Scholarship', 'The Coca-Cola Scholarship is awarded to students enrolled in a degree seeking program or in a teacher certification program, registered at least half-time and demonstrate financial need. Applicants must have either a minimum 2.5 GPA or be an incoming freshman. A letter of recommendation from an academic advisor, faculty member, instructor or principal is required. A completed FAFSA is required to be considered for this scholarship.', 1, NULL, NULL, 150),
(31, 'SFA290', 'M. Brenn Green Scholarship', 'The M. Brenn Green Scholarship awards first-time-in-college freshmen majoring in one of the following areas: Anthropology, Criminal Justice, Economics, Geography, Health Administration, Political Science, Social Work, or Sociology. It is renewable up to four years based on academic achievement and completion in one of the areas above', 0, NULL, NULL, 300),
(32, 'SFA355', 'David Neil Krinzman Memorial Scholarship', 'Awarded to students in good academic standing with demonstrated financial need. A completed FAFSA is required to be considered for this scholarship', 1, NULL, NULL, 180),
(33, 'SFA360', 'Milton & Gladys Meisner Scholarship Fund', 'The Milton & Gladys Meisner Scholarship is awarded to students in Architecture, Ocean Engineering, and/or Pharmaceutical Studies. Recipients must be in their junior or senior year and demonstrate financial need. A completed FAFSA is required to be considered for this scholarship.', 1, NULL, NULL, 300),
(34, 'SFA365', 'Bank of America Florida\'s Community Scholars Program', 'Awards for first-time-in-college freshmen. Students must demonstrate financial need; please complete the Free Application for Federal Student Aid (FAFSA) to determine eligibility. Recipient must demonstrate a history of community service and have a minimum 3.3 GPA. Award will be evenly divided between fall and spring terms. The student must maintain continuous enrollment, and scholarship eligibility for a maximum of eight semesters.', 0, NULL, NULL, 300),
(35, 'SFA370', 'Angelos Langadas Endowed Scholarship', 'The Angelos Langadas Endowed Scholarship is awarded to deserving students who are making progress with their education. Preference is given to students of Greek heritage with demonstrated financial need. A completed FAFSA is required to be considered for this scholarship.', 1, NULL, NULL, 150),
(36, 'SFA371', 'Helen E. and Robert K. Bero Endowed Scholarship Fund', 'The Helen E. and Robert K. Bero Endowed Scholarship is awarded to assist students in good academic standing with FAU who demonstrate financial need. The student must be involved in community service or activities outside of school. A completed FAFSA is required to be considered for this scholarship.', 1, NULL, NULL, 160),
(37, 'SFA440', 'Julian Warren Weiss Endowment scholarship', 'The Julian Warren Weiss Endowment Scholarship was established to aid students whose life experience or family challenges make higher education opportunities difficult, or students who have unexpected financial needs or unusual circumstances that arise during the year and impact the student\'s education. Students must have a minimum 2.5 GPA and demonstrate financial need. An essay is required explaining financial situations, career goals, and special accomplishments including how the student has overcome obstacles in life. A completed FAFSA is required to be considered for this scholarship. Awards are renewable so long as the criteria are met.', 1, NULL, NULL, 500),
(38, 'SFA455', 'Edgewater Pointe Estates Scholarship', 'Edgewater Pointe Estates Scholarship is for full or part time employees at Edgewater Pointe Estates who have been employed for at least 90 days and work a minimum of 12 hours per week. Selected applicants must have an undergraduate GPA of 2.75 or a graduate GPA of 3.0, and a letter from the organization confirming eligibility.', 1, NULL, NULL, 15),
(39, 'SFA490', 'Dania Beach Scholarship', 'The recipients of this scholarship must be full time degree seeking students, admitted to FAU. The applicant\'s primary address must be from the City of Dania. Applicants must demonstrate financial need. This scholarship is renewable for up to 4 years of undergraduate study, provided the recipient maintains a 3.0 GPA. A completed FAFSA is required to be considered for this scholarship.', 0, NULL, NULL, 0),
(40, 'SFA500', 'Hicks Scholarship Endowment', 'The Hicks Scholarship Endowment grants awards to undergraduate students who are residents of Ft. Lauderdale and are enrolled in the Charles E Schmidt College of Science, the College of Business, or the College of Engineering and Computer Science. Students must be enrolled full time with a 3.0 GPA.', 1, NULL, NULL, 150),
(41, 'SFA520', 'Harriet C. Boettcher Endowed Scholarship', 'The Harriet C. Boettcher scholarship is given to a deserving student with demonstrated financial need. Preference given to students of Asian heritage.', 1, NULL, NULL, 188),
(42, 'SFA529', 'Lillian Delmarter Scholarship Endowment', 'The Lillian Delmarter Scholarship Endowment was established by Lillian Delmarter because she never had the opportunity to complete her formal education; her goal is to help students with the ability to experience the joys of learning. Student must demonstrate financial need. A completed FAFSA is required to be considered for this scholarship', 1, NULL, NULL, 200),
(43, 'SFA590', 'Albert Allister Endowed Scholarship Fund', 'The Albert Allister Endowed Scholarship Fund was established as a result of a matured annuity for Albert Allister. Students must be in good standing with Florida Atlantic University. A completed FAFSA is required to be considered for this scholarship.', 1, NULL, NULL, 140),
(44, 'SFA710', 'Thomas F. Fleming Jr Endowed Memorial Scholarship', 'The Thomas F. Fleming Jr. Endowed Memorial Scholarship was established in honor of Thomas F. Fleming Jr., the late founder and chairman of the Foundation Board. Students must be in good standing with the University. The eligible majors are in the College of Nursing, Engineering and Computer Science. A completed FAFSA is necessary to be considered for this scholarship.', 1, NULL, NULL, 289),
(45, 'SFA790', 'Helen I. Craig Memorial Scholarship Endowment', 'The Helen I. Craig Memorial Scholarship Endowment is awarded to students with good academic standing at FAU, based on demonstrated financial need. A completed FAFSA is required to be considered for this scholarship.', 1, NULL, NULL, 220),
(46, 'SFA810', 'Deerfield Beach Law Enforcement Trust Fund Scholarship', 'This fund is to provide scholarships to academically at risk students who have at least a 2.0 GPA and meet Florida Atlantic University\'s acceptance requirements. This scholarship is offered to students who have graduated from a public high school in Deerfield Beach. The student must serve with the Broward Sheriff\'s Office - Deerfield Beach district for a total of two hundred and eight (208) semester hours each calendar year. This scholarship is to provide incentives for at risk students to avoid criminal activities and to promote a lifestyle to enhance opportunities to excel and pursue a crime free future.', 1, NULL, NULL, 100),
(47, 'SFA840', 'Lawrence P. and Dorothy E. DeLisle Memorial Scholarship', 'The Lawrence P. and Dorothy E. DeLisle Memorial Scholarship is intended to provide assistance for students who could not otherwise get an education at FAU. Students seeking undergraduate and graduate degrees in the areas of Business; Science; Biomedical; Nursing; Education; Engineering and Computer Science; or Architecture, Urban, and Public Affairs are eligible to apply. Students must be Florida residents, maintain a minimum 3.0 GPA, and demonstrate financial need as required by the FAU Office of Student Financial Aid. A completed FAFSA is required to be considered for this scholarship', 1, NULL, NULL, 700),
(48, 'SFA861', 'Dorothy & Marshall Anderson Endowed Scholarship', 'The Dorothy & Marshall Anderson Endowed Scholarship requires students to be in good academic standing, degree seeking, and have demonstrated financial need. A completed FAFSA is required to be considered for this scholarship.', 1, NULL, NULL, 225),
(49, 'SFA871', 'Mildred and Rudy Reis Endowed Scholarship Fund', 'The Mildred and Rudy Reis Endowed Scholarship requires students to be enrolled as an undergraduate or graduate student with demonstrated financial need and a minimum 3.25 GPA. A completed FAFSA is required to be considered for this scholarship.', 1, NULL, NULL, 150),
(50, 'SFA875', 'Sue Peavy Hughes Scholarship Endowment', 'The Sue Peavy Hughes Scholarship is awarded to students with good academic standing at FAU, based on demonstrated financial need. A completed FAFSA is required to be considered for this scholarship.', 1, NULL, NULL, 150),
(51, 'SFA890', 'The Harriet C. Boettcher US Military Endowed Scholarship', 'The Harriet C. Boettcher US Military Endowed Scholarship fund was established to help support an undergraduate or graduate student enrolled in a minimum of 9 credits. First preference will be given to US military veterans having served active duty or the child of an active duty member of the US military. Second preference will be given to a child of a firefighter or police officer killed in the line of duty.', 1, NULL, NULL, 50),
(52, 'SFA900', 'Ernest and Thea Kahn Endowed Scholarship Fund', 'The Ernest and Thea Kahn Endowed Scholarship Fund is awarded to students who demonstrate financial need. All applicants must have attended a public, private, or parochial high school in Palm Beach County. A completed FAFSA is required to be considered for this scholarship.', 1, NULL, NULL, 100),
(53, 'SFA905', 'Emanuel Newsome Scholarship Fund', 'The Emanuel Newsome Scholarship is awarded to students with good academic standing at FAU, a minimum GPA of 2.7, and are enrolled as a Junior or Senior. Students must be enrolled in 9 or more credits per semester. The student must demonstrate a Leadership role, via participating in extracurricular activities, such as sports, student activities, Music, Volunteerism, Student Government, etc. A completed FAFSA is required to be considered for this scholarship.', 1, NULL, NULL, 150),
(54, 'SFA910', 'Helen O\'Leary Scholarship Fund', 'The Helen O\'Leary Scholarship supports undergraduate or graduate students at FAU with demonstrated financial need. A completed FAFSA is required to be considered for this scholarship', 1, NULL, NULL, 130),
(55, 'SFA920', 'Robert L. Shattner Scholarship Endowment', 'The Robert L. Shattner Scholarship Endowment is intended for students whose life experiences or family challenges make higher educational opportunities difficult, or to aid students who have unexpected financial needed or unusual circumstances that arise during the year that impacts their education. Student must have minimum 2.5 GPA and must have demonstrated financial need. A completed FAFSA is required to be considered for this scholarship.', 1, NULL, NULL, 200),
(56, 'SFA930', 'The McGee Family Scholarship', 'The McGee Family Scholarship award is given to a full-time undergraduate student who demonstrates financial need. A completed FAFSA is required to be considered for this scholarship.', 1, NULL, NULL, 140),
(57, 'SFA940', 'Konbit Kreyol Lambert and Romain Haitian Service Scholarship', 'Konbit Kreyol Lambert and Romain Haitian Service Scholarship was created in the memory of Ms. Lambert and Ms. Romain who passed away. Preference will be given to students of Haitian decent and/or active in Kronbit Kreylol. Student must be living in the United States, either a US citizen or permanent resident and an undergraduate degree seeking with college credits and a GPA of 2.8 or higher.  Student must be enrolled in a minimum of 9 credits per semester and must have demonstrated financial need.  A completed FAFSA is required to be considered for this scholarship.', 1, NULL, NULL, 200),
(58, 'SFA950', 'Grace Fait Asian Women Education Assistance Endowment', 'The Grace Fait Asian Women Education Assistance Endowment is awarded with preference given to a female of Asian descent. Recipient must have a minimum GPA of 3.5, be in good standing at FAU, and must have demonstrated financial need. A completed FAFSA is required to be considered for this scholarship.', 1, NULL, NULL, 100),
(59, 'SFA999', 'Adam Jay Harris Endowed Memorial Scholarship', 'The Adam Jay Harris Endowed Memorial Scholarship is in memory of a former FAU pre-med student, Adam Jay Harris. Recipients must be full time undergraduate students pursuing a pre-med course of study with a minimum 3.0 GPA.', 1, NULL, NULL, 100),
(60, 'SGASCH', 'Student Government Scholarship', 'The Student Government Scholarship is awarded to students seeking a 4 year undergraduate degree or a graduate degree and are enrolled at least half-time. (Undergrad: 6 credits. Graduate: 5 credits) Applicants must have a minimum 2.5 GPA and must be a US citizen or permanent resident. Applicant must also provide a letter of recommendation from an instructor, employer or advisor. The letter must be the original and CURRENT and not from a relative. UWC members and Student Government members receiving tuition reimbursements are ineligible for this scholarship.', 1, NULL, NULL, 200),
(61, 'SKPSCH', 'Senator Ken Pruitt Scholarship', 'The Senator Ken Pruitt Scholarship will be awarded to two undergraduate and two graduate students who have extensive leadership accomplishments and have demonstrated commitment to civic duty via participation in student activities. Students must submit an application listing their leadership activities in high school or college and the academic year they occurred. A current letter of recommendation from the faculty members of a campus club or organization in which they participated. Students must have a 3.0 or higher GPA.', 1, NULL, NULL, 100),
(62, 'TEASCH', 'Transfer Education Achievement Award (TEAA)', 'Awards for incoming junior transfer students from one of Florida\'s College System institutions. Students must have a minimum 3.0 GPA and demonstrate financial need. Available for part-time and full-time students Renewable up to five semesters or upon completion of an Undergraduate Degree.', 1, NULL, NULL, 330);

-- --------------------------------------------------------

--
-- Table structure for table `scholarship_questions`
--

CREATE TABLE `scholarship_questions` (
  `id` int(11) NOT NULL,
  `code` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `question` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `scholarship_questions`
--

INSERT INTO `scholarship_questions` (`id`, `code`, `question`) VALUES
(45, 'ADV786', 1),
(46, 'ADV786', 15),
(48, 'ADV996', 1),
(49, 'ADV998', 16),
(53, 'BUS836', 18),
(33, 'BUSSCH', 1),
(29, 'MEMSCH', 1),
(30, 'MEMSCH', 10),
(60, 'MLKSCH', 1),
(58, 'RGESCH', 23),
(65, 'SFA010', 24),
(1, 'SFA020', 1),
(2, 'SFA025', 8),
(3, 'SFA035', 1),
(55, 'SFA041', 20),
(37, 'SFA050', 19),
(75, 'SFA055', 28),
(4, 'SFA060', 8),
(66, 'SFA070', 25),
(76, 'SFA070', 27),
(64, 'SFA085', 1),
(5, 'SFA100', 1),
(77, 'SFA120', 1),
(73, 'SFA125', 1),
(71, 'SFA135', 1),
(51, 'SFA140', 17),
(6, 'SFA150', 1),
(67, 'SFA155', 1),
(7, 'SFA170', 1),
(43, 'SFA210', 1),
(52, 'SFA215', 1),
(25, 'SFA220', 5),
(26, 'SFA220', 6),
(8, 'SFA220', 8),
(27, 'SFA240', 1),
(28, 'SFA240', 9),
(59, 'SFA290', 1),
(44, 'SFA355', 1),
(9, 'SFA360', 1),
(61, 'SFA365', 1),
(22, 'SFA370', 2),
(38, 'SFA371', 1),
(10, 'SFA440', 7),
(40, 'SFA455', 1),
(41, 'SFA455', 14),
(39, 'SFA490', 1),
(42, 'SFA500', 1),
(54, 'SFA520', 1),
(11, 'SFA529', 1),
(12, 'SFA590', 1),
(13, 'SFA710', 1),
(14, 'SFA790', 1),
(57, 'SFA810', 22),
(50, 'SFA840', 1),
(15, 'SFA861', 1),
(16, 'SFA871', 1),
(68, 'SFA875', 1),
(23, 'SFA890', 3),
(17, 'SFA900', 1),
(24, 'SFA900', 4),
(47, 'SFA905', 1),
(18, 'SFA910', 1),
(69, 'SFA920', 7),
(19, 'SFA930', 1),
(70, 'SFA940', 26),
(20, 'SFA950', 1),
(21, 'SFA999', 1),
(31, 'SGASCH', 1),
(32, 'SGASCH', 9),
(34, 'SKPSCH', 11),
(35, 'SKPSCH', 12),
(36, 'SKPSCH', 13),
(62, 'TEASCH', 1);

-- --------------------------------------------------------

--
-- Table structure for table `scholarship_requirements`
--

CREATE TABLE `scholarship_requirements` (
  `id` int(11) NOT NULL,
  `sch_code` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qualifier_id` int(11) NOT NULL,
  `valid` varchar(4096) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `scholarship_requirements`
--

INSERT INTO `scholarship_requirements` (`id`, `sch_code`, `category`, `qualifier_id`, `valid`) VALUES
(1, 'SFA810', '*', 3, '[2,4]'),
(2, 'SFA999', '*', 3, '[3,4]'),
(3, 'SFA999', '*', 4, '["Freshman","Sophomore","Junior","Senior"]'),
(4, 'SFA999', '*', 5, '[12,18]'),
(5, 'SFA150', '*', 1, ''),
(6, 'SFA150', '*', 2, ''),
(7, 'SFA590', '*', 6, '["Good"]'),
(8, 'SFA050', '*', 1, ''),
(9, 'SFA050', '*', 3, '[3,4]'),
(10, 'SFA050', '*', 4, '["Sophomore","Junior","Senior","Graduate"]'),
(11, 'SFA370', '*', 1, ''),
(12, 'SFA035', '*', 1, ''),
(13, 'SFA035', '*', 2, ''),
(14, 'SFA035', '*', 6, '["Good"]'),
(15, 'SFA240', '*', 1, ''),
(16, 'SFA240', '*', 2, ''),
(20, 'SFA060', '*', 1, ''),
(21, 'SFA060', '*', 2, ''),
(22, 'SFA060', '*', 3, '[2.5,4]'),
(24, 'SFA355', '*', 1, ''),
(25, 'SFA355', '*', 2, ''),
(26, 'SFA355', '*', 6, '["Good"]'),
(27, 'SFA861', '*', 1, ''),
(28, 'SFA861', '*', 2, ''),
(29, 'SFA861', '*', 6, '["Good"]'),
(30, 'SFA025', '*', 1, ''),
(31, 'SFA025', 'a', 3, '[3.2,4]'),
(32, 'SFA025', 'a', 4, '["Freshman","Sophomore","Junior","Senior"]'),
(33, 'SFA025', 'b', 3, '[3.5,4]'),
(34, 'SFA025', 'b', 4, '["Graduate"]'),
(35, 'SFA170', '*', 1, ''),
(36, 'SFA170', '*', 2, ''),
(37, 'SFA170', '*', 3, '[3.0,4]'),
(39, 'SFA900', '*', 1, ''),
(40, 'SFA900', '*', 2, ''),
(41, 'MEMSCH', '*', 1, ''),
(42, 'MEMSCH', '*', 2, ''),
(43, 'MEMSCH', '*', 3, '[2.5,4]'),
(44, 'SFA950', '*', 1, ''),
(45, 'SFA950', '*', 2, ''),
(46, 'SFA950', '*', 3, '[3.5,4]'),
(47, 'SFA950', '*', 6, '["Good"]'),
(48, 'SFA890', '*', 4, '["Freshman","Sophomore","Junior","Senior","Graduate"]'),
(49, 'SFA890', '*', 5, '[9,18]'),
(50, 'SFA910', '*', 1, ''),
(51, 'SFA910', '*', 2, ''),
(52, 'SFA910', '*', 4, '["Freshman","Sophomore","Junior","Senior","Graduate"]'),
(53, 'SFA500', '*', 3, '[3.0,4]'),
(54, 'SFA500', '*', 5, '[12,18]'),
(55, 'BUSSCH', '*', 4, '["Graduate"]'),
(56, 'SFA440', '*', 1, ''),
(57, 'SFA440', '*', 2, ''),
(58, 'SFA440', '*', 3, '[2.5,4]'),
(59, 'SFA840', '*', 1, ''),
(60, 'SFA840', '*', 2, ''),
(61, 'SFA840', '*', 3, '[3.0,4]'),
(62, 'SFA840', '*', 4, '["Freshman","Sophomore","Junior","Senior","Graduate"]'),
(63, 'SFA020', '*', 1, ''),
(64, 'SFA020', '*', 2, ''),
(65, 'SFA020', '*', 3, '[2.0,4]'),
(67, 'SFA529', '*', 1, ''),
(68, 'SFA529', '*', 2, ''),
(69, 'SFA930', '*', 1, ''),
(70, 'SFA930', '*', 2, ''),
(71, 'SFA930', '*', 5, '[12,18]'),
(72, 'SFA871', '*', 1, ''),
(73, 'SFA871', '*', 2, ''),
(74, 'SFA871', '*', 3, '[3.25,4]'),
(75, 'SFA871', '*', 4, '["Freshman","Sophomore","Junior","Senior","Graduate"]'),
(76, 'SFA360', '*', 1, ''),
(77, 'SFA360', '*', 2, ''),
(78, 'SFA360', '*', 4, '["Junior","Senior"]'),
(79, 'SFA210', '*', 1, ''),
(80, 'SFA210', '*', 2, ''),
(81, 'SFA210', '*', 4, '["Sophomore","Junior","Senior"]'),
(82, 'SFA220', '*', 1, ''),
(83, 'SFA220', '*', 2, ''),
(84, 'SFA220', '*', 3, '[3.0,4]'),
(87, 'SKPSCH', '*', 3, '[3.0,4]'),
(88, 'SKPSCH', '*', 4, '["Freshman","Sophomore","Junior","Senior","Graduate"]'),
(89, 'SGASCH', '*', 3, '[2.5,4]'),
(93, 'SFA100', '*', 1, ''),
(94, 'SFA100', '*', 2, ''),
(97, 'ADV996', '*', 1, ''),
(98, 'ADV996', '*', 2, ''),
(99, 'ADV996', '*', 6, '["Good"]'),
(103, 'SFA140', '*', 1, ''),
(104, 'SFA140', '*', 2, ''),
(105, 'SFA140', '*', 3, '[2.5,4]'),
(106, 'SFA140', '*', 5, '[6,18]'),
(107, 'SFA041', '*', 1, ''),
(108, 'SFA041', '*', 3, '[3.0,4]'),
(109, 'SFA041', '*', 4, '["Sophomore","Junior","Senior","Graduate"]'),
(110, 'SFA520', '*', 2, ''),
(111, 'SFA290', '*', 4, '["Freshman"]'),
(112, 'MLKSCH', '*', 1, ''),
(113, 'MLKSCH', '*', 2, ''),
(114, 'MLKSCH', '*', 4, '["Freshman"]'),
(115, 'SFA365', '*', 1, ''),
(116, 'SFA365', '*', 2, ''),
(117, 'SFA365', '*', 3, '[3.3,4]'),
(118, 'SFA365', '*', 4, '["Freshman"]'),
(119, 'TEASCH', '*', 2, ''),
(120, 'TEASCH', '*', 3, '[3.0,4]'),
(121, 'SFA055', '*', 2, ''),
(122, 'SFA055', '*', 3, '[3.0,4]'),
(124, 'SFA085', '*', 3, '[3,4]'),
(125, 'ADV998', '*', 2, ''),
(126, 'ADV998', '*', 6, '["Good"]'),
(127, 'BUS836', '*', 4, '["Junior", "Senior", "Graduate"]'),
(128, 'BUS836', '*', 3, '[3.0, 4]'),
(129, 'BUS836', '*', 6, '["Good"]'),
(130, 'BUS836', '*', 8, '["College of Business"]'),
(131, 'SFA020', 'a', 4, '["Graduate"]'),
(132, 'SFA020', 'a', 5, '[5,18]'),
(133, 'SFA020', 'b', 4, '["Freshman","Sophomore","Junior","Senior"]'),
(134, 'SFA020', 'b', 5, '[6,18]'),
(135, 'SFA025', '*', 8, '["College of Education"]'),
(136, 'SFA055', 'a', 4, '["Graduate"]'),
(137, 'SFA055', 'a', 5, '[9,18]'),
(138, 'SFA055', 'b', 4, '["Freshman","Sophomore","Junior","Senior"]'),
(139, 'SFA055', 'b', 5, '[12,18]'),
(140, 'SFA060', 'a', 4, '["Graduate"]'),
(141, 'SFA060', 'a', 5, '[9,18]'),
(142, 'SFA060', 'b', 4, '["Freshman","Sophomore","Junior","Senior"]'),
(143, 'SFA060', 'b', 5, '[12,18]'),
(144, 'SFA100', 'a', 4, '["Graduate"]'),
(145, 'SFA100', 'a', 5, '[5,18]'),
(146, 'SFA100', 'b', 4, '["Freshman","Sophomore","Junior","Senior"]'),
(147, 'SFA100', 'b', 5, '[6,18]'),
(148, 'SFA150', 'a', 4, '["Graduate"]'),
(149, 'SFA150', 'a', 5, '[9,18]'),
(150, 'SFA150', 'b', 4, '["Freshman","Sophomore","Junior","Senior"]'),
(151, 'SFA150', 'b', 5, '[12,18]'),
(152, 'SFA170', 'a', 4, '["Graduate"]'),
(153, 'SFA170', 'a', 5, '[9,18]'),
(154, 'SFA170', 'b', 4, '["Freshman","Sophomore","Junior","Senior"]'),
(155, 'SFA170', 'b', 5, '[12,18]'),
(156, 'SGASCH', 'a', 4, '["Graduate"]'),
(157, 'SGASCH', 'a', 5, '[5,18]'),
(158, 'SGASCH', 'b', 4, '["Freshman","Sophomore","Junior","Senior"]'),
(159, 'SGASCH', 'b', 5, '[6,18]'),
(160, 'SFA240', 'a', 3, '[2.5,4]'),
(161, 'SFA240', 'a', 4, '["Graduate"]'),
(162, 'SFA240', 'a', 5, '[5,18]'),
(163, 'SFA240', 'b', 3, '[2.5,4]'),
(164, 'SFA240', 'b', 4, '["Sophomore","Junior","Senior"]'),
(165, 'SFA240', 'b', 5, '[6,18]'),
(166, 'SFA240', 'c', 4, '["Freshman"]'),
(167, 'SFA240', 'c', 5, '[6,18]'),
(168, 'SFA135', '*', 1, ''),
(169, 'SFA135', '*', 2, ''),
(170, 'SFA135', 'a', 4, '["Freshman"]'),
(171, 'SFA135', 'b', 9, ''),
(172, 'SFA125', '*', 4, '["Freshman","Sophomore","Junior","Senior"]'),
(173, 'SFA140', '*', 4, '["Freshman","Sophomore","Junior","Senior"]'),
(174, 'SFA155', '*', 1, ''),
(175, 'SFA220', '*', 5, '[6,18]'),
(176, 'SFA290', '*', 7, '["Anthropology", "Criminal Justice", "Economics", "Geography", "Health Administration", "Political Science", "Social Work", "Sociology" ]'),
(177, 'SFA590', '*', 1, ''),
(178, 'SFA840', '*', 8, '["College For Design and Social Inquiry", "Charles E. Schmidt College of Medicine", "College of Business", "College of Education", "College of Engineering and Computer Science", "Christine E. Lynn College of Nursing", "Charles E. Schmidt College of Science"]'),
(179, 'SFA930', '*', 4, '["Freshman","Sophomore","Junior","Senior"]'),
(180, 'TEASCH', '*', 9, ''),
(181, 'TEASCH', '*', 4, '["Junior"]'),
(182, 'SFA085', '*', 1, ''),
(183, 'SFA085', '*', 7, '["*"]'),
(184, 'SFA500', '*', 4, '["Freshman","Sophomore","Junior","Senior"]'),
(185, 'SFA500', '*', 8, '["College of Business", "College of Engineering and Computer Science", "Charles E. Schmidt College of Science"]'),
(186, 'SFA120', '*', 1, ''),
(187, 'SFA120', '*', 2, ''),
(188, 'SFA120', '*', 6, '["Good"]'),
(189, 'SFA371', '*', 1, ''),
(190, 'SFA371', '*', 2, ''),
(191, 'SFA371', '*', 6, '["Good"]'),
(192, 'SFA710', '*', 1, ''),
(193, 'SFA710', '*', 6, '["Good"]'),
(194, 'SFA710', '*', 8, '["College of Engineering and Computer Science", "Christine E. Lynn College of Nursing"]'),
(195, 'SFA875', '*', 1, ''),
(196, 'SFA875', '*', 2, ''),
(197, 'SFA875', '*', 6, '["Good"]'),
(198, 'SFA790', '*', 1, ''),
(199, 'SFA790', '*', 2, ''),
(200, 'SFA790', '*', 6, '["Good"]'),
(201, 'SFA920', '*', 1, ''),
(202, 'SFA920', '*', 2, ''),
(203, 'SFA920', '*', 3, '[2.5,4]'),
(204, 'SFA490', '*', 1, ''),
(205, 'SFA490', '*', 2, ''),
(206, 'SFA490', '*', 3, '[3.0,4]'),
(207, 'SFA490', '*', 4, '["Freshman","Sophomore","Junior","Senior"]'),
(208, 'SFA490', '*', 5, '[12,18]'),
(209, 'SFA905', '*', 1, ''),
(210, 'SFA905', '*', 3, '[2.7,4]'),
(211, 'SFA905', '*', 4, '["Junior", "Senior"]'),
(212, 'SFA905', '*', 5, '[9,18]'),
(213, 'SFA905', '*', 6, '["Good"]'),
(214, 'SFA940', '*', 1, ''),
(215, 'SFA940', '*', 2, ''),
(216, 'SFA940', '*', 3, '[2.8,4]'),
(217, 'SFA940', '*', 4, '["Freshman","Sophomore","Junior","Senior"]'),
(218, 'SFA940', '*', 5, '[9,18]'),
(219, 'SFA215', '*', 1, ''),
(220, 'SFA215', '*', 2, ''),
(221, 'SFA215', '*', 3, '[2.5,4]'),
(222, 'SFA215', '*', 4, '["Freshman","Sophomore","Junior","Senior"]'),
(223, 'SFA215', '*', 5, '[6,18]'),
(224, 'SFA215', '*', 7, '["Hospitality Management"]');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `znumber` varchar(9) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_file`
--

CREATE TABLE `student_file` (
  `id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  `znumber` varchar(9) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_qualifier`
--

CREATE TABLE `student_qualifier` (
  `znumber` varchar(9) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qualifier_id` int(11) NOT NULL,
  `value` varchar(4096) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `password`) VALUES
(1, 'admin', '$2y$10$AQhC7DrVhSZ1SFs3kBOlEOwJ0fK1LlGZchUE/cfv75O2yWKKbAjou');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `application`
--
ALTER TABLE `application`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `znumber` (`znumber`,`code`),
  ADD KEY `application_ibfk_2` (`code`);

--
-- Indexes for table `application_answers`
--
ALTER TABLE `application_answers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `application` (`application_id`,`question_id`) USING BTREE,
  ADD KEY `question` (`question_id`);

--
-- Indexes for table `file`
--
ALTER TABLE `file`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `md5` (`md5`) USING BTREE;

--
-- Indexes for table `qualifier`
--
ALTER TABLE `qualifier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `scholarship`
--
ALTER TABLE `scholarship`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `scholarship_questions`
--
ALTER TABLE `scholarship_questions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`,`question`),
  ADD KEY `questionID` (`question`);

--
-- Indexes for table `scholarship_requirements`
--
ALTER TABLE `scholarship_requirements`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `qualifier` (`sch_code`,`category`,`qualifier_id`) USING BTREE,
  ADD KEY `qualifier_id` (`qualifier_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`znumber`);

--
-- Indexes for table `student_file`
--
ALTER TABLE `student_file`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `file_id` (`file_id`,`znumber`),
  ADD KEY `znumber` (`znumber`);

--
-- Indexes for table `student_qualifier`
--
ALTER TABLE `student_qualifier`
  ADD PRIMARY KEY (`znumber`),
  ADD UNIQUE KEY `znumber` (`znumber`,`qualifier_id`),
  ADD KEY `qualifier` (`qualifier_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user` (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `application`
--
ALTER TABLE `application`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `application_answers`
--
ALTER TABLE `application_answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `file`
--
ALTER TABLE `file`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `qualifier`
--
ALTER TABLE `qualifier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `scholarship`
--
ALTER TABLE `scholarship`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;
--
-- AUTO_INCREMENT for table `scholarship_questions`
--
ALTER TABLE `scholarship_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;
--
-- AUTO_INCREMENT for table `scholarship_requirements`
--
ALTER TABLE `scholarship_requirements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=280;
--
-- AUTO_INCREMENT for table `student_file`
--
ALTER TABLE `student_file`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `application`
--
ALTER TABLE `application`
  ADD CONSTRAINT `application_ibfk_1` FOREIGN KEY (`znumber`) REFERENCES `student` (`znumber`),
  ADD CONSTRAINT `application_ibfk_2` FOREIGN KEY (`code`) REFERENCES `scholarship` (`code`);

--
-- Constraints for table `application_answers`
--
ALTER TABLE `application_answers`
  ADD CONSTRAINT `application_answers_ibfk_1` FOREIGN KEY (`application_id`) REFERENCES `application` (`id`),
  ADD CONSTRAINT `application_answers_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `question` (`id`);

--
-- Constraints for table `scholarship_questions`
--
ALTER TABLE `scholarship_questions`
  ADD CONSTRAINT `scholarship_questions_ibfk_1` FOREIGN KEY (`code`) REFERENCES `scholarship` (`code`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `scholarship_questions_ibfk_2` FOREIGN KEY (`question`) REFERENCES `question` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `scholarship_requirements`
--
ALTER TABLE `scholarship_requirements`
  ADD CONSTRAINT `scholarship_requirements_ibfk_1` FOREIGN KEY (`qualifier_id`) REFERENCES `qualifier` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `scholarship_requirements_ibfk_2` FOREIGN KEY (`sch_code`) REFERENCES `scholarship` (`code`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student_file`
--
ALTER TABLE `student_file`
  ADD CONSTRAINT `student_file_ibfk_1` FOREIGN KEY (`file_id`) REFERENCES `file` (`id`),
  ADD CONSTRAINT `student_file_ibfk_2` FOREIGN KEY (`znumber`) REFERENCES `student` (`znumber`) ON DELETE CASCADE;

--
-- Constraints for table `student_qualifier`
--
ALTER TABLE `student_qualifier`
  ADD CONSTRAINT `student_qualifier_ibfk_1` FOREIGN KEY (`znumber`) REFERENCES `student` (`znumber`),
  ADD CONSTRAINT `student_qualifier_ibfk_2` FOREIGN KEY (`qualifier_id`) REFERENCES `qualifier` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
