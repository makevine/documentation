# Makevine Examples

### Temperature Logger

A simulated temperature logger where a script writes temperature measurements to a channel. Another script reads these measurements and displays them in the terminal.

This is an example of a single writer and a single reader.

### Server Uptime Checker

A more complex example that demonstrates two-way communication and multiple writers to a channel.

This example demonstrates a script that runs on a server and listens for commands. Another script acts as a client and sends commands to all listeners. When the client sends out the 'uptime' command each server will respond with its uptime.
