<?php
if (!isset($_SESSION["available_languages"])) {
	$dir = "../app/language/lang";
	$files = array_diff(scandir($dir), array('.', '..'));
	$languages = array();
	foreach ($files as $key => $value) {
		//$value =  substr_replace($value, '', 5) . "<br/>";
		$value = substr($value, 5);
		$value = substr($value, 0, -4);
		//echo $value . "\n";
		$languages[] = $value;
	}
	//var_dump($languages); 
	$_SESSION["available_languages"] = $languages;
}
?>