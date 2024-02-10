<html>
<head>
<link href="css/style.css" type="text/css" rel="stylesheet" />
<title>Multiselect Dropdown Filter</title>
</head>
<body>
    <h2>Multiselect Dropdown Filter</h2>
    <form method="POST" name="search" action="index.php">
        <div id="demo-grid">
            <div class="search-box">
                <select id="Place" name="employee[]" multiple="multiple">
                    <option value="all" selected="selected">Select employee</option>
                        <?php
                        if (! empty($employeeResult)) {
                            foreach ($employeeResult as $key => $value) {
                                echo '<option value="' . $employeeResult[$key]['id'] . '">' . $employeeResult[$key]['employee_name'] . '</option>';
                            }
                        }
                        ?>
                </select>

                <select id="Place" name="event[]" multiple="multiple">
                    <option value="all" selected="selected">Select event</option>
                        <?php
                        if (! empty($eventResult)) {
                            foreach ($eventResult as $key => $value) {
                                echo '<option value="' . $eventResult[$key]['id'] . '">' . $eventResult[$key]['event_name'] . '</option>';
                            }
                        }
                        ?>
                </select>

                <select id="Place" name="dateofit[]" multiple="multiple">
                    <option value="all" selected="selected">Select date</option>
                        <?php
                        if (! empty($dateResult)) {
                            foreach ($dateResult as $key => $value) {
                                echo '<option value="' . $dateResult[$key]['id'] . '">' . $dateResult[$key]['event_date'] . '</option>';
                            }
                        }
                        ?>
                </select><br> <br>
                <button id="Filter">Search</button>
            </div>
            
                <?php
                if (isset($_POST['employee']) || isset($_POST['event']) || isset($_POST['dateofit']) ) {
                    ?>
                    <table cellpadding="10" cellspacing="1">

                <thead>
                    <tr>
                        <th><strong>id</strong></th>
                        <th><strong>employee name</strong></th>
                        <th><strong>employee mail</strong></th>
                        <th><strong>event name</strong></th>
                        <th><strong>participation fee</strong></th>
                        <th><strong>event_date</strong></th>
                        <th><strong>version</strong></th>
                        <th><strong>Berlin/UTC</strong></th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $query = "SELECT 
                    participation_id, employee_name, employee_mail, event_name , participation_fee , event_date , versions , priorBerlin_afterwardsUTC 
                    FROM 
                    participation as table1
                      INNER JOIN 
                        employee_list as table2 ON table1.employee_id = table2.id
                      INNER JOIN 
                        event_list as table3 ON table1.event_id = table3.id
                      INNER JOIN 
                        date_list as table4 ON table1.date_id = table4.id";
                    $employeeOption = '';
                    $eventOption = '';
                    $dateofitOption = '';
                    if(is_numeric($_POST['employee'][0])){
                        $i = 0;
                        $selectedOptionCount = count($_POST['employee']);
                        $selectedOption = "";
                        while ($i < $selectedOptionCount) {
                            $selectedOption = $selectedOption . "'" . $_POST['employee'][$i] . "'";
                            if ($i < $selectedOptionCount - 1) {
                                $selectedOption = $selectedOption . ", ";
                            }
                            
                            $i ++;
                        }
                        $employeeOption = " AND employee_id in (" . $selectedOption . ")";
                    }
                    if(is_numeric($_POST['event'][0])){
                        $i = 0;
                        $selectedOptionCount = count($_POST['event']);
                        $selectedOption = "";
                        while ($i < $selectedOptionCount) {
                            $selectedOption = $selectedOption . "'" . $_POST['event'][$i] . "'";
                            if ($i < $selectedOptionCount - 1) {
                                $selectedOption = $selectedOption . ", ";
                            }
                            
                            $i ++;
                        }
                        $eventOption = " AND event_id in (" . $selectedOption . ")";
                    }
                    if(is_numeric($_POST['dateofit'][0])){
                        $i = 0;
                        $selectedOptionCount = count($_POST['dateofit']);
                        $selectedOption = "";
                        while ($i < $selectedOptionCount) {
                            $selectedOption = $selectedOption . "'" . $_POST['dateofit'][$i] . "'";
                            if ($i < $selectedOptionCount - 1) {
                                $selectedOption = $selectedOption . ", ";
                            }
                            
                            $i ++;
                        }
                        $dateofitOption = " AND date_id in (" . $selectedOption . ")";
                    }

                    $query = $query . " WHERE participation_id IS NOT NULL $employeeOption $eventOption $dateofitOption";
                    
                    $result = $defaultController->runQuery($query);
                }
                if (! empty($result)) {
                    foreach ($result as $key => $value) {
                        ?>
                <tr>
                        <td><div class="col" id="user_data_1"><?= $result[$key]['participation_id']; ?></div></td>
                        <td><div class="col" id="user_data_2"><?= $result[$key]['employee_name']; ?> </div></td>
                        <td><div class="col" id="user_data_3"><?= $result[$key]['employee_mail']; ?> </div></td>
                        <td><div class="col" id="user_data_3"><?= $result[$key]['event_name']; ?> </div></td>
                        <td><div class="col" id="user_data_3"><?= $result[$key]['participation_fee']; ?> </div></td>
                        <td><div class="col" id="user_data_3"><?= $result[$key]['event_date']; ?> </div></td>
                        <td><div class="col" id="user_data_3"><?= $result[$key]['versions']; ?> </div></td>
                        <td><div class="col" id="user_data_3"><?= $result[$key]['priorBerlin_afterwardsUTC']; ?> </div></td>
                    </tr>
                <?php
                    $sum_fee = $sum_fee + $result[$key]['participation_fee'] ;
                    }
                    ?>
                    
                </tbody>
                <tfoot>
                    <tr>
                    <td class="text-center" colspan="2">Sum</td>
                    <td class="text-center" colspan="5">$<?=number_format($sum_fee)?></td>
                    </tr>
                </tfoot>
            </table>
            <?php
                }
                ?>  
        </div>
    </form>
</body>
</html>