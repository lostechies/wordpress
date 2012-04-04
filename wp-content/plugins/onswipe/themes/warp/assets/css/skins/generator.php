<?php

$colors = array(
    'green' => '#96cc4f',
    'orange' => '#f7930b',
    'pink' => '#de2384',
    'gray' => '#9da1a2',
    'cream' => '#cec8b2',
    'tan' => '#c69c62',
    'darkblue' => '#2b3d62',
    'red' => '#900',
);

foreach ($colors as $name => $value) {
    $styles = '$color_text : #333;'."\n";
    $styles.= '$color_highlight : '.$value.';'."\n";
    $styles.= "\n@import 'base';\n";
    file_put_contents($name.".scss",$styles);
    echo exec("sass {$name}.scss {$name}.css");
    unlink("{$name}.scss");
}

?>