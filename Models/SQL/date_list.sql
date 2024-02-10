CREATE TABLE date_list (
                id INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                event_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP UNIQUE,
                UNIQUE INDEX (`id`,`event_date`)
                )