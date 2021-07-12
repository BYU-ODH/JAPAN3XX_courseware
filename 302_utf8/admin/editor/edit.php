<?
session_start();

include("../../db.inc.php");


if ($col && $id) {
	mysql_query("UPDATE $table_s SET $col = '$value' WHERE id = $id") or die("Error : ".mysql_error());
	header("Location: table.php");
	die();
}

$result = mysql_query("DESCRIBE $table_s");
$colnames = array();
$i = 0;
while ($r = mysql_fetch_array($result)) {
	$colnames[$i++] = $r[0];
}
mysql_free_result($result);

$result = mysql_query("SELECT * FROM $table_s WHERE id = $id");
echo "<META HTTP-EQUIV=\"Content-Type\" CONTENT=\"text/html; charset=shift_jis\">";
echo "<TABLE>";
$r = mysql_fetch_array($result);
for ($i = 0; $i < sizeof($colnames); $i++) {
echo "<FORM METHOD=POST><TR><TD BGCOLOR=#dadada><B>".$colnames[$i]."</B></TD><TD>
<INPUT TYPE=HIDDEN NAME=col VALUE=".$colnames[$i].">
<INPUT TYPE=HIDDEN NAME=id VALUE=$id>
<TEXTAREA NAME=value COLS=50 ROWS=3>".$r[$i]."</TEXTAREA></TD><TD><INPUT TYPE=SUBMIT VALUE=\"Update\"></TD></TR></FORM>\n";

}
echo "</TABLE>";
?>
