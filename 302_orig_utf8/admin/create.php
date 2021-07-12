<html>
<head>
<title>Create New Content</title>
<meta http-equiv="Content-Type" content="text/html; charset=Shift_JIS">
<style type="text/css">
<!--
.default {  font-family: Tahoma, Helvetica, sans-serif; font-size: 10pt}
-->
</style>
</head>

<body bgcolor="#FFFFFF" text="#000000" class="default">
<p>Create New Content</p>
<p>I want to create a new:</p>
<ul>
  <li><a href="create.php?c=lesson">Lesson</a></li>
  <li><a href="create.php?c=sentence">Sentence</a> in a Lesson</li>
  <li><a href="create.php?c=kanji">Kanji</a></li>
  <li><a href="create.php?c=grammar">Grammar</a></li>
  <li><a href="create.php?c=vocab">Vocabulary</a></li>
</ul>
<?
if ($a) {
	include("../db.inc.php");
}

if ($a == "lesson") {
	mysql_query("INSERT INTO lesson VALUES('$lesson', '$title')") or die(mysql_error());
	echo "<b>Successfully added!</b><br>";
}
if ($a == "sentence") {
	mysql_query("INSERT INTO lessondata VALUES(NULL, '$lesson', '$sid', '$sentence', '$translation', '', '', '', '', '', '')") or die(mysql_error());
	echo "<b>Successfully added!</b><br>";
}
if ($a == "kanji") {
	mysql_query("INSERT INTO kanji VALUES(NULL, '$kanji', '$location', '$def', '$defeng', '$lesson')") or die(mysql_error());
	echo "<b>Successfully added!</b><br>";
}
if ($a == "grammar") {
	mysql_query("INSERT INTO grammar VALUES(NULL, '$search', '$display', '$def')") or die(mysql_error());
	echo "<b>Successfully added!</b><br>";
}
if ($a == "vocab") {
	mysql_query("INSERT INTO vocab VALUES(NULL, '$search', '$display', '$def', '$reading')") or die(mysql_error());
	echo "<b>Successfully added!</b><br>";
}

if ($c == "lesson") { ?>
<form name="form1" method="post" action="">
  <input type="hidden" name="a" value="lesson">
  <p><b>Lesson</b><br>
  </p>
  <table border="1">
    <tr> 
      <td class="default"><b>Lesson #:</b></td>
      <td class="default"> 
        <input type="text" name="lesson" size="3" maxlength="4">
      </td>
    </tr>
    <tr> 
      <td class="default"><b>Title:</b></td>
      <td class="default"> 
        <input type="text" name="title" size="40">
      </td>
    </tr>
  </table>
  <br>
  <input type="submit" value="Create">
</form>
<? } ?>
<? if ($c == "sentence") { ?>
<form name="form1" method="post" action="">
  <input type="hidden" name="a" value="sentence">
  <b>Sentence<br>
  <br>
  </b> 
  <table border="1">
	<tr> 
	<td class="default"><b>Lesson #:</b></td>
	<td class="default"> <b> 
	<input type="text" name="lesson" size="3" maxlength="4">
	</b></td>
	</tr>
	<tr> 
	<td class="default"><b>Sentence #:</b></td>
	<td class="default"> <b> 
	<input type="text" name="sid" size="3" maxlength="3">
	</b></td>
	</tr>
	<tr> 
	<td class="default"><b>Sentence:</b></td>
	<td class="default"> <b> 
	<input type="text" name="sentence" size="40">
	</b></td>
	</tr>
	<tr> 
	<td class="default"><b>Translation:</b></td>
	<td class="default"> <b> 
	<input type="text" name="translation" size="40">
	</b></td>
	</tr>
	</table>
  <br>
  <input type="submit" value="Create" name="submit">
</form>
<? } ?>
<? if ($c == "kanji") { ?>
<form name="form1" method="post" action="">
  <input type="hidden" name="a" value="kanji">
  <b>Kanji</b><br>
  <br>
  <table border="1">
    <tr> 
      <td class="default"><b>Kanji:</b></td>
      <td class="default"> <input type="text" name="kanji" size="3" maxlength="4"> 
      </td>
    </tr>
    <tr> 
      <td class="default"><b>Definition:</b></td>
      <td class="default"> <textarea name="def" cols="60" rows="3"></textarea> 
      </td>
    </tr>
    <tr> 
      <td class="default"><b>English:</b></td>
      <td class="default"> <textarea name="defeng" cols="60" rows="3"></textarea> 
      </td>
    </tr>
    <tr>
      <td class="default"><strong>Lesson #:</strong></td>
      <td class="default"><input name="lesson" type="text" id="lesson" size="5"></td>
    </tr>
    <tr> 
      <td class="default"><b>Filename:</b></td>
      <td class="default"> <input type="text" name="location"> </td>
    </tr>
  </table>
  <br>
  <input type="submit" value="Create" name="submit2">
</form>
<? } ?>
<? if ($c == "grammar") { ?>
<form name="form1" method="post" action="">
  <input type="hidden" name="a" value="grammar">
  <b>Grammar</b><br>
  <br>
  <table border="1">
    <tr> 
      <td class="default"><b>Search Pattern:</b></td>
      <td class="default"> 
        <input type="text" name="search" size="40">
      </td>
    </tr>
    <tr> 
      <td class="default"><b>Display Pattern:</b></td>
      <td class="default"> 
        <input type="text" name="display" size="40">
      </td>
    </tr>
    <tr>
      <td class="default"><b>Definition:</b></td>
      <td class="default">
        <textarea name="def" cols="60" rows="5"></textarea>
      </td>
    </tr>
  </table>
  <br>
  <input type="submit" value="Create" name="submit3">
</form>
<? } ?>
<? if ($c == "vocab") { ?>
<form name="form1" method="post" action="">
  <input type="hidden" name="a" value="vocab">
  <b>Vocabulary</b><br>
  <br>
  <table border="1">
    <tr> 
      <td class="default"><b>Search Pattern:</b></td>
      <td class="default"> 
        <input type="text" name="search" size="40">
      </td>
    </tr>
    <tr> 
      <td class="default"><b>Display Form:</b></td>
      <td class="default"> 
        <input type="text" name="display" size="40">
      </td>
    </tr>
    <tr> 
      <td class="default"><b>Definition:</b></td>
      <td class="default"> 
        <textarea name="def" cols="60" rows="3"></textarea>
      </td>
    </tr>
    <tr> 
      <td class="default"><b>Hiragana Read:</b></td>
      <td class="default">
        <input type="text" name="reading">
      </td>
    </tr>
  </table>
  <br>
  <input type="submit" value="Create" name="submit4">
</form>
<? } ?>
<p>&nbsp;</p>
</body>
</html>
