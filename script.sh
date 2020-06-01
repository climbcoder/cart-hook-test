#!/bin/bash

# Bash script to delete files in a given directory that have name starting for "0aH"
# To run the script on a specific directory type ./script.sh <directory-name> otherwise will run on the current directory

# Tell to bash shell to split only by new line

IFS=$'\n'

# Use the directory of the parameter if set or current directory otherwise

if [ "$1" == "" ]; then
    DIR="."
else
    DIR=$1
fi

# Retrieve list of files with name that start for "0aH"

list="$(find $DIR -type f -name "0aH*")"

# Delete files in the list

for file in $list;
    do
        rm "$file"
done
