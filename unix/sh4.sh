#!/bin/bash

echo "ce script affiche la liste des carre compris dans une intervalle"

if [[ $# -eq 2 ]]; then
v=$1
d=$2;
for (( k=$1; k<= $d ; k++ )); do
echo $(( $k * $k ))
done
else
    echo "ca ne marche pas"
fi
