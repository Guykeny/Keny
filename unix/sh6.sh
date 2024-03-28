#!/bin/bash

echo "pour tester un argument passer en parametre"

if [[ -n $1 ]]; then
    if [[ -f $1 ]]; then
    echo " c'est un fichier passe en parametre "
    echo "l'affichage du fichier est : "
    cat $1 
    echo " le nombre de ligne est : "
    wc -l $1

    elif [[ -d $1 ]]; then
    echo " c'est un repertoire "
    m= cd $1; ls -l
    fi
    else
    echo "ce n'est ni une repertoire ou un fichier "
fi