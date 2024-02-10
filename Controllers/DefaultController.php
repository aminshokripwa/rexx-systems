<?php

class defaultController extends VersionComparator
{
    private $dbConnect = false;
    private $dbConnectMysqli = false;
    public $jsonfilename = false;
    /**
     * prepare data for connect to database
     */
    public function __construct()
    {
        //connect PDO
        include 'config.php';
        $conn = new PDO("mysql:host=".$servername.";dbname=".$dbname, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->dbConnect = $conn;
        //connect mysqli
        $connect = mysqli_connect($servername, $username, $password, $dbname);
        $this->dbConnectMysqli = $connect;
        //load json file
        $this->jsonfilename = $jsonfile ;
    }

    /**
     * Remove symboles from strings to help them add as key
     *
     * @param {string} checkThis
     */
    public function removeAllSymbols($checkThis)
    {
        $out = preg_replace('/[^A-Za-z0-9\-]/', '', $checkThis);
        return $out;
    }

    /**
     * Read database
     *
     * @param {string} query
     */
    public function runQuery($query)
    {
        $result = mysqli_query($this->dbConnectMysqli, $query);
        while($row=mysqli_fetch_assoc($result)) {
            $resultset[] = $row;
        }
        if(!empty($resultset)) {
            return $resultset;
        }
    }

    /**
     * insert json read data
     *
     * @param {string} query
     */
    public function insertHashFileQuery($hashedJson)
    {
        $sql = $this->dbConnect->prepare("INSERT IGNORE INTO `json_file_data` SET `hashedJson` = :hashedJson, `created_at` = :created_at ;");
        $sql->execute(array(
            ":hashedJson" => $hashedJson,
            ":created_at" => date('Y-m-d H:i:s')
        ));
    }

    /**
     * add new data to database as FOREIGN KEY to make groups
     *
     * @param {array} input
     * @param {string} tablename
     * @param {string} item1
     * @param {string} item2
     * @param {string} iteitem3m2
     */
    public function addToDatabaseIfNotExist($input, $tablename, $item1, $item2 = null, $item3 = null)
    {
        foreach($input as $key => $item) {
            if(!empty($item2)) {
                $sql = $this->dbConnect->prepare("INSERT IGNORE INTO `$tablename` SET `$item1` = :$item1, `$item2` = :$item2 ;");
                $sql->execute(array(
                    ":".$item1 => $item[$item3],
                    ":".$item2 => $item[$item2]
                ));
            } else {
                $sql = $this->dbConnect->prepare("INSERT IGNORE INTO `$tablename` SET `$item1` = :$item1 ;");
                $sql->execute(array(
                    ":".$item1 => $item[$item1]
                ));
            }
            //if record exist
            if(!empty($this->dbConnect->lastInsertId()) && $this->dbConnect->lastInsertId() > 0) {
                $way_list[$this->removeAllSymbols($item[$item1])] = $this->dbConnect->lastInsertId();
            } else {
                //if user exist add user and its id
                $thisWay = $this->dbConnect->query("SELECT id FROM `$tablename` WHERE `$item1` = '".$item[$item3]."' LIMIT 1 ;")->fetch();
                //print_r($user);
                $way_list[$this->removeAllSymbols($item[$item3])] = $thisWay['id'];
            }

        }
        return $way_list;
    }

    /**
     * add new data to database to database
     *
     * @param {array} data_array
     * @param {string} employee_list
     * @param {string} date_list
     */
    public function addDataToParticipation($data_array, $employee_list, $date_list)
    {
        $sql = $this->dbConnect->prepare('INSERT IGNORE INTO `participation` SET `participation_id` = :participation_id, `employee_id` = :employee_id, `event_id` = :event_id, `participation_fee` = :participation_fee, `date_id` = :date_id, `versions` = :versions, `priorBerlin_afterwardsUTC` = :priorBerlin_afterwardsUTC ;');

        // We can use $sql to insert data
        foreach($data_array as $key => $item) {

            //check timezone 
            $currentVersion = $item['version'];
            $targetVersion = "1.0.17+60";
            
            print_r($this->isPriorTo($currentVersion, $targetVersion));
            if ($this->isPriorTo($currentVersion, $targetVersion)) {
                //echo $currentVersion . " is prior to " . $targetVersion;
                $berlinOrUTC = 'berlin';
            } else {
                //echo $currentVersion . " is afterwards than " . $targetVersion;
                $berlinOrUTC = 'UTC';
            }

            //add data to sql
            $sql->execute(array(
                ':participation_id' => $item['participation_id'],
                ':employee_id'    => $employee_list[removesymbols($item['employee_name'])],
                ':event_id' => $item['event_id'],
                ':participation_fee' => $item['participation_fee'],
                ':date_id' => $date_list[removesymbols($item['event_date'])],
                ':versions' =>  !empty($item['version']) ? $item['version'] : null ,
                ':priorBerlin_afterwardsUTC' =>  $berlinOrUTC ,
            ));
        }
    }

}
