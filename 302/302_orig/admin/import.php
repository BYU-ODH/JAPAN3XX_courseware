<?
$to = "lesson";
include("../db.inc.php");
$dlin = "||";
$dcol = "	";
if ($text) {
	while (strpos($text, $dlin) > 0) {
		$recLn = substr($text, 0, strpos($text, $dlin));
		$text = substr($text, strpos($text, $dlin) + 2);
		$record = array();
		$i = 0;
		while (!(strpos($recLn, "	") === false)) {
			$record[$i++] = substr($recLn, 0, strpos($recLn, "	"));
			$recLn = substr($recLn, strpos($recLn, "	") + 1);
		}
		$record[$i] = $recLn;

		$value = "";
		for ($i = 0; $i < sizeof($record); $i++) {
			if (strpos($record[$i], "	") === false){
				$value .= "'".$record[$i]."'";
				if ($i < sizeof($record) - 1)
					$value .= ", ";
			}
		}
		echo "REPLACE INTO $to VALUES ($value)<br>";
		mysql_query("REPLACE INTO $to VALUES ($value)") or die(mysql_error());
	}
	die();
}
?>		
<html>
<head>
<title>Database Import</title>
<meta http-equiv="Content-Type" content="text/html; charset=Shift_JIS">
</head>

<body bgcolor="#FFFFFF" text="#000000">
<form name="form1" method="post" action="">
	<p>
		<textarea name="text" cols="120" rows="20" wrap="OFF"></textarea>
	</p>
	<p>
		<input type="submit" name="Submit" value="Submit">
	</p>
</form>
</body>
</html>
