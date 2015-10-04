# Temperature Logger Example (PHP)

### Setup

Before running these examples, you must have created a Makevine channel.

For example:

    $ curl http://makevine.com/create/username-channel-name

Replace `username` with your preferred username and `channel-name` with anything that makes sense to you!


### Getting the Example

Either check out this repository:

    $ git clone git@github.com:makevine/documentation.git

Or download these files manually:

    $ curl -O https://raw.githubusercontent.com/makevine/documentation/master/examples/temperature-logger/php/display.php
    $ curl -O https://raw.githubusercontent.com/makevine/documentation/master/examples/temperature-logger/php/sensor-write.php


### Running the Example

In one terminal window:

    $ php display.php


In another terminal window:

    $ php sensor-write.php


A few seconds after executing `sensor-write.php` the first terminal window will display the last temperature sent to the channel.