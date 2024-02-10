<?php

    //Design a database scheme for optimized storage
    include 'Models/Sqldata.php';
    include 'Models/Migration.php';
    $migration = new Migration();

    //insert usefull fuctions
    include 'Core/Usefull.php';

    //Read the json data and save it to the database using php
    //Additional information
    include 'Controllers/VersionController.php';
    include 'Controllers/DefaultController.php';
    $defaultController = new defaultController();

    $filename = $defaultController->jsonfilename;

    if(file_exists($filename)) {
        //check if not filtred
        //v1 read json file
        //if(empty($_POST)) {
            //check to mysql

            $check_table = $migration->checkIfTabaleExist();

            if ($check_table == 2) {

                //add sql table to database 
                $migration->addTablesToDatabase();
                echo "<h4 class='text-danger'>Tables were created</h4>";

            } elseif($check_table != 1) {
                echo "Error: " . $e->getMessage();
                die;
            } else {
                //tables exist
                echo "<h4 class='text-danger'>The tables were already created, now the data is checked for uploading to the database.</h4>";
            }

            //import json to mysql
            $data = file_get_contents($filename); //data read from json file

            //check if json imported before
            //print_r($data);
            //calculate hash of json file 
            $check_if_imported = hash('sha256', $data);
            $employeeResult = $defaultController->runQuery("SELECT id, created_at FROM json_file_data WHERE hashedJson = '$check_if_imported' ORDER BY id desc limit 1");
            //check if json file inserted before
            if(empty($employeeResult)){

                $employee_list = $defaultController->insertHashFileQuery($check_if_imported);

                //decode a data
                $data_array = json_decode($data, true); 
    
                #groups employee and event and date
    
                //group event
                $evenr_list = array_reduce($data_array, function ($carry, $item) {
                    if(!isset($carry[removesymbols($item['event_id'])])) {
                        $carry[removesymbols($item['event_id'])] = [
                                                        'event_id'=>$item['event_id'],
                                                        'event_name'=>$item['event_name']
                                                    ];
                    }
                    return $carry;
                });
    
                //for each add event to database
                $evenr_list_array = $defaultController->addToDatabaseIfNotExist($evenr_list, 'event_list', 'id', 'event_name', 'event_id');
    
                //group employee detiles
                $employee = array_reduce($data_array, function ($carry, $item) {
                    if(!isset($carry[removesymbols($item['employee_name'])])) {
                        $carry[removesymbols($item['employee_name'])] = [
                            'employee_name'=>$item['employee_name'],
                            'employee_mail'=>$item['employee_mail']
                        ];
                    }
                    return $carry;
                });
    
                //for each add employee to database or if exist read its id from database
                $employee_list = $defaultController->addToDatabaseIfNotExist($employee, 'employee_list', 'employee_name', 'employee_mail', 'employee_name');
    
                //group date
                $date_array = array_reduce($data_array, function ($carry, $item) {
                    if(!isset($carry[removesymbols($item['event_date'])])) {
                        $carry[removesymbols($item['event_date'])] = [
                            'event_date'=>$item['event_date']
                        ];
                    }
                    return $carry;
                });
    
                //for each add date to database or if exist read its id from database
                $date_list = $defaultController->addToDatabaseIfNotExist($date_array, 'date_list', 'event_date', null, 'event_date');
    
                //add data to participation
                $date_list = $defaultController->addDataToParticipation($data_array, $employee_list, $date_list);
    
                echo "<h3 class='text-danger'>Data entry is complete</h3>";   

            }else{
                echo "<h3 class='text-danger'>Data imported before</h3>";  
            }


        //}

        $employeeResult = $defaultController->runQuery("SELECT DISTINCT employee_name, id FROM employee_list ORDER BY employee_name ASC");
        $eventResult = $defaultController->runQuery("SELECT DISTINCT event_name, id FROM event_list ORDER BY event_name ASC");
        $dateResult = $defaultController->runQuery("SELECT DISTINCT date_list.event_date, date_list.id, participation.priorBerlin_afterwardsUTC FROM date_list LEFT JOIN participation ON date_list.id = participation.date_id ORDER BY event_date ASC");
        //print_r($dateResult);
        $sum_fee = 0 ;

        //Create a simple page with filters for the employee name, event name and date
        include 'views/home.php';

    } else {
        echo "<h3 class='text-danger'>JSON file Not found</h3>";
    }
