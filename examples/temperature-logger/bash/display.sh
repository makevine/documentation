#!/usr/bin/env bash
#
# Displays the last value written by sensor-write.sh
#
# Requires a Makevine channel. Create one with:
#
#  $ curl http://makevine.com/create/desiredusername-temperature-example
#
# After creating a channel, replace the CHANNEL and KEY variables below
#

set -e # exit immediately on error

CHANNEL="username-temperature-example"
KEY="REPLACE_THIS"

# Read the temperature value from the channel every 5 seconds
while true; do
    DATA=`curl --silent http://makevine.com/${CHANNEL}/${KEY}`

    TEMPERATURE=$(echo "$DATA" | cut -d^ -f 2)

    echo "Last known temperature: ${TEMPERATURE}"

    # Always use a sleep call when making API calls in a loop. If you make requests
    # too quickly you will receive a rate limit error
    sleep 5
done