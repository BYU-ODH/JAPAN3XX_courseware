<html>
<head>
<title>Vocabulary Count</title>
<meta http-equiv="Content-Type" content="text/html; charset=Shift_JIS">
</head>

<body bgcolor="#FFFFFF" text="#000000">
<table border="1">
  <tr bgcolor="#e0e0e0">
    <td><b>Vocabulary</b></td>
	<td><b>Count</b></td>
	<td><b>ID</b></td>
  </tr>
<?
include("../db.inc.php");
$result = mysql_query("SELECT vocab, COUNT(*) as vc, id FROM vocab GROUP BY vocab ORDER BY vc DESC, id") or die(mysql_error());
while (list($vocab, $count, $id) = mysql_fetch_array($result)) { ?>
  <tr>
    <td><? echo $vocab; ?></td>
	<td><? echo $count; ?></td>
	<td><? echo $id; ?></td>
  </tr>
<? } ?>
</table>
</body>
</html>
