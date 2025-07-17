#!/bin/bash



read n
if [[ $n -lt 0 ]]; then
echo "la valeur doit etre superieur à 0"
exit 1
fi
b=0
d=1
for (( i=0 ; i<n ; i++ )); do

c=$((b + d));
echo "$c"
b=$d
d=$c
done
