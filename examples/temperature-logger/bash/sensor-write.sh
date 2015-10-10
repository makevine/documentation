#!/usr/bin/env bash
#
# Writes simulated temperature readings
#
# Requires a Makevine channel. Create one with:
#
#  $ curl http://makevine.com/create/desiredusername-temperature-example
#
# After creating a channel, replace the CHANNEL and KEY variables below
#
# NOTE: this script requires the read/write key (starts with rw-)
#

set -e # exit immediately on error

CHANNEL="username-temperature-example"
KEY="REPLACE_THIS"

# Make temperature a random number in a reasonable range
TEMPERATURE=$RANDOM
let "TEMPERATURE %= 100"

echo "[sensor] Sending: ${TEMPERATURE}"

curl "http://makevine.com/${CHANNEL}/${KEY}" --data text="${TEMPERATURE}"

