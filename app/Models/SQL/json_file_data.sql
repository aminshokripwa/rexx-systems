CREATE TABLE json_file_data (
                id INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                hashedJson VARCHAR(80) NOT NULL,
                `created_at` datetime NOT NULL,
                INDEX (`hashedJson`)
                )