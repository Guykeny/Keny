old_ifs="IFS"
IFS=$'\r\n'
contents=( $(df -h) )
IFS=$old_ifs

echo ${contents[1]}