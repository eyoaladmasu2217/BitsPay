# BitsPay - Next Generation Campus Payment Solution 🚀

BitsPay is a premium, secure, and effortless campus payment platform designed for modern student life. Manage your finances, pay tuition, and monitor transactions with a stunning, high-performance interface.

![BitsPay Banner](https://img.shields.io/badge/Status-Beta-brightgreen)
![Tech](https://img.shields.io/badge/PHP-8.x-blue)
![Frontend](https://img.shields.io/badge/UI-Glassmorphism-purple)

## 🌟 Key Features

- **Instant Deposits**: Securely fund your account via Chapa (Mobile Wallet, Bank Transfer).
- **One-Click Payments**: Pay semester fees and campus services instantly from your wallet.
- **Glassmorphic Dashboard**: A stunning, responsive UI with real-time balance updates.
- **Security First**: HTTPOnly cookies, SameSite restrictions, and security headers.
- **Dual Theme Support**: Beautiful dark and light modes that respect your preference.

## 🛠 Tech Stack

- **Backend**: PHP 8.1+ with PDO for secure database interactions.
- **Frontend**: Vanilla HTML5, Modern CSS (Flexbox/Grid), and ES6+ JavaScript.
- **Payment Gateway**: Integrated with [Chapa API](https://chapa.co/).
- **Design**: Premium Glassmorphism with smooth CSS3 animations and video backgrounds.

## 🚀 Getting Started

1. Clone the repository.
2. Configure your database in `backend/database/csql.php`.
3. Set your Chapa API keys in `backend/config/chapa.php`.
4. Import the database schema from `backend/database/migration/`.
5. Start your local server and navigate to `index.php`.

## 🔒 Security Practices

- Cross-Site Scripting (XSS) prevention via content sanitization.
- CSRF Protection on all sensitive endpoints.
- Secure session management and modern security headers.

---
Built with ❤️ by the BitsPay Team.
