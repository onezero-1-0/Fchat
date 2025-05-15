# Fchat

**Fchat** is a lightweight, privacy-focused web chat application built with PHP. Designed specifically for environments like the Tor network, it operates without any JavaScript, ensuring compatibility with browsers that have JavaScript disabled, such as the Tor Browser.

## 🌐 Tor-Friendly and JavaScript-Free

Fchat is meticulously crafted to function seamlessly over the Tor network. By eliminating JavaScript dependencies, it ensures:

- **Enhanced Privacy**: Reduces potential attack vectors associated with JavaScript.
- **Broader Compatibility**: Operates smoothly on browsers that restrict or disable JavaScript.
- **Optimized for Onion Routing**: Ideal for deployment as a Tor hidden service.

## 🔐 Features

- **User Authentication**: Secure login and logout mechanisms.
- **Session Management**: Efficient handling of user sessions.
- **Real-Time Messaging**: Instant communication between users.
- **Admin Panel**: Administrative interface for managing users and messages.
- **Redis Integration**: Utilizes Redis for caching and session storage to enhance performance.


## 🛠️ Technologies Used

- **PHP**: Core server-side scripting
- **CSS**: Styling and layout
- **Hack**: Utilized for enhanced type safety and performance
- **Redis**: In-memory data store for sessions and caching

## 🚀 Getting Started

Follow these steps to set up and run Fchat on a Debian/Ubuntu server, including Redis and Tor integration.

### 1. Clone the Repository

```bash
git clone https://github.com/onezero-1-0/Fchat.git
cd Fchat
```

### 2. Install Dependencies

Install PHP, Redis, Apache (or Nginx), and required PHP extensions:

```bash
sudo apt update
sudo apt install php php-cli php-redis php-mbstring php-curl php-xml \
                 php-common php-gd php-mysql php-bcmath \
                 redis-server apache2 git unzip curl -y
```

Enable Apache PHP module (if using Apache):

```bash
sudo a2enmod php
sudo systemctl restart apache2
```

Start and enable Redis:

```bash
sudo systemctl enable redis
sudo systemctl start redis
```

Test Redis:

```bash
redis-cli ping
# Should return: PONG
```

### 3. Deploy Fchat to Web Root

```bash
sudo cp -r * /var/www/html/
sudo chown -R www-data:www-data /var/www/html/
```

### 4. Configure Redis

Edit `redis.php`:

```php
$redis = new Redis();
$redis->connect('127.0.0.1', 6379);
```
### 5. Set up Cron Job for Session Cleanup

To handle users who close the browser without logging out, you must run CLEAN.php periodically to clean inactive sessions and logout users automatically.

Open your crontab editor by running:

```bash
crontab -e
```

Add the cron line at the bottom of the file (replace /usr/bin/php and /path/to/Fchat with your actual paths):

```
* * * * * /usr/bin/php /path/to/Fchat/CLEAN.php
```

Save and exit. The system will run the CLEAN.php script every minute automatically.

### 6. (Optional) Set Up Tor Hidden Service

Install Tor:

```bash
sudo apt install tor -y
```

Edit Tor config:

```bash
sudo nano /etc/tor/torrc
```

Add:

```
HiddenServiceDir /var/lib/tor/fchat_hidden/
HiddenServicePort 80 127.0.0.1:80
```

Restart Tor:

```bash
sudo systemctl restart tor
```

Get your .onion address:

```bash
sudo cat /var/lib/tor/fchat_hidden/hostname
```

### 7. Run the Application

Open your browser (Tor Browser recommended) and go to:

- `http://localhost`
- or your `.onion` address in the Tor Browser

Fchat is now ready for secure, JS-free messaging over the web or Tor.

🤝 Contributing
Contributions are welcome! Feel free to fork this repository and open a pull request with your improvements or bug fixes.

📄 License
This project is licensed under the MIT License.

Let me know if you'd like me to include installation instructions for running it as a Tor hidden service or a `.onion` domain setup.
