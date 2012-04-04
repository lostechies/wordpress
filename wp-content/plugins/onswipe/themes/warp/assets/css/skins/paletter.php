<?php

$dir = dirname(dirname(dirname(__DIR__)));

// get the file
$styles = file_get_contents($dir . "/style.scss");

// remove comments
$styles = $text = preg_replace('!/\*.*?\*/!s', '', $styles);
$styles = preg_replace('/\n\s*\n/', "\n", $styles);

// turn into array
$styles = explode("\n",$styles);

$filtered = '';

foreach ($styles as $rule) {

    if (should_save($rule)) {
        $filtered .= $rule . "\n";
    }

}

file_put_contents('base.scss',$filtered);

function pr($v){
    echo "<pre>";
    print_r($v);
    echo "</pre>";
}

function str_contains($pattern,$str){
	$p = strpos($str,$pattern);
	return ($p !== false);
}

function has_color($str){
    return str_contains('$color_',$str);
}

function is_selector($str){
    return ( str_contains('{',$str) || str_contains('}',$str) );
}

function should_save($str){
    return (is_selector($str) or has_color($str) );
}

?>