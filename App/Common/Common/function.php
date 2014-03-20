<?php

function Char_cv($msg){
	if(is_array($msg)){
		foreach ($msg as $a=>$b){
			$msg[$a] = Char_cv($b);
		}
	}
	$msg = str_replace('%20','',$msg);
	$msg = str_replace('%27','',$msg);
	$msg = str_replace('*','',$msg);
	$msg = str_replace("\"",'',$msg);
	//$msg = str_replace('//','',$msg);
	$msg = str_replace('&amp;','&',$msg);
	$msg = str_replace('&nbsp;',' ',$msg);
	$msg = str_replace(';','',$msg);
	$msg = str_replace('"','&quot;',$msg);
	$msg = str_replace("'",'&#039;',$msg);
	$msg = str_replace("<","&lt;",$msg);
	$msg = str_replace(">","&gt;",$msg);
	$msg = str_replace('(','',$msg);
	$msg = str_replace(')','',$msg);
	$msg = str_replace("{",'',$msg);
	$msg = str_replace('}','',$msg);
	$msg = str_replace("\t","   &nbsp;  &nbsp;",$msg);
	$msg = str_replace("\r","",$msg);
	$msg = str_replace("   "," &nbsp; ",$msg);
	$msg = str_replace('select','',$msg);
	$msg = str_replace('insert','',$msg);
	$msg = str_replace('update','',$msg);
	$msg = str_replace('delete','',$msg);
	$msg = str_replace('union','',$msg);
	$msg = str_replace('into','',$msg);
	$msg = str_replace('load_file','',$msg);
	$msg = str_replace('outfile','',$msg);
	
	return $msg;
}
/**
 * 批量初始化POST or GET变量,并数组返回
 *
 * @param Array $keys
 * @param string $method
 * @param var $htmcv
 * @return Array
 */
function Init_GP($keys,$method='GP',$htmcv=1){
	!is_array($keys) && $keys = array($keys);
	$array = array();
	foreach($keys as $val){
		$array[$val] = NULL;
		if($method!='P' && isset($_GET[$val])){
			$array[$val] = $_GET[$val];
		} elseif($method!='G' && isset($_POST[$val])){
			$array[$val] = $_POST[$val];
		}
		$htmcv && $array[$val] = Char_cv($array[$val]);
	}
	return $array;
}

?>