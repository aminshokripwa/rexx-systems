CREATE TABLE employee_list (
                id INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                employee_name VARCHAR(50) NOT NULL,
                employee_mail VARCHAR(50) NOT NULL,
                INDEX (`employee_name`,`employee_mail`)
                )