<?php
$db = new SQLite3('data/ScoutingDatabase.db') or die('0');
$mode=$_GET['mode'];
$matchNumber = $_GET['matchNumber'];
$return = array();
if($mode==0){
    $query = "SELECT R1,R2,R3,B1,B2,B3 FROM MatchSchedule WHERE MatchNum=".$matchNumber;
    $results = $db->query($query);
    while($teamNo=$results->fetchArray()){
        $query2="SELECT teamNumber,scoutName,climbLevel FROM ScoutData WHERE matchNumber=" .$matchNumber." AND teamNumber=".$teamNo[0];
        $output=$db->query($query2);
        while($row=$output->fetchArray()){
            array_push($return, array($row[0], $row[1], $row[2]));
        }
    }
}else{
    $results = $db->query("PRAGMA table_info(ScoutData)");
    while($value=$results->fetchArray()){
        array_push($return, $value[1]);
    }
}


echo json_encode($return);
$db->close();
?>