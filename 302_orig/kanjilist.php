<html>
<head>
<title>Kanji List By Lesson</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#FFFFFF" text="#000000">
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
$result = mysql_query("SELECT * FROM kanji");
while ($r = mysql_fetch_array($result)) {
	$kanji = addslashes(addslashes($r["kanji"]));
	$kanji_id = $r["id"];

	echo "<b>".$r["kanji"]." ID #$kanji_id:</b><br>";
	$sres = mysql_query("SELECT * FROM lessondata WHERE sentence LIKE '%$kanji%'") or die("oh, no.");
	while ($srow = mysql_fetch_array($sres)) {
		$sentence = $srow["sentence"];
		$pos = strpos($sentence, $kanji);
		echo "L".$srow["lesson"].":".$srow["sid"].":".$pos;
		if ($pos % 2 || $pos === false) {
			echo "<b><font color=red> [".$srow["id"]."]</font></b>";
		} else {
			echo "<font color=blue> (".$srow["id"].")</font>";
		}		
		for ($i = 0; $kanjistruct[$i]; $i++) {
			if (!in_array($kanjistruct[$i]["id"], $kanjirem)) {
			$pos = strpos($sentence, $kanjistruct[$i]["kanji"]);
			$sentence = substr($sentence, 0, $pos).($delmode ? "<A HREF='javascript:doDel(".$r["id"].", ".$kanjistruct[$i]["id"].")'>" : "<A HREF='javascript:doShow(".$kanjistruct[$i]["id"].")'>").substr($sentence, $pos, 2)."</A>".substr($sentence, $pos+2); }
		}
		echo ":$sentence   <br>";
	}
	echo "<hr>";
}
?>
</body>
</html>