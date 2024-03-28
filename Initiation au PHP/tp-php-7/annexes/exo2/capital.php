<?php 
//json_decode — Décode une chaîne JSON
//file_get_contents — Lit tout un fichier dans une chaîne
$capital=json_decode(file_get_contents("country-by-capital-city.json"), true , 3, JSON_OBJECT_AS_ARRAY);
$capi=[];
foreach($capital as $value){
    $capi[$value["country"]]= $value['city'];
    
}
usort($capi , function($a, $b){
    return $b <=> $a;
});
array_walk($capi, function($value, $key){
    echo $key . ' - ' . $value . '<br/>';
});

?>