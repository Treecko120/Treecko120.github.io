<?php
//Write to csv file (legacy)
$file = fopen('data/matchData.csv', 'a');
$data = $_GET['matchData'];
fwrite($file, $data);
fwrite($file, "\n");
fclose($file);

//Write to database
$data = str_replace("\n", "", $data);
$db = new SQLite3('data/ScoutingDatabase.db') or die('0');
$stringFields = array(0, 3, 13, 24, 34);
$booleanFields = array(14, 25, 26, 33);
$fields = explode(",", $data);
for($x=0; $x<count($stringFields); $x++) {
	$fields[$stringFields[$x]] = "'" . $fields[$stringFields[$x]] . "'";
}
for($x=0; $x<count($booleanFields); $x++) {
	if($fields[$booleanFields[$x]] == "false"){
		$fields[$booleanFields[$x]] = "0";
	}
	else {
		$fields[$booleanFields[$x]] = "1";
	}
}
$dataUpdated = implode(",", $fields);
$query = "INSERT INTO ScoutData VALUES(" . $dataUpdated . ")";
echo json_encode($query);
$db->exec($query);
$db->close();
?>
