<?
function convertSet($mlist) {
	$list = array();
	$i = 0;
	while (strpos($mlist, ",") > 0) {
		$list[$i++] = substr($mlist, 0, strpos($mlist, ","));
		$mlist = substr($mlist, strpos($mlist, ",") + 1);
	}
	$list[$i] = $mlist;
	return $list;
}

function checkVocab($list, $id) {
	$listfind = $list[$id][1];
	for ($i = 0; $i < sizeof($list); $i++) {
		if (strpos($list[$i][1], $listfind) !== false && $i != $id) return false;
	}
	return true;
}

function makeLink($str, $sid, $list, $mode) {
	if ($mode == "translation") {
		return "<a href=\"javascript:getDesc('$mode',$sid,$sid)\" style=\"color: #000000;\">$str</a>";
	}
	
	for ($i = 0; $i < sizeof($list); $i++) {
		if ($mode != "vocab" || ($mode == "vocab" && checkVocab($list, $i))) {
			list($mid, $mstr) = $list[$i];
			$mid += 0;
			$moffset = strpos($str, $mstr);
			$insert = "\r\n<a href=\"javascript:getDesc('$mode',$sid,$mid)\">$mstr</a>";
			if (!($moffset === false)) $str = substr($str, 0, $moffset).$insert.substr($str, $moffset + strlen($mstr));
		}
	}
	return $str;
}

function leadzero($number) {
	if ($number < 10) {
		return "0".$number;
	} else {
		return $number;
	}
}

?>