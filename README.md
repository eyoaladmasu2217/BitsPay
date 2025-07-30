# BitsPay

BitsPay is a web-based financial management system designed for educational institutions and students to manage tuition payments, wallet balances, and transaction history. The system is built using PHP, MySQL, HTML, CSS, and JavaScript.

## Features

- **User Registration & Login:** Authentication for students.
- **Wallet System:** Each user has a wallet to deposit, withdraw, and pay tuition.
- **Tuition Payment:** Pay tuition fees directly from your wallet.
- **Transaction History:** View all wallet and tuition payment transactions.
- **Single Page Navigation:** Smooth navigation between dashboard sections using JavaScript (SPA-like experience).
- **Responsive UI:** Modern design with background videos and styled components.

## Project Structure

```
BitsPay/
│
├── backend/
│   ├── controller/         # Controllers for business logic
│   ├── database/           # DB connection, migrations, and setup scripts
│   ├── model/              # Models for DB interaction
│   ├── reg.php             # Registration endpoint
│   ├── login.php           # Login endpoint
│   └── ...
│
├── style.css               # Main stylesheet
├── index.php               # Landing page (Sign up & Login)
├── home.php                # User dashboard (wallet, payments, history)
├── balance.js              # JS for balance visibility toggle
├── spa-nav.js              # JS for SPA navigation
└── README.md               # Project documentation
```

## Setup Instructions

### Prerequisites
- PHP 7.x or later
- MySQL
- Web server (e.g., Apache, XAMPP)

### Installation
1. **Clone the repository:**
   ```sh
   git clone <repo-url>
   ```
2. **Set up the database:**
   - Update database credentials in `backend/database/csql.php` if needed.
   - Run all migrations:
     ```sh
     php backend/database/migration/run_all_tble.php
     ```
   - Or import the provided SQL schema.
3. **Start the web server:**
   - Place the project folder in your web server's root directory (e.g., `htdocs` for XAMPP).
   - Start Apache and MySQL.
4. **Access the app:**
   - Open your browser and go to `http://localhost/BitsPay/index.php`

## Usage
- **Sign Up:** Register a new account.
- **Log In:** Access your dashboard.
- **Deposit Funds:** Add money to your wallet.
- **Pay Tuition:** Use wallet balance to pay tuition.
- **View Transactions:** See your payment and deposit history.

## Main Files
- `index.php` — Landing page with sign up/login forms
- `home.php` — Dashboard for authenticated users
- `backend/controller/walletController.php` — Handles wallet actions (deposit, update)
- `backend/model/walletmodel.php` — Wallet database logic
- `balance.js` — Handles balance visibility toggle
- `spa-nav.js` — Handles navigation between dashboard sections

## Security Notes
- Do **not** commit sensitive files (e.g., `backend/database/csql.php`) to public repositories.
- Use environment variables or secure config for production deployments.

## License
This project is for educational purposes. Please contact the author for production/commercial use.

