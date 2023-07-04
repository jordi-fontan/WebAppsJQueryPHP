INSERT into course (title) values ('si106');
INSERT into course (title) values ('si110');
INSERT into course (title) values ('si206');
INSERT into `User` (name) values ('Burhan');

INSERT into `User` (name) values ('Kirstie');
INSERT into `User` (name) values ('Oghenedoro');
INSERT into `User` (name) values ('Ryhs');
INSERT into `User` (name) values ('Samara');



INSERT into `User` (name) values ('Vairi');
INSERT into `User` (name) values ('Daisy');
INSERT into `User` (name) values ('Hayleigh');
INSERT into `User` (name) values ('Kenan');
INSERT into `User` (name) values ('Muran');
INSERT into `User` (name) values ('Kaceylee');
INSERT into `User` (name) values ('Dylan');
INSERT into `User` (name) values ('Eleni');
INSERT into `User` (name) values ('Fyfe');
INSERT into `User` (name) values ('Rudi');

INSERT into Member  (user_id,course_id,role) values (1,1,1); 
INSERT into Member  (user_id,course_id,role) values(2,1,0); 
INSERT into Member  (user_id,course_id,role) values(3,1,0);
INSERT into Member  (user_id,course_id,role) values(4,1,0);
INSERT into Member  (user_id,course_id,role) values(5,1,0);

INSERT into Member  (user_id,course_id,role) values(6,2,1);
INSERT into Member  (user_id,course_id,role) values(7,2,0);
INSERT into Member  (user_id,course_id,role) values(8,2,0);
INSERT into Member  (user_id,course_id,role) values(9,2,0);
INSERT into Member  (user_id,course_id,role) values(10,2,0);

INSERT into Member  (user_id,course_id,role) values(11,3,1);
INSERT into Member  (user_id,course_id,role) values(12,3,0);
INSERT into Member  (user_id,course_id,role) values(13,3,0);
INSERT into Member  (user_id,course_id,role) values(14,3,0);
INSERT into Member  (user_id,course_id,role) values(15,3,0);






1,1,1 Burhan, si106, Instructor
2,1,0 Kirstie, si106, Learner
3,1,0 Oghenedoro, si106, Learner
4,1,0 Ryhs, si106, Learner
5,1,0 Samara, si106, Learner

6,2,1 Vairi, si110, Instructor
7,2,0 Daisy, si110, Learner
8,2,0 Hayleigh, si110, Learner
9,2,0 Kenan, si110, Learner
10,2,0 Muran, si110, Learner

11,3,1 Kaceylee, si206, Instructor
12,3,0 Dylan, si206, Learner
13,3,0 Eleni, si206, Learner
14,3,0 Fyfe, si206, Learner
15,3,0 Rudi, si206, Learner