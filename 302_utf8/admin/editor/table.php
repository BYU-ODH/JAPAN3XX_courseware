<?
session_start();
if (isset($col)) {
	$sort_s = $col;
	session_register("sort_s");
}

if (isset($value)) {
	$value_s = $value;
	$scol_s =$scol;
	session_register("value_s");
	session_register("scol_s");
}

if (isset($table)) {
	$table_s = $table;
	session_register("table_s");
	session_unregister("value_s");
	session_unregister("sort_s");
	$value_s = false;
	$sort_s = false;
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
	echo "<FORM NAME=".$colnames[$i]." ACTION=table.php><TD ALIGN=CENTER>
<A HREF=\"table.php?col=".$colnames[$i]."\" STYLE=\"color: #000000;text-decoration:none;\">".$colnames[$i]."</A><BR>
<INPUT TYPE=HIDDEN NAME=scol VALUE=".$colnames[$i].">
<INPUT NAME=value SIZE=10 STYLE=\"font: 8pt arial,sans-serif; font-weight:bold;\">
</TD></FORM>";
echo "<TD>Edit</TD></TR>";
mysql_free_result($result);
$result = mysql_query("SELECT * FROM $table_s".($value_s && $scol_s ? " WHERE $scol_s LIKE '%$value_s%'" : "")." ".($sort_s ? "ORDER BY ".$sort_s : "")) or die("Error: ".mysql_error());
while ($r = mysql_fetch_array($result)) {
	echo "<TR>";
	for ($i = 0; $i < sizeof($colnames); $i++) echo "<TD>".($r[$i] ? $r[$i] : "&nbsp;")."</TD>";
	echo "<TD ALIGN=CENTER><A HREF=\"edit.php?id=".$r["id"]."\">Edit</A><BR>
<A HREF=\"delete.php?id=".$r["id"]."\">Delete</A></TD>";
	echo "</TR>";
}
echo "</TABLE>";
?>
