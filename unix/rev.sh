#!/bin/bash

if [[ -z $1 ]]; then

echo " erreur le fichier ne doit etre vide "
exit 1
else
    res=1
    while IFS= read -r ligne ; do
    mots=$(echo "$ligne"|tr -d ',')
    mot=$(echo "$mots"|wc -w )
    echo "Ligne $res : $mot mots"
    (( res++ ))
    done < "$1"
fi