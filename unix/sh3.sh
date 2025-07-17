#!/bin/bash

echo "ce script est pour affiche un carre "
if [[ $# -eq 1 ]]; then
v1=$1
    if [[ -n $v1 ]]; then
    echo $(( $v1 * $v1 ))
    else
        echo " il est vide"
    fi
fi
