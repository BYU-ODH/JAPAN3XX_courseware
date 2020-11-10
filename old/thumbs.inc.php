<?
function makeThumb($filename, $dest) {
	$size = GetImageSize($filename);
	$width = $size[0];
	$height = $size[1];
	$ratio_l = $width / $height;
	$ratio_p = $height / $width;
	
	if ($width > $height && $width > 120) {
		$width = 120;
		$height = round($width / $ratio_l);
	}
	if ($width < $height && $height > 120) {
		$height = 120;
		$width = round($height / $ratio_p);
	}
	echo "Size: $width x $height<br>";
	$imgorg = ImageCreateFromJPEG($filename);
	if (!$imgorg) {
		echo "The file $filename is not in JPG format!<br>";
		return;
	}
	$im = @ImageCreate ($width, $height) or die ("Cannot create new JPG format!<br>");
	ImageCopyResized($im, $imgorg, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
	ImageJpeg($im, $dest);
}
?>