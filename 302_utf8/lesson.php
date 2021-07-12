<html><!-- #BeginTemplate "/Templates/Main Content.dwt" --><!-- DW6 --><head><!-- #BeginEditable "doctitle" --> 
<title>Japanese 301</title>
<!-- #EndEditable --> <meta http-equiv="Content-Type" content="text/html; charset=Shift_JIS"><style type="text/css"><!--.default {  font-family: Arial, Helvetica, sans-serif; font-size: 10pt}.default A {  color: #16218A; text-decoration: none; }.default A:hover {  color: #4444e0; text-decoration: underline; }.heading {  font-family: Arial, Helvetica, sans-serif; font-size: 18pt; font-weight: bold}.small {  font-family: Arial, Helvetica, sans-serif; font-size: 8pt}--></style></head><body bgcolor="#FFFFFF" text="#000000" class="default"><table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">	<tr> 		<td class="default" valign="top"> <!-- #BeginEditable "Content" --> 
<style type="text/css">
<!--
.sentence {  font-family: Arial, Helvetica, sans-serif; font-size: 12pt;}
.sentence A {  text-decoration:underline; color: #E33838; }
.sentence A:hover {  color: #4444e0; text-decoration: underline; }
-->
</style>
      <?
$format = "mov";
$selarray = array("translation" => "Translation", "vocab" => "Vocabulary", "grammar" => "Grammar", "kanji" => "Kanji", "culture" => "Culture", "assign" => "Assigments");

include("db.inc.php");

include("str.inc.php");

list($ltitle) = mysql_fetch_row(mysql_query("SELECT title FROM lesson WHERE lesson = '$lesson'"));
?>
      <p align="center" class="heading"> 
<script>
function getDesc(mode, sid, id) {
	if (mode == "translation") id = sid;
	parent.document.all.descFrame.src = mode+"/"+id+".htm";
}
parent.document.all.descFrame.src = "intro.html";
</script>
        <font color="#000000" size="+1"> 
        <? $sel = $sel ? $sel : "translation"; echo "$ltitle: ".$selarray[$sel]; ?>
        </font></p>
      <?
$col = $sel ? ", $sel" : "";
$result = mysql_query("SELECT id, sid, sentence".$col." FROM lessondata WHERE lesson = '$lesson' ORDER BY sid") or die(mysql_error());
while (list($id, $sid, $sentence, $rangelist) = mysql_fetch_array($result)) {
	echo "<p class=\"sentence\"><a href=\"sound/$lesson"."_".leadzero($sid).".$format\" target=\"descFrame\"><img src=\"images/play.gif\" width=\"13\" height=\"13\" border=\"0\"></a>&nbsp;";
	$sentence = $sel ? makeLink($sentence, $id, unserialize($rangelist), $sel) : $sentence;
	echo $sentence."</p>

";
}
?>
<p>&nbsp;</p>
      <!-- #EndEditable --> </td>	</tr>	<tr> 		<td class="small" valign="bottom" height="30" align="center"> 			<hr>Copyright &copy; 2002 Shizuko N. Ariizumi. All rights reserved. </td>	</tr></table></body><!-- #EndTemplate --></html>