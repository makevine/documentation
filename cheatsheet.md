# Makevine Cheatsheet

See the [API Guide](api-guide.md) for more information and detailed examples. 

## Channels

Create an anonymous channel:

    curl http://makevine.com/create/desiredusername-project-name

Create a channel and associate it with your account:
 
    curl http://makevine.com/create/desiredusername-project-name?email=user@example.com
    

## Messages

Get the most recent message on a channel:

    curl http://makevine.com/desiredusername-project-name/ro-example-key-here
     

Send a message to a channel:
    
    curl http://makevine.com/desiredusername-project-name/rw-example-key-here --data "message text here"

