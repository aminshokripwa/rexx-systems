CREATE TABLE participation (
                id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                participation_id INT(30) NOT NULL UNIQUE,
                employee_id INT(10) NOT NULL ,
                event_id INT(10) NOT NULL,
                participation_fee VARCHAR(30) NOT NULL,
                date_id INT(10) NOT NULL,
                versions CHAR(10) NULL,
                priorBerlin_afterwardsUTC CHAR(10) NOT NULL,
                INDEX covering_index (id,employee_id,event_id,date_id),
                CONSTRAINT fm_participation FOREIGN KEY(employee_id)  REFERENCES employee_list(id),
                CONSTRAINT fe_participation FOREIGN KEY(event_id)  REFERENCES event_list(id),
                CONSTRAINT fd_participation FOREIGN KEY(date_id)  REFERENCES date_list(id)
                )