<html>
<head>
<title>Make Directories</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<?
$lessons = array("01", "02", "03", "04a", "04b", "05", "06a", "06b", "07a", "07b", "08a", "08b", "09a", "09b", "10", "11a", "11b", "12a", "12b", "13a", "13b", "14a", "14b");
reset($lessons);
while (list($idx, $lesson) = each($lessons)) {
	echo exec("mkdir content/lesson$lesson");
	exec("mkdir content/lesson$lesson/culture");
	exec("mkdir content/lesson$lesson/grammar");
	exec("mkdir content/lesson$lesson/vocab");
	exec("mkdir content/lesson$lesson/kanji");
	exec("mkdir content/lesson$lesson/kanji/images");	
	exec("mkdir content/lesson$lesson/translation");
	exec("mkdir content/lesson$lesson/images");
	exec("mkdir content/lesson$lesson/sound");
}	
?>
</body>
</html>
