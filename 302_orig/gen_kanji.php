<html>
<head>
<title>Kanji Generation</title>
<meta http-equiv="Content-Type" content="text/html; charset=Shift_JIS">
</head>

<body bgcolor="#FFFFFF" text="#000000">
<table border="1">
<tr><td><b>ID</b></td><td><b>Kanji</b></td><td><b>Lesson Locations</b></td></tr>
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

include("writelink.inc.php");

mysql_query("UPDATE lessondata SET kanji = ''");
$result = mysql_query("SELECT * FROM kanji");
while (list($id, $kanji, $print, $def, $read, $lfrom) = mysql_fetch_array($result)) {
	echo "<tr><td>$id</td><td>$kanji</td><td>";
	$sres = mysql_query("SELECT id, lesson, sid, sentence, kanji FROM lessondata WHERE sentence LIKE '%".addslashes(addslashes($kanji))."%' AND lesson LIKE '$lfrom%'") or die(mysql_error());
	$cnt = 0;
	while (list($sid, $lesson, $senid, $sentence, $struct) = mysql_fetch_array($sres)) {
		$offset = strpos($sentence, $kanji);
		if ($offset % 2) {
			echo "<font color=red><b>L$lesson-$senid</b></font>: ".cText($sentence, $offset)." (Off)  <br>";
		} else {
			echo "L$lesson-$senid: ".cText($sentence, $offset)."  <br>";
			$struct = $struct ? unserialize($struct) : array();
			$struct[sizeof($struct)] = array($id, $kanji);
			mysql_query("UPDATE lessondata SET kanji = '".addslashes(serialize($struct))."' WHERE id = $sid") or die(mysql_error());
			// Export this entry into the lesson's content folder.
			writelink("http://j301n.ariizumi.net/desc.php?mode=kanji&id=$id&sid=$senid", "content/lesson$lesson/kanji/$id.htm");
			copy("kanji/$print.gif", "content/lesson$lesson/kanji/images/$id.gif");
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
