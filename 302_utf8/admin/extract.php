<html>
<head>
<title>Database Raw Export</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#FFFFFF" text="#000000">
<form name="form1" method="post" action="">
	<textarea name="textfield" cols="120" wrap="OFF" rows="20"><?
$from = "lesson";
$affected = "title";
include("../db.inc.php");
$result = mysql_query("SELECT * FROM $from WHERE $affected LIKE '%&#%' ORDER BY lesson") or die(mysql_error());
while ($r = mysql_fetch_row($result)) {
	for ($i = 0; $i < sizeof($r); $i++) {
		if (strpos($r[$i], "	") === false){
			echo $r[$i];
			if ($i < sizeof($r) - 1)
				echo "	";
		} else {
			echo "\r\nERROR\r\n\r\n";
		}
	}
	echo "||";
}
?></textarea>
</form>
</body>
</html>