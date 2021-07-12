<html>
<head>
<title>Database Character Filter</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#FFFFFF" text="#000000">
<form name="form1" method="post" action="">
	<textarea name="textfield" cols="120" wrap="OFF" rows="20"><?
$from = "lessondata";
$affected = "translation";
include("../db.inc.php");
$result = mysql_query("SELECT id, $affected FROM $from WHERE $affected LIKE '%f%' ORDER BY id") or die(mysql_error());
while (list($id, $affstr) = mysql_fetch_row($result)) {
	echo $affstr."\r\n";
	$affstr = addslashes(str_replace("f", "'", $affstr));
	echo "UPDATE $from SET $affected = '$affstr' WHERE id = $id\r\n";
	mysql_query("UPDATE $from SET $affected = '$affstr' WHERE id = $id") or die(mysql_error());
}
?></textarea>
</form>
</body>
</html>