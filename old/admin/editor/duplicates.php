<?
session_start();
if (isset($col)) {
	$sort_s = $col;
	session_register("sort_s");
}

if (isset($value)) {
	$value_s = $value;
	session_register("value_s");
}

if (isset($table)) {
	$table_s = $table;
	session_register("table_s");
}

include("../../db.inc.php");

$result = mysql_query("DESCRIBE $table_s");
$colnames = array();
$i = 0;
while ($r = mysql_fetch_array($result)) {
	$colnames[$i++] = $r[0];
}
echo "<META HTTP-EQUIV=\"Content-Type\" CONTENT=\"text/html; charset=shift_jis\">";
echo "<FONT STYLE=\"font: 10pt arial,sans-serif; font-weight:bold\"><A HREF=\"index.php\">Back to Tables</A></FONT<BR>";
echo "<TABLE BORDER=1 WIDTH=100% STYLE=\"font: 10pt arial,sans-serif\">";
echo "<TR BGCOLOR=#dadada STYLE=\"font-weight:bold\">";
for ($i = 0; $i < sizeof($colnames); $i++)
	echo "<FORM NAME=".$colnames[$i]."><TD ALIGN=CENTER>
<A HREF=\"#\" STYLE=\"color: #000000;text-decoration:none;\" onClick=\"document.".$colnames[$i].".submit();return false;\">".$colnames[$i]."</A><BR>
<INPUT TYPE=HIDDEN NAME=col VALUE=".$colnames[$i].">
<INPUT NAME=value SIZE=10 STYLE=\"font: 8pt arial,sans-serif; font-weight:bold;\">
</TD></FORM>";
echo "<TD>Edit</TD></TR>";
mysql_free_result($result);
$result = mysql_query("SELECT id, vocab, count(vocab) AS vc FROM vocab GROUP BY vocab ORDER BY vc DESC LIMIT 48") or die(mysql_error());
while ($r = mysql_fetch_array($result)) {
	echo "<TR>";
	for ($i = 0; $i < sizeof($colnames); $i++) echo "<TD>".($r[$i] ? $r[$i] : "&nbsp;")."</TD>";
	echo "<TD ALIGN=CENTER><A HREF=\"edit.php?id=".$r["id"]."\">Edit</A>";
	echo "</TR>";
}
echo "</TABLE>";
?>
