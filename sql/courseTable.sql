
CREATE TABLE Users_tbl(
   user_id CHAR(8) Not Null,
    user_name VARCHAR(255) Not Null,
    user_email VARCHAR(255) Not Null,
    user_password VARCHAR(255) Not Null,
    user_role VARCHAR(20) NOT NULL,
   PRIMARY KEY ( user_id )
   );
   select * from Users_tbl;
       INSERT INTO Users_tbl (user_id,user_name,user_email,user_password,user_role) VALUES (4023, 'victor praise','vpraise27@gmail.com','$2y$10$aiHSsEs9CNG0LTY7hk1sueMDneXSzYVu6KZRK40NwckuP3IOJK4ii','admin');

   INSERT INTO Users_tbl (user_id,user_name,user_email,user_password,user_role) VALUES (4024, 'david igwe','vpraise27@gmail.com','$2y$10$aiHSsEs9CNG0LTY7hk1sueMDneXSzYVu6KZRK40NwckuP3IOJK4ii','student');
   INSERT INTO Users_tbl (user_id,user_name,user_email,user_password,user_role) VALUES (4025, 'Bipin Desai','vpraise27@gmail.com','$2y$10$aiHSsEs9CNG0LTY7hk1sueMDneXSzYVu6KZRK40NwckuP3IOJK4ii','instructor');
   INSERT INTO Users_tbl (user_id,user_name,user_email,user_password,user_role) VALUES (4026, 'Yogesh Yadav','vpraise27@gmail.com','$2y$10$aiHSsEs9CNG0LTY7hk1sueMDneXSzYVu6KZRK40NwckuP3IOJK4ii','ta');
   INSERT INTO Users_tbl (user_id,user_name,user_email,user_password,user_role) VALUES (4027, 'Stuart Atwell','vpraise27@gmail.com','$2y$10$aiHSsEs9CNG0LTY7hk1sueMDneXSzYVu6KZRK40NwckuP3IOJK4ii','instructor');
   INSERT INTO Users_tbl (user_id,user_name,user_email,user_password,user_role) VALUES (4028, 'Cristiano Ronaldo','vpraise27@gmail.com','$2y$10$aiHSsEs9CNG0LTY7hk1sueMDneXSzYVu6KZRK40NwckuP3IOJK4ii','instructor');
   INSERT INTO Users_tbl (user_id,user_name,user_email,user_password,user_role) VALUES (4029, 'Lionel Messi','vpraise27@gmail.com','$2y$10$aiHSsEs9CNG0LTY7hk1sueMDneXSzYVu6KZRK40NwckuP3IOJK4ii','student');
	INSERT INTO Users_tbl (user_id,user_name,user_email,user_password,user_role) VALUES (4030, 'Federico Chiesa','vpraise27@gmail.com','$2y$10$aiHSsEs9CNG0LTY7hk1sueMDneXSzYVu6KZRK40NwckuP3IOJK4ii','student');
	INSERT INTO Users_tbl (user_id,user_name,user_email,user_password,user_role) VALUES (4031, 'Romelu Lukaku','vpraise27@gmail.com','$2y$10$aiHSsEs9CNG0LTY7hk1sueMDneXSzYVu6KZRK40NwckuP3IOJK4ii','student');
	 INSERT INTO Users_tbl (user_id,user_name,user_email,user_password,user_role) VALUES (4032, 'Phil Foden','vpraise27@gmail.com','$2y$10$aiHSsEs9CNG0LTY7hk1sueMDneXSzYVu6KZRK40NwckuP3IOJK4ii','ta');
	 INSERT INTO Users_tbl (user_id,user_name,user_email,user_password,user_role) VALUES (4033, 'Reece James','vpraise27@gmail.com','$2y$10$aiHSsEs9CNG0LTY7hk1sueMDneXSzYVu6KZRK40NwckuP3IOJK4ii','ta');
     
	INSERT INTO Users_tbl (user_id,user_name,user_email,user_password,user_role) VALUES (4034, 'Bruno Fernandes','vpraise27@gmail.com','$2y$10$aiHSsEs9CNG0LTY7hk1sueMDneXSzYVu6KZRK40NwckuP3IOJK4ii','student');
		INSERT INTO Users_tbl (user_id,user_name,user_email,user_password,user_role) VALUES (4035, 'Sadio Mane','vpraise27@gmail.com','$2y$10$aiHSsEs9CNG0LTY7hk1sueMDneXSzYVu6KZRK40NwckuP3IOJK4ii','student');
		INSERT INTO Users_tbl (user_id,user_name,user_email,user_password,user_role) VALUES (4036, 'Van Dijk','vpraise27@gmail.com','$2y$10$aiHSsEs9CNG0LTY7hk1sueMDneXSzYVu6KZRK40NwckuP3IOJK4ii','student');
		INSERT INTO Users_tbl (user_id,user_name,user_email,user_password,user_role) VALUES (4037, 'Jadon Sancho','vpraise27@gmail.com','$2y$10$aiHSsEs9CNG0LTY7hk1sueMDneXSzYVu6KZRK40NwckuP3IOJK4ii','student');


