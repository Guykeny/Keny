<?php

// code HTML de champ texte mono-ligne
function form(string $legend, string $action, string $methode):string 
{
    $code= "<form action=\"$action\" methode=\"$methode\">\n";
    $code .= "<fieldset> <legend>$legend</legend>";
    return $code;
}
function form(string $legend, string $action, string $methode):string
{
    $code= "<form action=\"$action\" methode=\"$methode\" >\n";
    $code .= "<fieldset><legend>$legend</legend></fieldset>";
    return $code;
}
function text(string $libtexte, string $nomtexte): string
{
    // A COMPLETER
    $code="<label><b>$libtexte </b></label><input type=\"text\" name=\"$nomtexte\"><br>\n";
    return $code;

}
function text(string $libtexte, string $nomtexte): string
{
    $code = "<label><b>$libtexte</b></label><input type=\"text\" name=\"$nomtexte\">";
    return $code;
}

// code HTML de bouton de soumission
function submit(string $libsubmit, string $libreset): string
{
    // A COMPLETER"
   $code= "<input type=\"submit\" value=\"$libsubmit\">\n";
   $code .= "<input type=\"reset\" value=\"$libreset\">";

    return $code;

}
function submit(string $libsubmit, string $libreset): string{
    $code= "<input type=\"submit\" value=\"$libsubmit\" >";
    $code .= "<input type=\"reset\" value=\"$libreset\" >";

    return $code;
}
function radio(string $lib, string $codel, string $val):string 
{
    $code= "<label>$lib</label><input type=\"radio\" name=\"$codel\" value=\"$val\" ><br>\n";
    
    return $code;
}
function radio(string)
function inform():string 
{
    $code= "</fieldset></form>\n";
    return $code;
}

// A ETENDRE
?>
