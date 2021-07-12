<html>
<head>
<title>Database Raw Export</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#FFFFFF" text="#000000">
<?
$from = "voc_conv";
$to = "vocab";
include("../db.inc.php");
$result = mysql_query("SELECT id, vocab, printform, reading FROM $from ORDER BY id");
while (list($id, $col1, $col2, $col3) = mysql_fetch_array($result)) {
	$col1 = addslashes($col1);
	$col2 = addslashes($col2);
	$col3 = addslashes($col3);
	mysql_query("UPDATE $to SET vocab = '$col1', printform = '$col2', reading = '$col3' WHERE id = $id") or die(mysql_error());
	//mysql_query("UPDATE $to SET printform = '$col2' WHERE id = $id") or die(mysql_error());
	//mysql_query("UPDATE $to SET reading = '$col3' WHERE id = $id") or die(mysql_error());
}
?>
</body>
</html>