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