<html>
<head>
<title>Database Raw Export</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#FFFFFF" text="#000000">
<?
include("../db.inc.php");
$result = mysql_query("SELECT id, vocab, printform, reading FROM voc_conv WHERE id > 1355 ORDER BY id");
while (list($id, $col1, $col2, $col3) = mysql_fetch_array($result)) {
	echo "$id{tab}$col1{tab}$col2{tab}$col3<br>";
}
?>
</body>
</html>