#!/bin/bash

PORT=8000
IP="0.0.0.0"

# HTML Template
HTML_PAGE='
<!DOCTYPE html>
<html>
<head>
    <title>Web Terminal</title>
    <style>
        body { font-family: Arial, sans-serif; background: #121212; color: #fff; text-align: center; padding: 20px; }
        textarea { width: 80%; height: 200px; background: #1e1e1e; color: #0f0; font-family: monospace; padding: 10px; }
        input, button { background: #333; color: #fff; border: none; padding: 10px; margin: 5px; }
    </style>
</head>
<body>
    <h2>Web Terminal - Port 8000</h2>
    <form method="POST" action="/">
        <input type="text" name="command" placeholder="Enter command..." required>
        <button type="submit">Execute</button>
    </form>
    <textarea readonly>{{output}}</textarea>
</body>
</html>
'

# Function to handle command execution and output
handle_request() {
    # Get the command from the input
    read -r command
    
    # If there's a command, execute it
    if [[ -n "$command" ]]; then
        # Capture command output
        output=$(eval "$command" 2>&1)
    else
        output="No command received."
    fi

    # Return the response (HTML with output)
    echo -e "HTTP/1.1 200 OK\r\nContent-Type: text/html\r\n\r\n"
    echo -e "$HTML_PAGE" | sed "s|{{output}}|$output|g"
}

# Start the web server with Netcat
while true; do
    # Listen on port 8000 for incoming HTTP requests
    nc -l -p "$PORT" -c 'handle_request'
done
