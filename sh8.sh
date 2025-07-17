#!/bin/bash

echo " ce script est pour affiche toutes les les images "

for x in $(find / \( -name "*.jpg" -a -name "*.png"  \) -size +1M -exec echo {} \; 2>/dev/null);
do
    res=$( du -h "$x"| cut -f1 )
    echo "$res # $x"
done