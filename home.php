<?php
require_once 'backend/config/security_headers.php';
require_once 'backend/config/csrf.php';
// session handled by csrf.php or security_headers if needed

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

require_once 'backend/model/WalletModel.php';
require_once 'backend/model/TransactionModel.php';
$user_id = $_SESSION['user_id'];
$wallet = getUserWallet($user_id);
if (!$wallet) {
    createWallet($user_id, 0.00);
    $wallet = getUserWallet($user_id);
}
$recent_transactions = getRecentTransactions($user_id, 5);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BitsPay - Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="dashboard-refined.css">
    <script src="theme.js" defer></script>
    <script src="toast.js" defer></script>
    <script src="loader.js" defer></script>
    <script src="modal.js" defer></script>
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
        <div class="dashboard-header-group">
            <h1 class="dashboard-title">Welcome Back!</h1>
            <p class="dashboard-subtitle">Manage your finances and tuition with ease.</p>
        </div>

        <div class="balance-card">
            <?php if (isset($_SESSION['success'])): ?>
                <div class="status-msg status-success">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                    <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>
            <?php if (isset($_SESSION['error'])): ?>
                <div class="status-msg status-error">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                    <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <p class="balance-label">Total Balance</p>
            <h2 class="balance-amount"><?php echo number_format($wallet['balance'], 2); ?> ETB</h2>
            <div class="balance-verified">
                Verified Account • Instant Transfers
            </div>
        </div>

        <div class="actions-grid">
            <div class="action-card">
                <div style="margin-bottom: 20px;"><?xml version="1.0" ?><svg fill="none" height="48" viewBox="0 0 24 24" width="48" xmlns="http://www.w3.org/2000/svg"><path d="M12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2ZM13 7V11H17V13H13V17H11V13H7V11H11V7H13Z" fill="var(--primary-color)"/></svg></div>
                <h3>Deposit via Chapa</h3>
                <p>Transfer funds from your bank/mobile wallet.</p>
                <form action="backend/controller/ChapaController.php" method="POST" data-loader="Redirecting to secure payment...">
                    <input type="hidden" name="csrf_token" value="<?php echo getCsrfToken(); ?>">
                    <input type="number" name="deposit_amount" step="0.01" class="form-input" placeholder="Amount ETB" required>
                    <input type="hidden" name="user_email" value="<?php echo htmlspecialchars($_SESSION['user_email']); ?>">
                    <button type="submit" class="btn-primary">Deposit Now</button>
                </form>
            </div>


            <div class="action-card">
                <div style="margin-bottom: 20px;"><?xml version="1.0" ?><svg fill="none" height="48" viewBox="0 0 24 24" width="48" xmlns="http://www.w3.org/2000/svg"><path d="M17 18C15.8954 18 15 18.8954 15 20C15 21.1046 15.8954 22 17 22C18.1046 22 19 21.1046 19 20C19 18.8954 18.1046 18 17 18ZM7 18C5.89543 18 5 18.8954 5 20C5 21.1046 5.89543 22 7 22C8.10457 22 9 21.1046 9 20C9 18.8954 8.10457 18 7 18ZM7 16L4.3 10.6L1 5H21L17.7 10.6L15 16H7Z" fill="var(--secondary-color)"/></svg></div>
                <h3>Pay Tuition</h3>
                <p>Use your wallet to pay semester fees.</p>
                <form action="backend/controller/handle_payment.php" method="POST" data-loader="Processing tuition payment...">
                    <input type="hidden" name="csrf_token" value="<?php echo getCsrfToken(); ?>">
                    <input type="hidden" name="paymentType" value="TuitionFull">
                    <input type="number" name="makePayment" step="0.01" class="form-input" placeholder="Amount ETB" required>
                    <button type="submit" class="btn-primary btn-secondary">Pay From Wallet</button>
                </form>
            </div>
        <div class="activity-section">
            <h3 class="section-title">Recent Activity</h3>
            <div class="activity-card">
                <?php if ($recent_transactions->num_rows > 0): ?>
                    <ul class="activity-list">
                        <?php while ($row = $recent_transactions->fetch_assoc()): ?>
                            <li class="activity-item">
                                <div class="activity-icon"><?php echo $row['fee_type'] === 'tuition' ? '🎓' : '📥'; ?></div>
                                <div class="activity-details">
                                    <span class="activity-type"><?php echo ucfirst($row['fee_type']); ?></span>
                                    <span class="activity-date"><?php echo date('M d, H:i', strtotime($row['created_at'])); ?></span>
                                </div>
                                <div class="activity-status badge-<?php echo $row['status']; ?>"><?php echo ucfirst($row['status']); ?></div>
                                <div class="activity-value"><?php echo number_format($row['amount'], 2); ?> ETB</div>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                <?php else: ?>
                    <div class="activity-empty-state">
                        <div class="empty-icon">📊</div>
                        <p>No recent transactions to display.</p>
                        <p style="font-size: 0.8rem; margin-top: 10px;">Deposit funds to get started!</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <footer class="main-footer">
            <div>&copy; 2026 BitsPay Inc. All rights reserved.</div>
            <div class="footer-links">
                <a href="#" class="footer-link">Privacy Policy</a>
                <a href="#" class="footer-link">Terms of Service</a>
                <a href="#" class="footer-link">Help Center</a>
            </div>
        </footer>
    </div>
</body>
</html>
