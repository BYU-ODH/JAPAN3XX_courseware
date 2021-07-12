<html>
<head>
<title>Lesson Generation</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#FFFFFF" text="#000000">
<table border="1">
<tr><td><b>Lesson</b></td><td><b>Generation</b></td></tr>
<?

include("db.inc.php");

include("writelink.inc.php");

$result = mysql_query("SELECT DISTINCT lesson FROM lessondata ORDER BY lesson");
while (list($lesson) = mysql_fetch_array($result)) {
	echo "<tr><td>Lesson $lesson</td><td>";

	echo "L$lesson-Frame<br>";
	writelink("http://j301n.ariizumi.net/lessonframe.php?lesson=$lesson", "content/lesson$lesson/index.html");
	echo "L$lesson-Top<br>";
	writelink("http://j301n.ariizumi.net/topnav.php?lesson=$lesson", "content/lesson$lesson/topnav.html");
	echo "L$lesson-Translation<br>";
	writelink("http://j301n.ariizumi.net/lesson.php?lesson=$lesson&sel=translation", "content/lesson$lesson/translation.html");
	echo "L$lesson-Kanji<br>";
	writelink("http://j301n.ariizumi.net/lesson.php?lesson=$lesson&sel=kanji", "content/lesson$lesson/kanji.html");
	echo "L$lesson-Grammar<br>";
	writelink("http://j301n.ariizumi.net/lesson.php?lesson=$lesson&sel=grammar", "content/lesson$lesson/grammar.html");
	echo "L$lesson-Vocab<br>";
	writelink("http://j301n.ariizumi.net/lesson.php?lesson=$lesson&sel=vocab", "content/lesson$lesson/vocab.html");
	echo "L$lesson-Culture<br>";
	writelink("http://j301n.ariizumi.net/lesson.php?lesson=$lesson&sel=culture", "content/lesson$lesson/culture.html");
	copy("images/play.gif", "content/lesson$lesson/images/play.gif");
	copy("extras/Graphics/banner$lesson.jpg", "content/lesson$lesson/images/banner.jpg");
	copy("blank.html", "content/lesson$lesson/intro.html");
	exec("cp source/sound/mov/".$lesson."_*.mov content/lesson$lesson/sound/");
}
?>
</table>
</body>
</html>
