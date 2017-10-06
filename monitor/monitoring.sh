#!/bin/bash

while [ true ]
do
	pid=$(pgrep time.sh)
	if [ "$pid" == '' ]; then
		bash ./time.sh
	fi
done
