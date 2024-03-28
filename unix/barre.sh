#!/bin/bash
 pourcentage=$((($1 + (10/2)) / 10)
echo -n "[ " 

for  i in $( seq 0 10); do
if [[ $i -lt $pourcentage ]]; then
echo -n "#"
else
    echo -n " "
fi
done
echo "]"