<html>
<head>
<title>Translation Generation</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#FFFFFF" text="#000000">
<table border="1">
<tr><td><b>ID</b></td><td><b>Lesson</b></td><td><b>Sentences</b></td></tr>
<?

include("db.inc.php");

include("writelink.inc.php");

$result = mysql_query("SELECT DISTINCT lesson FROM lessondata ORDER BY lesson");
while (list($lesson) = mysql_fetch_array($result)) {
	echo "<tr><td>$id</td><td>Lesson $lesson</td><td>";
	$sres = mysql_query("SELECT id, sid FROM lessondata WHERE lesson = '$lesson' ORDER BY sid") or die(mysql_error());
	while (list($id, $sid) = mysql_fetch_row($sres)) {
		echo "L$lesson-$sid<br>";
		// Export this entry into the lesson's content folder.
		writelink("http://j301n.ariizumi.net/desc.php?mode=translation&id=$id&sid=$id", "content/lesson$lesson/translation/$id.htm");
	}
	mysql_free_result($sres);
}
?>
</table>
</body>
</html>
