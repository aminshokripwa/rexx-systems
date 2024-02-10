<?php

class Migration extends SqlData
{
    private $dbConnectm = false;
    /**
     * prepare data for connect to database
     */
    public function __construct()
    {
        include 'config.php';
        $conn = new PDO("mysql:host=".$servername.";dbname=".$dbname, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->dbConnectm = $conn;
    }

    /**
     * check if tables exist before
     */
    public function checkIfTabaleExist()
    {
        try {
            $stmt = $this->dbConnectm->prepare("SELECT 1 FROM event_list");
            $stmt->execute();
            return 1  ;
        } catch(PDOException $e) {
            return 2  ;
        }
    }

    /**
     * add tabals to database
     */
    public function addTablesToDatabase()
    {
        $sql = $this->employeeListSQL();
        $this->dbConnectm->exec($sql);

        $sql = $this->eventListSQL();
        $this->dbConnectm->exec($sql);

        $sql = $this->dateListSQL();
        $this->dbConnectm->exec($sql);

        $sql = $this->participationSQL();
        $this->dbConnectm->exec($sql);

        $sql = $this->jsonFileDataSQL();
        $this->dbConnectm->exec($sql);
    }

}
