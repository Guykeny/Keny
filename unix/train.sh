#!/bin/bash

for x in $( find . -type f  -name "*.s?" 2>/dev/null ); do
res=$(du -h "$x"| cut -f1)
ol=$(pwd)
echo $ol "$x($res)"
done