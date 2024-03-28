#!/bin/bash


OLD_IFS="$IFS" 
IFS=$'\r\n' 
contents=( $(df -h) ) 
IFS="$OLD_IFS"
nbLines=$(expr ${#contents[@]} - 1) 
idx=-1
rep=""
for i in $(seq 1 $nbLines); do
line="${contents[i]}" 
repLine="${line##* }"
match=$(pwd | grep -o "$repLine") 
if [ -n "$match" ]; then
if [ ${#rep} -lt ${#match} ]; then 
idx=$i
rep="$repLine" 
fi
fi 
done
lineRes="${contents[idx]}"
tabRes=($lineRes) # initialisation d'un tableau par une chaine, espace = dé
echo "${tabRes[3]}"