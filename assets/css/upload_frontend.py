import paramiko
import os

# Connection details
HOST = "77.37.127.162"
PORT = 65002
USER = "u470101590"
PASSWORD = "0@77.37eS"

# File paths
LOCAL_FILE = r"C:\Users\Esteban Selvaggi\Desktop\AI_Agent\docs\WordPress\Local Business Directory\local-business-directory\assets\css\frontend.css"
REMOTE_FILE = "/home/u470101590/domains/sandybrown-eagle-413619.hostingersite.com/public_html/wp-content/plugins/local-business-directory/assets/css/frontend.css"
CACHE_DIR = "/home/u470101590/domains/sandybrown-eagle-413619.hostingersite.com/public_html/wp-content/litespeed/cache"
WP_PATH = "/home/u470101590/domains/sandybrown-eagle-413619.hostingersite.com/public_html"

def main():
    # Create SSH client
    client = paramiko.SSHClient()
    client.set_missing_host_key_policy(paramiko.AutoAddPolicy())
    
    try:
        # Connect to server
        print(f"Connecting to {HOST}:{PORT}...")
        client.connect(HOST, port=PORT, username=USER, password=PASSWORD, timeout=30)
        print("Connected successfully!")
        
        # Upload file using SFTP
        print(f"\nUploading {LOCAL_FILE}...")
        sftp = client.open_sftp()
        
        # Ensure remote directory exists
        remote_dir = os.path.dirname(REMOTE_FILE)
        try:
            sftp.stat(remote_dir)
        except FileNotFoundError:
            print(f"Creating remote directory: {remote_dir}")
            sftp.mkdir(remote_dir)
        
        # Upload the file
        sftp.put(LOCAL_FILE, REMOTE_FILE)
        sftp.close()
        print("File uploaded successfully!")
        
        # Clear cache directory
        print(f"\nClearing cache in {CACHE_DIR}...")
        stdin, stdout, stderr = client.exec_command(f"rm -rf {CACHE_DIR}/*")
        exit_status = stdout.channel.recv_exit_status()
        if exit_status == 0:
            print("Cache cleared successfully!")
        else:
            error = stderr.read().decode()
            print(f"Cache clear warning: {error}")
        
        # Run wp cache flush
        print(f"\nRunning wp cache flush...")
        stdin, stdout, stderr = client.exec_command(
            f"wp cache flush --allow-root --path={WP_PATH}"
        )
        exit_status = stdout.channel.recv_exit_status()
        output = stdout.read().decode().strip()
        error = stderr.read().decode().strip()
        
        if exit_status == 0:
            print(f"WP Cache Flush: {output}")
        else:
            print(f"WP Cache Flush error: {error}")
        
        print("\n✅ All operations completed successfully!")
        
    except Exception as e:
        print(f"Error: {e}")
    finally:
        client.close()

if __name__ == "__main__":
    main()
