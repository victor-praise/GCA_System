  CREATE TABLE `Users_tbl` (
  `user_id` char(8) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_fullname` varchar(255) DEFAULT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_role` varchar(20) NOT NULL,
  PRIMARY KEY (`user_id`)
);
INSERT INTO Users_tbl (user_id,user_name,user_fullname,user_email,user_password,user_role) VALUES (4023, 'v_nwatu','victor praise','vpraise27@gmail.com','$2y$10$aiHSsEs9CNG0LTY7hk1sueMDneXSzYVu6KZRK40NwckuP3IOJK4ii','admin');

   
CREATE TABLE `CourseSection_tbl` (
  `course_id` char(12) NOT NULL,
  `course_name` varchar(255) DEFAULT NULL,
  `course_subject` char(4) DEFAULT NULL,
  `course_number` varchar(255) DEFAULT NULL,
  `course_section` varchar(255) DEFAULT NULL,
  `course_term` varchar(255) DEFAULT NULL,
  `course_year` char(4) DEFAULT NULL,
  PRIMARY KEY (`course_id`)
);
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
 
    CREATE TABLE Ta_tbl(
	Role_id int auto_increment,
	user_id char(8),
	course_id char(12),
	primary key(Role_id),
	foreign key (user_id) references Users_tbl(user_id) on delete cascade,
	foreign key (course_id) references CourseSection_tbl(course_id) on delete cascade
   );

   
CREATE TABLE Announcement_tbl(
	id int auto_increment NOT NULL,
	announcement text,
	PRIMARY KEY (`id`)	
   );
 
 CREATE TABLE `Group_tbl` (
  `group_id` char(12) NOT NULL,
  `course_id` char(12) DEFAULT NULL,
  `group_name` char(12) DEFAULT NULL,
  `leader_user_id` char(8) DEFAULT NULL,
  PRIMARY KEY (`group_id`),
  KEY `course_id` (`course_id`),
  CONSTRAINT `Group_tbl_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `CourseSection_tbl` (`course_id`) ON DELETE CASCADE
);

   CREATE TABLE `GroupMember_tbl` (
  `groupMember_id` int NOT NULL AUTO_INCREMENT,
  `group_id` char(12) DEFAULT NULL,
  `user_id` char(8) DEFAULT NULL,
  `dateJoined` datetime DEFAULT NULL,
  PRIMARY KEY (`groupMember_id`),
  KEY `user_id` (`user_id`),
  KEY `group_id` (`group_id`),
  CONSTRAINT `GroupMember_tbl_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users_tbl` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `GroupMember_tbl_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `Group_tbl` (`group_id`) ON DELETE CASCADE
);

   CREATE TABLE `RemovedGroupMember_tbl` (
  `removedMember_id` int NOT NULL AUTO_INCREMENT,
  `group_id` char(12) DEFAULT NULL,
  `course_id` char(12) DEFAULT NULL,
  `user_id` char(8) DEFAULT NULL,
  `dateLeft` datetime DEFAULT NULL,
  PRIMARY KEY (`removedMember_id`),
  KEY `user_id` (`user_id`),
  KEY `group_id` (`group_id`),
  CONSTRAINT `RemovedGroupMember_tbl_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users_tbl` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `RemovedGroupMember_tbl_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `Group_tbl` (`group_id`) ON DELETE CASCADE
);
-- --removes student from group member table 
DELIMITER //
CREATE TRIGGER remove_deleted_student
AFTER DELETE
ON Student_tbl FOR EACH ROW
BEGIN
DELETE FROM GroupMember_tbl WHERE user_id=old.user_id;
END; //
DELIMITER ;

CREATE TABLE `GroupMarked_tbl` (
  `GME_id` char(12) NOT NULL,
  `course_id` char(12) DEFAULT NULL,
  `file_name` varchar(255) NOT NULL,
  `entity_name` char(20) DEFAULT NULL,
  `file_type` varchar(255) DEFAULT NULL,
  `deadline` date NOT NULL,
  `start_date` datetime DEFAULT NULL,
  PRIMARY KEY (`GME_id`),
  KEY `course_id` (`course_id`),
  CONSTRAINT `GroupMarked_tbl_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `CourseSection_tbl` (`course_id`) ON DELETE CASCADE
);
  

