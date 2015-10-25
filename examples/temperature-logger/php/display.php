<?php
#
# Writes simulated temperature readings
#
# Requires a Makevine channel. Create one with:
#
#  $ curl http://makevine.com/create/desiredusername-temperature-example
#
# After creating a channel, replace the CHANNEL and KEY variables below
#

$CHANNEL = 'example-check-temperature';
$KEY     = 'REPLACE_THIS';


// Read the temperature value from the channel every 5 seconds
while (true) {
    $url = sprintf("http://makevine.com/%s/%s", $CHANNEL, $KEY);

    // The most recent message is our temperature
    $mostRecentMessage = file_get_contents($url);

    // If we don't have a message ID then something went wrong
    if (!$mostRecentMessage) {
        $temperature = '--';
    }

    print "Last known temperature: " . $mostRecentMessage . PHP_EOL;

    // Always use a sleep call when making API calls in a loop. If you make requests
    // too quickly you will receive a rate limit error
    sleep(2);
}