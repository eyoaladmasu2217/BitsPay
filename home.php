<?php
require_once 'backend/config/security_headers.php';
session_set_cookie_params([
    'secure' => true,
    'httponly' => true,
    'samesite' => 'Strict'
]);
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

require_once 'backend/model/WalletModel.php';
$user_id = $_SESSION['user_id'];
$wallet = getUserWallet($user_id);
if (!$wallet) {
    createWallet($user_id, 0.00);
    $wallet = getUserWallet($user_id);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BitsPay - Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="dashboard-refined.css">
</head>
<body>
    <div class="video-overlay"></div>
    <video autoplay loop muted playsinline class="bg-video">
        <source src="background vid.mp4" type="video/mp4">
    </video>

    <div class="dashboard-container">
        <header class="main-header">
            <div class="logo">
                <span class="bits">Bits</span><span class="pay">Pay</span>
            </div>
            <nav class="nav-links">
                <a href="home.php" class="nav-link active">Dashboard</a>
                <a href="backend/logout.php" class="nav-link logout-btn">Log out</a>
            </nav>
        </header>
        <div style="margin-bottom: 30px; animation: fadeInUp 0.8s ease-out both;">
            <h1 style="font-family: 'Outfit', sans-serif; font-size: 2.2rem; margin-bottom: 5px;">Welcome Back!</h1>
            <p style="color: var(--text-muted); font-size: 1.1rem;">Manage your finances and tuition with ease.</p>
        </div>

        <div class="balance-card">
            <?php if (isset($_SESSION['success'])): ?>
                <div class="status-msg status-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
            <?php endif; ?>
            <?php if (isset($_SESSION['error'])): ?>
                <div class="status-msg status-error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
            <?php endif; ?>

            <p class="balance-label">Total Balance</p>
            <h2 class="balance-amount"><?php echo number_format($wallet['balance'], 2); ?> ETB</h2>
            <div style="font-size: 0.85rem; color: rgba(255,255,255,0.4); margin-top: 10px;">
                Verified Account • Instant Transfers
            </div>
        </div>

        <div class="actions-grid">
            <div class="action-card">
                <h3>Deposit via Chapa</h3>
                <p>Transfer funds from your bank/mobile wallet.</p>
                <form action="backend/controller/ChapaController.php" method="POST">
                    <input type="number" name="deposit_amount" step="0.01" class="form-input" placeholder="Amount ETB" required>
                    <input type="hidden" name="user_email" value="<?php echo htmlspecialchars($_SESSION['user_email']); ?>">
                    <button type="submit" class="btn-primary">Deposit Now</button>
                </form>
            </div>

            <div class="action-card">
                <h3>Pay Tuition</h3>
                <p>Use your wallet to pay semester fees.</p>
                <form action="backend/controller/handle_payment.php" method="POST">
                    <input type="hidden" name="paymentType" value="TuitionFull">
                    <input type="number" name="makePayment" step="0.01" class="form-input" placeholder="Amount ETB" required>
                    <button type="submit" class="btn-primary btn-secondary">Pay From Wallet</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