CREATE TABLE `FinalSubmission_tbl` (
  `submission_id` char(20) NOT NULL,
  `group_id` char(12) DEFAULT NULL,
  `GME_id` char(12) DEFAULT NULL,
  `user_id` char(8) DEFAULT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_type` varchar(255) DEFAULT NULL,
  `submission_date` datetime NOT NULL,
  PRIMARY KEY (`submission_id`),
  KEY `user_id` (`user_id`),
  KEY `group_id` (`group_id`),
  KEY `GME_id` (`GME_id`),
  CONSTRAINT `FinalSubmission_tbl_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users_tbl` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `FinalSubmission_tbl_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `Group_tbl` (`group_id`) ON DELETE CASCADE,
  CONSTRAINT `FinalSubmission_tbl_ibfk_3` FOREIGN KEY (`GME_id`) REFERENCES `GroupMarked_tbl` (`GME_id`) ON DELETE CASCADE
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
 
 CREATE TABLE `DiscussionPagesPost_tbl` (
  `post_id` char(20) NOT NULL,
  `post_text` varchar(2000) DEFAULT NULL,
  `GME_id` char(12) DEFAULT NULL,
  `user_id` char(8) DEFAULT NULL,
  `post_date` date DEFAULT NULL,
  `post_time` time DEFAULT NULL,
  `group_id` varchar(255) DEFAULT NULL,
  `course_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`post_id`),
  KEY `user_id` (`user_id`),
  KEY `GME_id` (`GME_id`),
  CONSTRAINT `DiscussionPagesPost_tbl_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users_tbl` (`user_id`),
  CONSTRAINT `DiscussionPagesPost_tbl_ibfk_2` FOREIGN KEY (`GME_id`) REFERENCES `GroupMarked_tbl` (`GME_id`)
);
   
CREATE TABLE `DiscussionReply_tbl` (
  `reply_id` char(20) NOT NULL,
  `post_id` char(20) DEFAULT NULL,
  `reply_text` varchar(2000) DEFAULT NULL,
  `user_id` char(8) DEFAULT NULL,
  `reply_date` date DEFAULT NULL,
  `reply_time` time DEFAULT NULL,
  PRIMARY KEY (`reply_id`),
  KEY `user_id` (`user_id`),
  KEY `post_id` (`post_id`),
  CONSTRAINT `DiscussionReply_tbl_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users_tbl` (`user_id`),
  CONSTRAINT `DiscussionReply_tbl_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `DiscussionPagesPost_tbl` (`post_id`)
);

   

CREATE TABLE `File_tbl` (
  `file_id` char(12) NOT NULL,
  `user_id` char(8) DEFAULT NULL,
  `GME_id` char(12) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_date` date DEFAULT NULL,
  `group_id` varchar(255) DEFAULT NULL,
  `file_permission` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`file_id`),
  KEY `user_id` (`user_id`),
  KEY `GME_id` (`GME_id`),
  CONSTRAINT `File_tbl_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users_tbl` (`user_id`),
  CONSTRAINT `File_tbl_ibfk_2` FOREIGN KEY (`GME_id`) REFERENCES `GroupMarked_tbl` (`GME_id`)
);


CREATE TABLE `FileAuditHistory_tbl` (
  `history_id` char(20) NOT NULL,
  `user_id` char(8) DEFAULT NULL,
  `file_action` varchar(255) DEFAULT NULL,
  `history_date` date DEFAULT NULL,
  `history_time` time DEFAULT NULL,
  `group_id` char(12) DEFAULT NULL,
  `GME_id` char(12) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `update_file_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`history_id`),
  KEY `FileAuditHistory_tbl_ibfk_1` (`user_id`),
  CONSTRAINT `FileAuditHistory_tbl_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users_tbl` (`user_id`) ON DELETE CASCADE
);

-- --triggers to update file history table 
DELIMITER $$
CREATE TRIGGER after_file_update
AFTER UPDATE
ON File_tbl FOR EACH ROW
BEGIN
DECLARE id char(20);
SELECT (FLOOR(RAND()*(9999999-1000000+1))+1000000) Into id;
        INSERT INTO FileAuditHistory_tbl(history_id, user_id, file_action, history_date, history_time,group_id,GME_id,file_name,update_file_name)
        VALUES(id,new.user_id,'insert',current_date(),current_time(),new.group_id,new.GME_id,old.file_name,new.file_name);
END$$

DELIMITER ;


DELIMITER $$

CREATE TRIGGER after_file_insert
AFTER INSERT
ON File_tbl FOR EACH ROW
BEGIN
DECLARE id char(20);
SELECT (FLOOR(RAND()*(9999999-1000000+1))+1000000) Into id;
        INSERT INTO FileAuditHistory_tbl(history_id, user_id, file_action, history_date, history_time,group_id,GME_id,file_name)
        VALUES(id,new.user_id,'insert',current_date(),current_time(),new.group_id,new.GME_id,new.file_name);
END$$

DELIMITER ;

DELIMITER $$

CREATE TRIGGER after_file_delete
AFTER DELETE
ON File_tbl FOR EACH ROW
BEGIN
DECLARE id char(20);
SELECT (FLOOR(RAND()*(9999999-1000000+1))+1000000) Into id;
        INSERT INTO FileAuditHistory_tbl(history_id, user_id, file_action, history_date, history_time,group_id,GME_id,file_name)
        VALUES(id,old.user_id,'delete',current_date(),current_time(),old.group_id,old.GME_id,old.file_name);
END$$

DELIMITER ;
  
CREATE TABLE `PrivateMessage_tbl` (
  `msg_id` int NOT NULL AUTO_INCREMENT,
  `msg_text` varchar(2000) NOT NULL,
  `from_user` char(8) DEFAULT NULL,
  `to_user` char(8) DEFAULT NULL,
  `msg_date` date DEFAULT NULL,
  `msg_time` time DEFAULT NULL,
  PRIMARY KEY (`msg_id`),
  KEY `from_user` (`from_user`),
  KEY `to_user` (`to_user`),
  CONSTRAINT `PrivateMessage_tbl_ibfk_1` FOREIGN KEY (`from_user`) REFERENCES `Users_tbl` (`user_id`),
  CONSTRAINT `PrivateMessage_tbl_ibfk_2` FOREIGN KEY (`to_user`) REFERENCES `Users_tbl` (`user_id`)
);
