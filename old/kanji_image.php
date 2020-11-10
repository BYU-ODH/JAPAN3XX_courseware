<html>
<head>
<title>Kanji Image Status</title>
<meta http-equiv="Content-Type" content="text/html; charset=Shift_JIS">
</head>

<body bgcolor="#FFFFFF" text="#000000">
<table border="1" style="font: 10pt Tahoma,sans-serif;" cellspacing="3">
  <tr bgcolor="#CCCCCC"> 
    <td><b>ID</b></td>
    <td><b>Kanji</b></td>
    <td><b>Filename</b></td>
    <td><b>Status</b></td>
  </tr>
  <?

include("db.inc.php");

$result = mysql_query("SELECT * FROM kanji");
while (list($id, $kanji, $location, $def, $defeng, $lesson) = mysql_fetch_row($result)) {
	$exists = false;
	if (file_exists("kanji/$location.gif")) $exists = true;
?>
  <tr> 
    <td>
      <? echo $id; ?>
    </td>
    <td>
      <? echo $kanji; ?>
    </td>
    <td> 
      <a onClick="window.open('kanji/<? echo $location; ?>.gif','_blank','width=80,height=80')" style="text-decoration: underline;"><? echo $location; ?></a></td>
    <td>
      <? echo ($exists ? "OK" : "<font color=red><b>NOT FOUND</b></font>"); ?>
    </td>
  </tr>
  <? } ?>
</table></body>
</html>
