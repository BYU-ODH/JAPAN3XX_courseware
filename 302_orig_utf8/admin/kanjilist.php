<html>
<head>
<title>Kanji List Import</title>
<meta http-equiv="Content-Type" content="text/html; charset=Shift_JIS">
</head>

<body bgcolor="#FFFFFF" text="#000000">
<form name="form1" method="post" action="">
	<p>Lesson: 
		<input type="text" name="lesson" size="3">
	</p>
	<p>Kanji List:<br>
		<input type="text" name="kanjilist" size="60">
		<br>
	</p>
	<p>
		<input type="submit" name="Submit" value="Process">
	</p>
</form>
<?
include("../db.inc.php");
if ($kanjilist) {
	$kanjilist = stripslashes($kanjilist);
	for ($i = 0; $i < strlen($kanjilist); $i += 2) {
		$char = addslashes(substr($kanjilist, $i, 2));
		echo "L$lesson -> ".substr($kanjilist, $i, 2)."<br>";
		$result = mysql_query("SELECT id FROM kanji WHERE kanji = '$char'") or die(mysql_error());
		list($id) = mysql_fetch_array($result);
		mysql_free_result($result);
		mysql_query("UPDATE kanji SET lesson = '$lesson' WHERE id = $id") or die(mysql_error());
	}
}
?>
</body>
</html>
