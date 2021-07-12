<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<script>
fields = Array("name", "section", "s1", "s2");
cookies = Array();

function setCookie(name, value) {
	var today = new Date();
	var expiry = new Date(today.getTime() + 30 * 86400);
	document.cookie = name + "=" + escape(value) + "; expires=" + expiry.toGMTString();
}

function cookieArray() {
	s_cookies = document.cookie;
	while (s_cookies.indexOf("=") > 0) {
		var s_key = unescape(s_cookies.substring(0, s_cookies.indexOf("=")));
		if (s_cookies.indexOf(";") > 0) {
			var s_value = unescape(s_cookies.substring(s_cookies.indexOf("=") + 1, s_cookies.indexOf(";")));
			s_cookies = s_cookies.substring(s_cookies.indexOf(";") + 2);
		} else {
			var s_value = unescape(s_cookies.substring(s_cookies.indexOf("=") + 1, s_cookies.length));
			s_cookies = "";
		}
		if (eval("document.forms.exercises."+s_key) != "undefined")
			document.forms.exercises[s_key].value = s_value;
	}
}

function f_clear() {
	for (i = 0; i < fields.length; i++) {
		setCookie(fields[i], "");
	}
}

function save() {
	for (i = 0; i < fields.length; i++) {
		setCookie(fields[i], document.forms.exercises[fields[i]].value);
	}
	alert("Your work has been successfully saved on this computer!");
}

function send() {
	s_send = "course=j301";
	for (i = 0; i < fields.length; i++) {
		s_send += "&" + fields[i] + "=" + escape(document.forms.exercises[fields[i]].value);
	}
	window.location = "http://j301n.ariizumi.net/submit.php?"+escape(s_send);
}
</script>
<body bgcolor="#FFFFFF" text="#000000">
<p>Japanese 301 Exercises</p>
<form name="exercises" method="post" action="http://j301n.ariizumi.net/submit.php">
  <table border="1">
    <tr> 
      <td>Name:</td>
      <td>
        <input type="text" name="name">
      </td>
    </tr>
    <tr> 
      <td>Section:</td>
      <td>
        <input type="text" name="section">
      </td>
    </tr>
  </table>
  <p>Example 1</p>
  <p>Describe the following picture:</p>
  <p>1. 
    <input type="text" name="s1" size="40">
    <br>
    2. 
    <input type="text" name="s2" size="40">
  </p>
  <p> 
    <input type="submit" value="Send">
    <input type="button" value="Save" onClick="save()">
    <input type="reset" value="Clear" onClick="f_clear()">
  </p>
  </form>
<script>
cookieArray();
</script>
</body>
</html>
