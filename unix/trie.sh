#!/bin/bash

old_ifs="IFS"
IFS=$'\r\n'
contents=( $(ls .) )
IFS=$old_ifs

for ((i=0; i<${#contents[@]}; i++)); do
    for ((j=i+1; j<${#contents[@]}; j++)); do

    ci=${#contents[i]}
    cj=${#contents[j]}

    if [[ $cj -gt $ci ]]; then
    temp=${contents[i]}
    contents[i]=${contents[j]}
    contents[j]=$temp
    fi
    done
done
for x in ${contents[@]}; do
echo "$x"
done