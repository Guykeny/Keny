<?php
$filename="Latin-Lipsum.txt";
$file=file_get_contents($filename);

$chars=str_split($file);
$voyelles=[
    'a',
    'e',
    'i',
    'u',
    'o',
];
$vowels_in=array_filter($chars, function($a){
    global $voyelles;
   return in_array($a,$voyelles);
});
$vowels_count=[];
array_walk($vowels_in, function($a) use (&$vowels_count){
     (!array_key_exists($a,$vowels_count)) ? $vowels_count[$a]=1 : $vowels_count[$a] += 1;
});
print_r($vowels_count);
?>
