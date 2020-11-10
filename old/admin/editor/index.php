<?
session_start();
session_unregister("table_s");
session_unregister("sort_s");
session_unregister("value_s");
session_destroy();
?>
<html>
<head>
<title>Database Editor</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#FFFFFF" text="#000000">
<p><b>Select a Database</b></p>
<p>
<?

include("../../db.inc.php");


$result = mysql_query("SHOW TABLES");
echo "<FORM ACTION=table.php>";
while ($r = mysql_fetch_array($result)) {
	echo "<INPUT TYPE=RADIO NAME=table VALUE=\"".$r[0]."\"> ".$r[0]."<br>\n";
}
echo "</p><INPUT TYPE=SUBMIT VALUE=\"Select\"></FORM>";
?>
</body>
</html>
