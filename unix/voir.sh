#!/bin/bash

echo -n "creation d'un menu "



if [[ -d $1 ]]; then
case $2 in 
"TOTO") cd $1; 
read n
if [[ -n $n ]]; then
for i in $( seq 1 $n); do
mkdir $2$i
done
fi
;;
"fic")
a=0
b=0
if [[ -n $2 ]] && [[ -f $2 ]]; then
    while IFS= read -r ligne; do
    a=$(echo "$ligne"| grep -o 'a=[0-9]*' )
    a= $(echo "$a"|sed 's/a=//' )
    b=$(echo "$ligne"| grep -o 'b=[0-9]*' )
    b= $(echo "$b"|sed 's/b=//') 
    
  
    if [[ -n "$a" ]] && [[ -n "$b" ]]; then
    somme=$(( a + b ))
    echo "la sommee est : $somme"
    exit 0
    else 
     echo "il a rien "
    fi
    done
    else
    echo "on n'apas trouve de a et b"
fi;;
*) echo " erreur il faut mettre quelque chose " 
exit 1;;
esac
fi

