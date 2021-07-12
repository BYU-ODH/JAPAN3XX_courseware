<html>
<head>
<title>Japanese 301 - <? echo $mode; ?>
</title>
<meta http-equiv="Content-Type" content="text/html; charset=Shift_JIS">
<style type="text/css">
<!--
.default {  font-family: Arial, Helvetica, sans-serif; font-size: 14pt}
.normal {  font-family: Arial, Helvetica, sans-serif; font-size: 12pt}
-->
</style>
<script>
function openWnd(lesson, url) {
	window.open("content/lesson"+lesson+"/culture/"+url, "_blank", "width=750,height=540,scrollbars=yes");
}
</script>
</head>

<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" class="default">
<p><img src="../images/banner.jpg" border="0"><br>
</p>
<table width="100%">
	<tr> 
		<td class="default"> 
			<?
function nl2htmlbr($str) {
	$str = str_replace("\r\n", "<br>", $str);
	$str = str_replace("\n", "<br>", $str);
	return $str;
}
include("db.inc.php");
if ($mode) {
	$result = mysql_query("SELECT sentence, translation FROM lessondata WHERE id = $sid") or die(mysql_error());
	list($sentence, $translation) = mysql_fetch_array($result);
}

if ($mode == "translation") {
	echo "<p>$translation</p>";
}

if ($mode == "vocab") {
	list($vocab, $printform, $def, $reading) = mysql_fetch_array(mysql_query("SELECT vocab, printform, def, reading FROM vocab WHERE id = $id"));
	$print = $printform ? $printform : $vocab;
	echo "<p align=\"center\"><font style=\"font-size: 16pt; font-weight: bold;\">$print</font>".($reading != $print ? "<br>$reading" : "")."</p><hr><p class=\"normal\"><b>Definition:</b> $def</p>";
}

if ($mode == "grammar") {
	list($grammar, $printform, $def) = mysql_fetch_array(mysql_query("SELECT grammar, printform, def FROM grammar WHERE id = $id"));
	$print = nl2htmlbr($printform ? $printform : $grammar);
	echo "<p align=\"center\"><font style=\"font-size: 16pt; font-weight: bold;\">$print</font></p><hr><p class=\"normal\"><b>Explanation:</b> ".nl2htmlbr($def)."</p>";
}

if ($mode == "kanji") {
	list($kanji, $location, $def, $defeng) = mysql_fetch_array(mysql_query("SELECT kanji, location, def, defeng FROM kanji WHERE id = $id"));
	echo "<p align=\"center\"><img src=\"images/$id.gif\" alt=\"$kanji Animation\"></p><hr><table border=\"0\"><tr><td valign=\"top\"><b>音:</b><br><b>訓:</b></td><td valign=\"top\">".nl2htmlbr($def)."</td></tr></table><p class=\"normal\"><b>Definition:</b><br>$defeng</p>";
}

if ($mode == "culture") {
	list($culture, $printform, $filename, $lesson) = mysql_fetch_array(mysql_query("SELECT culture, printform, filename, lesson FROM culture WHERE id = $id"));
	echo "<p align=\"center\"><b>$printform</b></p>";
	while (strpos($filename, "\r\n") > 0) {
		$image = substr($filename, 0, strpos($filename, "\r\n"));
		$filename = substr($filename, strpos($filename, "\r\n") + 2);
		echo "<p align=\"center\"><a href=\"javascript:openWnd('$lesson','$image')\"><img src=\"content/lesson$lesson/culture/thumb/$image\" alt=\"$printform\" border=\"0\"></a></p>";
	}
		echo "<p align=\"center\"><a href=\"javascript:openWnd('$lesson','$filename')\"><img src=\"content/lesson$lesson/culture/thumb/$filename\" alt=\"$printform\" border=\"0\"></a></p>";
}

?>
		</td>
	</tr>
</table>
</body>
</html>
