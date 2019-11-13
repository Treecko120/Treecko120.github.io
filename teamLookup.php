<?php
$db = new SQLite3('data/ScoutingDatabase.db') or die('0');
$matchNumber = $_GET['matchNumber'];
$station = $_GET['station'];
$query = "SELECT " . $station . " from MatchSchedule WHERE MatchNum=" . $matchNumber;
$results = $db->query($query);
$teamNum = 0;
while($row = $results->fetchArray()) {
	$teamNum = $row[0];
}
echo json_encode($teamNum);
$db->close();
?>
