# Makevine FAQ

## Security

### Does Makevine support HTTPS?

It's coming soon!

### Is there an easy way to encrypt the content of a message?

If you're using Makevine from the command line, the `openssl` binary can be used.

First, encrypt and base64-encode the message:

    $ echo "example message" | openssl enc -aes-192-cbc -a -k "secret_password"
      U2FsdGVkX18g3HyyjDEv/J7P3KX/opHi5wL5GmUu6ViaHcczMPVZSzc8n+IwhbOi
    
To decrypt it, reverse this process:

    $ echo "U2FsdGVkX18g3HyyjDEv/J7P3KX/opHi5wL5GmUu6ViaHcczMPVZSzc8n+IwhbOi" | openssl enc -d -aes-192-cbc -a -k "secret_password"
      example message
      
The pass phrase ("secret_password" in this example) should only be known by the devices
that are encrypting and decrypting the messages.

### How do I secure access to my channels?

Channel access is managed through keys that provide varying levels of privileges:

 * Read-only key: only allows reading messages
 * Read/write key: allows reading and writing to a channel
 * Admin key: allows changing channel properties and admin-level operations. This key should NEVER be shared or stored in source code.
 
Access keys are randomly generated. There are approximately 4x10^5 possible values for each key.