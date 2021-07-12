<html>
<head>
<title>Culture Generation</title>
<meta http-equiv="Content-Type" content="text/html; charset=Shift_JIS">
</head>

<body bgcolor="#FFFFFF" text="#000000">
<table border="1">
<tr><td><b>ID</b></td><td><b>Culture</b></td><td><b>Lesson Locations</b></td></tr>
<?
function cText($text, $center) {
	$width = 26;
	if ($center - $width / 2 < 0)
		$start = 0;
	else
		$start = $center - $width / 2;
	$start += $start % 2;
	
	if ($center + $width / 2 > strlen($text))
		$end = strlen($text);
	else
		$end = ($center + 2) + $width / 2;
	$end -= $end % 2;
	return substr($text, $start, $end - $start);
}

include("db.inc.php");

include("thumbs.inc.php");

mysql_query("UPDATE lessondata SET culture = ''");
$result = mysql_query("SELECT * FROM culture");
while (list($id, $culture, $print, $filename, $lesson) = mysql_fetch_array($result)) {
	echo "<tr><td>$id<br>";
	while (strpos($filename, "\r\n") > 0) {
		$image = substr($filename, 0, strpos($filename, "\r\n"));
		$filename = substr($filename, strpos($filename, "\r\n") + 2);
		makeThumb("content/lesson$lesson/culture/$image", "content/lesson$lesson/culture/thumb/$image");
	}
	makeThumb("content/lesson$lesson/culture/$filename", "content/lesson$lesson/culture/thumb/$filename");
	echo "</td><td>$culture</td><td>";
	$sres = mysql_query("SELECT id, lesson, sid, sentence, culture FROM lessondata WHERE sentence LIKE '%".addslashes(addslashes($culture))."%' AND lesson = '$lesson'") or die(mysql_error());
	$cnt = 0;
	while (list($sid, $lesson, $senid, $sentence, $struct) = mysql_fetch_array($sres)) {
		$offset = strpos($sentence, $culture);
		if ($offset % 2) {
			echo "<font color=red><b>L$lesson-$senid</b></font>: ".cText($sentence, $offset)." (Off)  <br>";
		} else {
			echo "L$lesson-$senid: ".cText($sentence, $offset)."  <br>";
			$struct = $struct ? unserialize($struct) : array();
			$struct[sizeof($struct)] = array($id, $culture);
			mysql_query("UPDATE lessondata SET culture = '".addslashes(serialize($struct))."' WHERE id = $sid") or die(mysql_error());
		}
		$cnt++;
	}
	echo ($cnt == 0 ? "<font color=red>NONE FOUND</font> " : "")."</td></tr>";
	mysql_free_result($sres);
}
?>
</table>
</body>
</html>
