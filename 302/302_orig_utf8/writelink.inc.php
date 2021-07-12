<?
function writelink($url, $filename) {
	$srcpage = fopen($url, "r");
	$buffer = fread($srcpage, 1000000);
	fclose($srcpage);
	$destfile = fopen($filename, "w");
	fwrite($destfile, $buffer);
	fclose($destfile);
}
?>