-- select * from users_tbl;
-- select * from role_tbl;
-- select * from Instructor_tbl;
 select * from Ta_tbl;
select * from Users_tbl;
  INSERT INTO Student_tbl (user_id,course_id) VALUES (4031,163708);
CREATE TABLE CourseSection_tbl(
   course_id char(12),
    course_name varchar(255),
    course_subject char(4),
    course_number varchar(255),
    course_section varchar(255),
course_term varchar(255),
course_year char(4),
PRIMARY KEY ( course_id )
   );
  select * from CourseSection_tbl;

 CREATE TABLE Instructor_tbl(
	Role_id int auto_increment,
	user_id char(8),
	course_id char(12),
	primary key(Role_id),
	foreign key (user_id) references Users_tbl(user_id) on delete cascade,
	foreign key (course_id) references CourseSection_tbl(course_id) on delete cascade
   );
 CREATE TABLE Student_tbl(
	Role_id int auto_increment,
	user_id char(8),
	course_id char(12),
	primary key(Role_id),
	foreign key (user_id) references Users_tbl(user_id) on delete cascade,
	foreign key (course_id) references CourseSection_tbl(course_id) on delete cascade
   );
 select * from Student_tbl;
    CREATE TABLE Ta_tbl(
	Role_id int auto_increment,
	user_id char(8),
	course_id char(12),
	primary key(Role_id),
	foreign key (user_id) references Users_tbl(user_id) on delete cascade,
	foreign key (course_id) references CourseSection_tbl(course_id) on delete cascade
   );

   select * from ta_tbl;
CREATE TABLE Announcement_tbl(
	id int auto_increment NOT NULL,
	announcement text,
	PRIMARY KEY (`id`)	
   );
   select * from Announcement_tbl;
CREATE TABLE Group_tbl(
   group_id char(12) Primary Key,
   course_id char(12),
    group_name char(12),
   group_order int,
   leader_user_id char(8),
   FOREIGN Key (course_id) REFERENCES CourseSection_tbl(course_id) on delete cascade
   );
   

CREATE TABLE GroupMember_tbl(
groupMember_id int auto_increment primary key,
   group_id char(12),
   user_id char(8),
   dateJoined datetime,

   FOREIGN KEY (user_id) REFERENCES Users_tbl(user_id) on delete cascade,
   FOREIGN KEY (group_id) REFERENCES Group_tbl(group_id) on delete cascade
   );
   

CREATE TABLE RemovedGroupMember_tbl(
	removedMember_id int auto_increment primary key,
    group_id char(12),
    course_id char(12),
	user_id char(8),
    dateLeft datetime,
	FOREIGN KEY (user_id) REFERENCES Users_tbl(user_id) on delete cascade,
	FOREIGN KEY (group_id) REFERENCES Group_tbl(group_id) on delete cascade
);
select * from RemovedGroupMember_tbl;


-- --removes student from group member table 
DELIMITER //
CREATE TRIGGER remove_deleted_student
AFTER DELETE
ON Student_tbl FOR EACH ROW
BEGIN
DELETE FROM GroupMember_tbl WHERE user_id=old.user_id;
END; //
DELIMITER ;
CREATE TABLE GroupMarked_tbl(
   GME_id char(12) primary key,
   course_id char(12),
   file_name varchar(255) NOT NULL,
   entity_name char(20),
   file_type varchar(255),
   deadline date NOT NULL,
   start_date datetime,
   foreign key (course_id) references CourseSection_tbl(course_id) on delete cascade
   );
   select * from GroupMarked_tbl;
