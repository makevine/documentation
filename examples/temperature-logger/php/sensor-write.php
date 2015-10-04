<?php
/**
 * Simulates a temperature sensor and writes data to a Makevine channel
 *
 */

/*
Replace these values with your own.

Create a new channel with:

    $ curl http://makevine.com/create/example-check-temperature

*/
$CHANNEL = 'example-check-temperature';
$RWKEY   = 'REPLACE_THIS';

// No configuration necessary past here

// Simulate reading the temperature from a sensor
$temperature = rand(0, 100);

// Send to the channel
print "[sensor] Sending: " . $temperature . PHP_EOL;
sendMessageToChannel($temperature, $CHANNEL, $RWKEY);


/**
 * Writes a message to a Makevine channel via an HTTP POST request
 *
 * @param $message
 * @param $channel
 * @param $rwKey
 * @return string
 */
function sendMessageToChannel($message, $channel, $rwKey) {
    $postData = http_build_query(array(
        'text' => $message
    ));

    // Since we're writing a message to the channel we need to do a POST request
    $context = stream_context_create(
        array('http' => array(
            'method'  => 'POST',
            'header'  => 'Content-type: application/x-www-form-urlencoded',
            'content' => $postData
        ))
    );

    $url = sprintf("http://makevine.com/%s/%s", $channel, $rwKey);
    print $url . "\n";

    // We'll get back the message ID for the message we just sent. We'll use this
    // to make sure we only find messages created after we sent the command
    $messageId = file_get_contents($url, false, $context);

    return $messageId;
}