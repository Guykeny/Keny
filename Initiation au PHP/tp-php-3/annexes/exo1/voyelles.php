<?php

// A COMPLETER
$filename="Latin-Lipsum.txt";
$f=file_get_contents($filename);

$filename="Latin-Lipsum.txt";
$f=file_get_contents($filename);
$chars=str_split($f);
$chars=str_split($f);
$voyelles=['a','e','i','o','u','e'];

$voyelles=array_filter($chars, function($c){
    global $voyelles;
    return in_array($c,$voyelles)
});

$vowels_in=array_filter($chars,function($c){
    global $voyelles;
    return in_array($c,$voyelles);
});
$voyels_count=[];
$v=array_wa
$vowels_count=[];

$V=array_walk($vowels_in, function($v) use (&$vowels_count){
    (!array_key_exists($v, $vowels_count)) ? $vowels_count[$v]=1 : $vowels_count[$v]= $vowels_count[$v]+1;
});
var_dump($V);
// TEST
print_r($vowels_count);

?>