select * from FinalSubmission_tbl;
select * from GroupMarked_tbl where deadline < '2022-05-12';
CREATE TABLE FinalSubmission_tbl(
   submission_id char(20) primary key,
   group_id char(12),
   GME_id char(12),
   user_id char(8),
   file_name varchar(255) NOT NULL,
	file_type varchar(255),
   submission_date datetime NOT NULL,
   FOREIGN KEY (user_id) REFERENCES Users_tbl(user_id) on delete cascade,
   FOREIGN KEY (group_id) REFERENCES Group_tbl(group_id) on delete cascade,
   FOREIGN KEY (GME_id) REFERENCES GroupMarked_tbl(GME_id) on delete cascade
   );
 

CREATE TABLE Poll_tbl(
	id char(12) NOT NULL,
	title text NOT NULL,
	description text,
	course_id char(12),
	PRIMARY KEY (`id`),
	FOREIGN Key (course_id) REFERENCES CourseSection_tbl(course_id) on delete cascade
   );
 
   CREATE TABLE PollAnswers_tbl(
	id int NOT NULL AUTO_INCREMENT primary key,
    poll_id char(12) NOT NULL,
	title text NOT NULL,
    votes int NOT NULL DEFAULT '0',
    FOREIGN Key (poll_id) REFERENCES Poll_tbl(id) on delete cascade
   );
CREATE TABLE StudentVote_tbl(
	id int NOT NULL AUTO_INCREMENT primary key,
    poll_id char(12) NOT NULL,
	user_id char(8),
    FOREIGN Key (poll_id) REFERENCES Poll_tbl(id) on delete cascade,
    FOREIGN KEY (user_id) REFERENCES Users_tbl(user_id) on delete cascade
   );
 
CREATE TABLE DiscussionPagesPost_tbl(
   post_id char(20) primary key,
   post_text varchar(255),
   GME_id char(12),
   user_id char(8),
   post_date date,
   post_time time,
FOREIGN KEY (user_id) REFERENCES Users_tbl(user_id),
FOREIGN KEY (GME_id) REFERENCES GroupMarked_tbl(GME_id)
   );
   

CREATE TABLE DiscussionReply_tbl(
   reply_id char(20) primary key,
   post_id char(20),
   reply_text varchar(255),
   user_id char(8),
   reply_date date,
   reply_time time,
   FOREIGN KEY (user_id) REFERENCES Users_tbl(user_id),
FOREIGN KEY (post_id) REFERENCES DiscussionPagesPost_tbl(post_id)
   );
   

CREATE TABLE DiscussionSuggestion_tbl(
   sugguestion_id char(20) primary key,
   post_id char(20),
   sugguestion_text varchar(255),
   user_id char(8),
   suggestion_date date,
   suggestion_time time,
FOREIGN KEY (user_id) REFERENCES Users_tbl(user_id),
FOREIGN KEY (post_id) REFERENCES DiscussionPagesPost_tbl(post_id)
   );
   

CREATE TABLE File_tbl(
   file_id char(12) primary key,
   user_id char(8),
   GME_id char(12),
   file_content Blob(255),
   file_date date,
   file_time time,
   file_visibility_type varchar(255),
   file_permission varchar(255),
   FOREIGN KEY (user_id) REFERENCES Users_tbl(user_id),
   FOREIGN KEY (GME_id) REFERENCES GroupMarked_tbl(GME_id)
   );
   
select * from FileAuditHistory_tbl;
CREATE TABLE FileAuditHistory_tbl(
   history_id char(20) primary key,
   file_id char(12),
   user_id char(8),
   file_action varchar(255),
   history_date date,
   history_time time,
   FOREIGN KEY (user_id) REFERENCES Users_tbl(user_id),
   FOREIGN KEY (file_id) REFERENCES File_tbl(file_id)
   );
   
   
select * from PrivateMessage_tbl;
SELECT DISTINCT * FROM PrivateMessage_tbl WHERE from_user = 4024 ORDER BY msg_id;
SELECT DISTINCT from_user FROM PrivateMessage_tbl WHERE to_user = 4037 ORDER BY msg_id;
SELECT DISTINCT * FROM PrivateMessage_tbl WHERE from_user = 4024 AND to_user = 4037 ORDER BY msg_date ASC, msg_time DESC;
SELECT * FROM PrivateMessage_tbl WHERE from_user = 4037 AND to_user = 4024 ORDER BY msg_id DESC;


CREATE TABLE PrivateMessage_tbl(
   msg_id char(20) primary key,
   msg_text varchar(255),
   group_id char(12),
   user_id char(8),
   msg_date date,
   
   msg_time time,
   FOREIGN KEY (user_id) REFERENCES Users_tbl(user_id),
   FOREIGN KEY (group_id) REFERENCES Group_tbl(group_id)
   );
select * from Users_tbl;
select current_date();