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

## 🗂️ Project Structure

Fchat/
├── api/ # Backend API endpoints
├── panel/ # Admin dashboard
├── proccess/ # Session and authentication scripts
├── static/ # Static assets (CSS)
├── grep/ # Log analysis / utility scripts
├── CLEAN.php # Cleanup script
├── endsession.php # Session termination script
├── index.php # Application entry point
├── login.php # User login interface
├── logout.php # Logout handler
├── redis.php # Redis configuration

## 🛠️ Technologies Used

- **PHP**: Core server-side scripting
- **CSS**: Styling and layout
- **Hack**: Utilized for enhanced type safety and performance
- **Redis**: In-memory data store for sessions and caching

## 🚀 Getting Started

### 1. Clone the Repository

```bash
git clone https://github.com/onezero-1-0/Fchat.git
2. Set Up the Environment
Make sure PHP and Redis are installed.

Configure your web server to serve the Fchat application.

3. Configure Redis
Edit redis.php with your Redis server connection details.

4. Run the Application
Access index.php in your browser (Tor Browser recommended) to start using Fchat.

🤝 Contributing
Contributions are welcome! Feel free to fork this repository and open a pull request with your improvements or bug fixes.

📄 License
This project is licensed under the MIT License.

Let me know if you'd like me to include installation instructions for running it as a Tor hidden service or a `.onion` domain setup.
