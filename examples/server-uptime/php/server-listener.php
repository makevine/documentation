<?php
/**
 * An example script that can be run on a server and listens for an
 * 'uptime' command.
 *
 * Replace the $CHANNEL and $RWKEY variables below and then execute this script.
 *
 * It will listen for new messages on the specified channel and reply when it
 * gets an 'uptime' command.
 *
 * This command can be sent with the client.php script.
 */

/*
Replace these values with your own.

Create a new channel with:

    $ curl http://makevine.com/create/example-execute-commands

*/
$CHANNEL = 'example-execute-commands';
$RWKEY   = 'REPLACE_THIS';

// No configuration necessary past here

// We only want to respond to messages that happen after the script starts
// Once we read our first message this variable will be assigned to a message ID
// instead of a date to ensure we only read messages we haven't already handled
$since = date_format(new DateTime(), DATE_RFC3339);

print "Listening for commands..." . PHP_EOL;

while (true) {
    // Always use a sleep call when making API calls in a loop
    sleep(5);

    $url = sprintf("http://makevine.com/%s/%s?since=%s", $CHANNEL, $RWKEY, $since);
    // The return value from this will be a string that looks like:
    // message-id^value
    $mostRecentMessageData = file_get_contents($url);

    // $mostRecentMessageData will be blank if there are no messages or in case of error
    if (!$mostRecentMessageData) continue;

    // Parse the returned data to extract the temperature field
    list($messageId, $command) = explode('^', $mostRecentMessageData);

    // Send the command to the handler function
    handleCommand($command);

    if ($messageId) {
        $since = $messageId;
    }
}

/**
 * Implementation of commands that this script supports.
 *
 * @param $command
 */
function handleCommand($command) {
    global $CHANNEL;
    global $RWKEY;

    switch ($command) {
        case 'uptime':
            print "[$command] sending uptime" . PHP_EOL;
            // Execute the 'uptime' command and store the result
            $uptimeString = trim(`uptime`);
            // Include our hostname in the message we send back
            $message = sprintf('[%s] %s', gethostname(), $uptimeString);

            sendMessageToChannel($message, $CHANNEL, $RWKEY);
            break;
        default:
            // Something other than a valid command so we can ignore it
            break;
    }
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