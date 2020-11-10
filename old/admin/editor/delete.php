<?
session_start();
include("../../db.inc.php");


if ($id && $confirm) {
	mysql_query("DELETE FROM $table_s WHERE id = $id") or die("Error : ".mysql_error());
	header("Location: table.php");
	die();
}

echo "<H2>Are you sure?</H2>";
echo "<FORM><INPUT TYPE=HIDDEN NAME=id VALUE=$id><INPUT TYPE=HIDDEN NAME=confirm VALUE=\"true\">
<INPUT TYPE=SUBMIT VALUE=\"Yes\">
<INPUT TYPE=BUTTON VALUE=\"No\" onClick=\"history.back()\">
</FORM>";
?>
