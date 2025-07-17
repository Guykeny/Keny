#! /bin/bash

function afficher_barre_pourcentage(){
    # On commence par recuperer le pourcentage
    pourcentage=$1

    # Ensuite on utilise une formule mathematique pour faire un arrondi au plus proche et ainsi calculer le nombre de hashtags a afficher (source : https://stackoverflow.com/questions/2395284/round-a-divided-number-in-bash)
    # en gros pour arrondir on ajoute la moitié du demon au nominateur ce qui arrondi a l'entier le plus proche la division des deux
    hashtags=$(((pourcentage + (10/2)) / 10)

    echo -ne "["
    # avec une boucle on echo le nombre de # voulu et on complete par des espaces
    for (( i=0; i<10; i+=1 ))
    do

        if [[ $i -lt $hashtags ]]
        then
            echo -n "#"
        else
            echo -n " "
        fi

    done
    echo -n "]"

}

function df_avec_barre_pourcentage(){

    # Oncommence par analyser les options
    # On stocke l'affichage de df (Avec les eventuelles options) et le nombre de lignes de celui ci (pour faciliter l'operation)
    # Cependent si on a un --sort on trie directement ici

    if [[ $1 -eq 1 ]]
        then
            shift
            affichage=$(df $1 $2 $3 | tail -n +2 | sort -i -t' ' -k5 ) 
        else
            shift
            affichage=$(df $1 $2 $3 | tail -n +2)
    fi
    #echo "$affichage"
    nlignes=$(echo "$affichage" | wc -l | awk '{ print $1 }')
    for (( j=1; j<nlignes; j+=1 ))
    do
        # On stocke la ligne actuelle
        ligne_actuelle=$(echo "$affichage" | head -$j | tail -1)

        # On extrait le pourcentage et on retire le symbole %
        pourcentage=$(echo "$ligne_actuelle" | awk '{ print $5 }' | tr -d '%')

        # Maintenant il nous reste a print la barre (appel a la fonction) puis afficher le reste de la ligne
        afficher_barre_pourcentage $pourcentage
        echo "$ligne_actuelle"
        
    done
}

human=""
local=""
total=""
sort="_"
while [[ $# -gt 0 ]]
do

    case $1 in 

        "-h")
            human=" -h "
        ;;

        "-l")
            local=" -l "
        ;;

        "--total")
            total=" --total "
        ;;

        "--sort")
            sort=1
        ;;

        "--help")
            echo "Usage : ./dfbar [-h] [-l] [--total] [--sort] [--help]"
            exit
        ;;

        *)
            echo "Error: unsupported option: --bad-opt"
            exit
        ;;

    esac
    shift
done

df_avec_barre_pourcentage $sort $human $local $total