<html>
<head>
<title>Upload File to Server</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#FFFFFF" text="#000000">
<form enctype="multipart/form-data" method="post">
<input type="hidden" name="formsubmit" value="true">
<p>Select the File you want to send (click Browse):</p>
<p><input name="userfile" type="file"></p>
<input type="submit" value="Send">
</form>
<?
if (isset($formsubmit) && is_uploaded_file($userfile)) {
    copy($userfile, "/data/Uploads/".$userfile_name);
	chmod ("/data/Uploads/".$userfile_name, 0777);
	echo "File <b>".$userfile_name."</b> has been successfully uploaded.";
}

?>
</body>
</html>
