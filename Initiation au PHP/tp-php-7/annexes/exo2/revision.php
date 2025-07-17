<?php 
$capital=json_decode(file_get_contents("country-by-capital-city.json"), true, 3, JSON_OBJECT_AS_ARRAY);

$cpi=[];
foreach($capital as $val){
    $cpi[$val["country"]]=$val["city"];
}
uksort($cpi, function($a, $b){
    return $b <=> $a;
});
array_walk($cpi, function($value, $key){
    echo $key . ' - ' . $value . '<br/>';
});
?>