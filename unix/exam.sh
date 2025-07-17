#!/bin/bash

if [[ -z $1 ]];
then
    echo -n "ce fichier doit etre apple avec un argument"
    exit 1
fi

var=$1;
echo "le nombre de ligne est : ${#var}"
 
 i=0
while [[ ${#var} -gt 0 ]]; do
msg=""
va=${var:0:1}
for (( k=0 ; k< va ; k++ )); do
    msg="$msg*"
done
i=$(($i + 1))
var=${var#${var:0:1}}
echo "$msg"
done


