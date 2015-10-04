<?php
/**
 * Sends commands and waits for responses from anything that listens on the channel.
 */

/*
Replace these configuration variables with your own values.

Create a new channel with:

    $ curl http://makevine.com/create/example-execute-commands

*/
$CHANNEL = 'example-execute-commands';
$RWKEY   = 'REPLACE_THIS';

// No configuration necessary past here

// Send the command to the channel. The return value will be the message ID
// of the command we just sent. It will be used later to ensure we only
// retrieve messages created after we sent this command.
$since = sendMessageToChannel('uptime', $CHANNEL, $RWKEY);

// This will be blank if there was a communication error
if (!$since) {
    print "Error sending command to channel" . PHP_EOL;
    exit(1);
}

// Pause for a while to wait for clients to respond
print "Sent message ID $since, waiting for responses..." . PHP_EOL;
print PHP_EOL;
sleep(10);

// Read responses until we don't find any more
while (true) {
    // We only care about responses that were written after we sent our command
    $url = sprintf("http://makevine.com/%s/%s?since=%s", $CHANNEL, $RWKEY, $since);
    // The return value from this will be a string that looks like:
    // message-id^value or blank if no messages are available
    $mostRecentMessageData = file_get_contents($url);

    // $mostRecentMessageData will be blank if there are no messages left to read
    if (!$mostRecentMessageData) break;

    // Parse the returned data to extract the response
    list($messageId, $response) = explode('^', $mostRecentMessageData);

    print " > " . $response . PHP_EOL;

    // Update $since so we get the next unread message on the next loop iteration
    $since = $messageId;
}


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

    // We'll get back the message ID for the message we just sent. We'll use this
    // to make sure we only find messages created after we sent the command
    $messageId = file_get_contents($url, false, $context);

    return $messageId;
}