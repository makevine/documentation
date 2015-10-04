# Server Uptime Example (PHP)

### Setup

Before running these examples, you must have created a Makevine channel.

For example:

    $ curl http://makevine.com/create/username-channel-name

Replace `username` with your preferred username and `channel-name` with anything that makes sense to you!


### Getting the Example

Either check out this repository:

    $ git clone git@github.com:makevine/documentation.git

Or download these files manually:

    $ curl -O https://raw.githubusercontent.com/makevine/documentation/master/examples/server-uptime/php/client.php
    $ curl -O https://raw.githubusercontent.com/makevine/documentation/master/examples/server-uptime/php/server-listener.php


### Running the Example

In one terminal window:

    $ php server-listener.php


In one or more other terminal windows (try a few different hosts):

    $ php client.php


`client.php` will send out the uptime command, wait for responses, and then print them out.