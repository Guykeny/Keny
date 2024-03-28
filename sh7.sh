#!/bin/bash

echo " ce script est pour afficher le menu "

while [[ 1 ]]; 
do
    echo -e "affiche la date  1 : " 
    echo  -e " affiche le nombre de personne connecte 2"
    echo -e " affiche la taille disponibe du disque 4"
    echo -e "faire un zero pour sortir  0"
    echo -n " votre choix "

read choix
 case $choix in
 1) date ;;
 2)who | wc -l ;;
 3)df -h ;;
 0) exit ;;
 *) echo " choisir enntre 0 à 3 merci "
 esac
 done
