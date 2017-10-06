#!/bin/bash

declare ALARM=true
declare -i TEMPERATURE=-1
declare -i CLEANING_TIME=30

echo '----------------------------------------'
echo '---------Getting Ready for Work---------'
echo '----------------------------------------'
echo ''
echo ''
echo '1) Open Eyes'
if [ $ALARM=true ] ; then
    echo '2) Stand up!'
    echo '3) Take Shower...'
    # Is it going to be a cold day?
    # What to wear today
    if [ $TEMPERATURE -ge 10 ] ; then  
        echo '4) Wear skirt'
    elif [ $TEMPERATURE -lt 10 ] && [ $TEMPERATURE -gt 0 ] ; then
        echo '4) Wear pants'
    elif [ $TEMPERATURE -le 0 ] ; then
        echo '4) Wear really warm pants'
    fi
    # Breakfast is the most important meal of the day
    echo '5) Have healthy breakfast'
    # Brushing teeth correctly -> at least 30 seconds
    echo ''
    for COUNT in `seq 1 $CLEANING_TIME`
    do
        echo "Brushing teeth: $COUNT seconds..."
        sleep 1
    done
    echo ''
    echo '6) Teeth shine and clean :)'
else
    echo ':) Keep sleeping :)'
fi
