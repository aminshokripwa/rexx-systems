CREATE TABLE event_list (
                id INT(10) NOT NULL PRIMARY KEY UNIQUE,
                event_name VARCHAR(50) NOT NULL,
                INDEX (`id`,`event_name`)
                )