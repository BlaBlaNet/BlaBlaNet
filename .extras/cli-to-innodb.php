<?php
/*
 * Use this script for Change the Database to InnoDB.
 */
$db = array();

/*
 * Change these to match your database connection information look in .htconfig.php :)
 */
$db['host']     = "localhost";
$db['port']     = "3306";
$db['user']     = "";
$db['password'] = "";
$db['database'] = "";

/*
 * DO NOT CHANGE ANYTHING BELOW THIS LINE
 * Unless you know what you are doing. :)
 */
$db['connectString'] = $db['host'];

if (isset($db['port']) && (int)$db['port']==$db['port']) {
	$db['connectString'] .= ":" . $db['port'];
}

$mysqli = @new mysqli($db['connectString'], $db['user'], $db['password'], $db['database']);

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error ."\n";
    die(1);
}

$results = $mysqli->query("show tables;");

if ($results===false or $mysqli->connect_errno) {
    echo "MySQL error: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error ."\n";
    die(2);
}

while ($row= $results->fetch_assoc()) {
$sql = "SHOW TABLE STATUS WHERE Name = '{$row['Tables_in_' . $db['database']]}'";
	$thisTable = $mysqli->query($sql)->fetch_assoc();

	if ($thisTable['Engine']==='MyISAM') {
		$sql = "alter table " . $row['Tables_in_' . $db['database']]. " ENGINE = InnoDB;";
		echo "Changing {$row['Tables_in_' . $db['database']]} from {$thisTable['Engine']} to InnoDB.\n";
		$mysqli->query($sql);
	} else {
		echo $row['Tables_in_' . $db['database']] . ' is of the Engine Type ' . $thisTable['Engine'] . ".\n";
		echo "Not changing to InnoDB.\n\n";
	}
}

die(0);
