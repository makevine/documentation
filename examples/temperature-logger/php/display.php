<?php
/**
 * Reads the most recent temperature from the channel and displays it
 */

/*
Replace these values with your own.

Create a new channel with:

    $ curl http://makevine.com/create/example-check-temperature

*/
$CHANNEL = 'example-check-temperature';
$RWKEY   = 'REPLACE_THIS';


// Read the temperature value from the channel every 5 seconds
while (true) {
    $url = sprintf("http://makevine.com/%s/%s", $CHANNEL, $RWKEY);

    // The return value from this will be a string that looks like:
    // message-id^value
    $mostRecentMessageData = file_get_contents($url);

    // Parse the returned data to extract the temperature field
    list($messageId, $temperature) = explode('^', $mostRecentMessageData);

    // If we don't have a message ID then something went wrong
    if (!$messageId) {
        $temperature = '--';
    }

    print "Last known temperature: " . $temperature . PHP_EOL;

    // Always use a sleep call when making API calls in a loop to avoid unnecessary
    // server load. If you make requests too quickly you will receive a rate limit
    // error
    sleep(5);
}