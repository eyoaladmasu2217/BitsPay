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
    <style>
        .dashboard-container {
            max-width: 1000px;
            margin: 100px auto;
            padding: 20px;
            color: white;
            z-index: 10;
            position: relative;
        }
        .balance-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 30px;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            margin-bottom: 20px;
            text-align: center;
        }
        .balance-amount {
            font-size: 3rem;
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
            margin: 10px 0;
            background: linear-gradient(135deg, #fff, #888);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
        .action-card {
            background: rgba(255, 255, 255, 0.05);
            padding: 20px;
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }
        .action-card:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.1);
        }
        .form-input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            background: rgba(0, 0, 0, 0.2);
            color: white;
        }
        .btn-primary {
            background: #4CAF50;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
            font-weight: 600;
            transition: background 0.3s;
        }
        .btn-primary:hover {
            background: #45a049;
        }
        .status-msg {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
        }
        .status-success { background: rgba(76, 175, 80, 0.2); color: #81c784; border: 1px solid #4CAF50; }
        .status-error { background: rgba(211, 47, 47, 0.2); color: #e57373; border: 1px solid #d32f2f; }
        .bg-video { position: fixed; right: 0; bottom: 0; min-width: 100%; min-height: 100%; z-index: -2; object-fit: cover; }
        .video-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); z-index: -1; }
    </style>
</head>
<body>
    <div class="video-overlay"></div>
    <video autoplay loop muted playsinline class="bg-video">
        <source src="background vid.mp4" type="video/mp4">
    </video>

    <div class="dashboard-container">
        <header>
            <div class="logo">
                <span style="color:white; font-size: 1.5rem; font-weight: 800;">Bits<span style="color: #4CAF50;">Pay</span></span>
            </div>
            <a href="backend/logout.php" style="color: white; float: right;">Log out</a>
        </header>

        <div class="balance-card">
            <?php if (isset($_SESSION['success'])): ?>
                <div class="status-msg status-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
            <?php endif; ?>
            <?php if (isset($_SESSION['error'])): ?>
                <div class="status-msg status-error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
            <?php endif; ?>

            <p>Your Balance</p>
            <h2 class="balance-amount"><?php echo number_format($wallet['balance'], 2); ?> ETB</h2>
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
                    <button type="submit" class="btn-primary" style="background: #2196F3;">Pay From Wallet</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
