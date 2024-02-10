<?php

class SqlData
{
    /**
     * sql of employee for add to database
     */
    public function employeeListSQL()
    {
        return file_get_contents('Models/SQL/employee_list.sql');
    }

    /**
     * sql of event for add to database
     */
    public function eventListSQL()
    {
        return file_get_contents('Models/SQL/event_list.sql');
    }

    /**
     * sql of date for add to database
     */
    public function dateListSQL()
    {
        return file_get_contents('Models/SQL/date_list.sql');
    }

    /**
     * sql of participation for add to database
     */
    public function participationSQL()
    {
        return file_get_contents('Models/SQL/participation.sql');
    }

    /**
     * sql of participation for add to database
     */
    public function jsonFileDataSQL()
    {
        return file_get_contents('Models/SQL/json_file_data.sql');
    }
}