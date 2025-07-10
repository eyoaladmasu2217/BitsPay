<?php
session_start();
    require_once "backend/model/TransactionModel.php";
    require_once "backend/model/walletmodel.php";
   
    if (!isset($_SESSION['user_id'])){
        die("Unauthorized access");
    }
    $user_id = $_SESSION['user_id'];
    $transactions = getUserTransaction($user_id);
    $wallet = getUserWallet($user_id);
    $tuitionPayments = getTuitionPayments($user_id);
    $walletTransactions = getWalletTransactions($user_id);
    if(!$wallet){
        createWallet($user_id, 0.00);
        $wallet = getUserWallet($user_id);
    }
    if (!isset($_SESSION['user_id'])) {
    header("Location: /BitsPay/index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BitsPay - Home</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <video autoplay loop muted playsinline class="bg-video">
        <source src="background vid.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <div class="container">
        <header class="main-navbar">
            <div class="logo">
                <span class="bits">Bits</span><span class="pay">Pay</span>
            </div>
            <nav>
                <a href="#home" class="active">Home</a>
                <a href="#courses">Courses</a>
                <a href="#payments">Payments</a>
                <a href="#transactions">Transaction History</a>
                <a href="#notifications">Notifications</a>
                <a href="/BitsPay/backend/logout.php" class="logout">Logout</a>
            </nav>
        </header>
        <main class="dashboard">
        <section id="home" class="dashboard-section">
            <h1>Account Balance</h1>
            <p class="subtitle">Your current balance across all accounts</p>
            <div class="balance-card">
                <span class="balance-label">Balance</span>
                <span class="balance-amount" id="balanceAmount">ETB <span class="stars" id ="balanceValue"><?= number_format($wallet['balance'],2)?></span></span>
                <button class="toggle-visibility" id="toggleBalanceBtn" aria-label="Show/Hide Balance">
                    <span id="eyeIcon">👁️</span>
                </button>
            </div>
            <div class="transactions">
                <h2>Recent Activity</h2>
                <ul class="transaction-list">
                    <?php if(count($walletTransactions)>0):?> 
                        <?php foreach($walletTransactions as$tx):?>
                            <li>
                                <span class="icon">
                                   <?= $tx['type']==='credit' ? '💰':'🛒'?>
                                </span>
                                <div>
                                    <div class="title"><?= ucfirst($tx['type'])?></div>
                                    <div class="desc"><?=htmlspecialchars($tx['description'])?></div>
                                </div>
                                <span class="amount<?=$tx['type']==='credit'?'credit' :'debit'?>"><?= number_format($tx['amount'],2)?></span>
                            </li>
                        <?php endforeach;?>
                    <?php else:?>
                        <li>
                            <span class="icon">ℹ️</span>
                            <div>
                                <div class="title">No Activity</div>
                                <div class="desc">Your wallet is waiting for action</div>
                            </div>
                            <span class="amount">0.00 ETB</span>
                        </li>
                        <?php endif;?>
        
                    <!-- <li>
                        <span class="icon">📦</span>
                        <div>
                            <div class="title">Tuition</div>
                            <div class="desc">Online Retailer</div>
                        </div>
                        <span class="amount">28000ETB</span>
                    </li> -->
                </ul>
            </div>
        </section>

        <section id="courses" class="dashboard-section">
            <h1>Courses & Costs</h1>
            <ul class="transaction-list">
                <li><div class="title">Computer Science</div><span class="amount">20,000 ETB</span></li>
                <li><div class="title">Information Systems</div><span class="amount">18,000 ETB</span></li>
                <li><div class="title">Electrical Engineering</div><span class="amount">22,000 ETB</span></li>
                <li><div class="title">Mechanical Engineering</div><span class="amount">21,000 ETB</span></li>
                <li><div class="title">Business Administration</div><span class="amount">17,000 ETB</span></li>
                <li><div class="title">Architecture</div><span class="amount">23,000 ETB</span></li>
            </ul>
        </section>

        <section id="payments" class="dashboard-section">
            <h1>Payments</h1>
            <div class="payments-flex">
                <div class="payment-card">
                    <h2>Deposit</h2>
                    <form method="POST" action="https://api.chapa.co/v1/hosted/pay" class="payment-form">
                        <input type="hidden" name="public_key" value="CHAPUBK_TEST-NeIrAl3Gw1751zvQf0FQ0yMnQAinVo7g" />
                        <input type="hidden" name="tx_ref" value="<?php echo 'bits-' . uniqid(); ?>" />
                        <input type="hidden" name="currency" value="ETB" />
                        <input type="hidden" name="email" value="eyoalforwork@gmail.com" />
                        <input type="hidden" name="first_name" value="John" />
                        <input type="hidden" name="last_name" value="Doe" />
                        <input type="hidden" name="title" value="BitsPay Deposit" />
                        <input type="hidden" name="description" value="Deposit to BitsPay wallet" />
                        <input type="hidden" name="logo" value="https://chapa.link/asset/images/chapa_swirl.svg" />
                        <input type="hidden" name="callback_url" value="https://yourdomain.com/chapa_callback.php" />
                        <input type="hidden" name="return_url" value="https://yourdomain.com/chapa_return.php" />
                        <input type="hidden" name="meta[title]" value="Deposit" />
                        <input type="number" name="amount" min="0" step="0.01" placeholder="Amount to deposit" class="payment-input" required />
                        <input type="hidden" name="callback_url" value="http://localhost/BitsPay/backend/chapa_callback.php"/>
                        <input type="hidden" name="return_url" value="http://localhost/BitsPay/home.php?wallet=success"/>
                        <input type="hidden" name="tx_ref" value="<?php echo 'bits-' .$user_id .'_' . uniqid();?>"/>
                        <button type="submit" class="payment-btn">Deposit</button>
                    </form>
                </div>
                <div class="payment-card">
                    <h2>Make Payment</h2>
                    <form class="payment-form" method="POST" action="backend/controller/handle_payment.php">
                        <select name="paymentType" class="payment-select" required>
                            <option value="TuitionFull">Tuition (Full)</option>
                            <option value="Tuition60">Tuition (60%)</option>
                            <option value="Tuition40">Tuition (40%)</option>
                            <option value="Cafeteria">Cafeteria</option>
                            <option value="Supermarket">Supermarket</option>
                            <option value="JuiceService">Juice Service</option>
                        </select>
                        <input type="number" name="makePayment" min="0" step="0.01" placeholder="Amount to pay" class="payment-input" required>
                        <button type="submit" class="payment-btn">Pay</button>
                    </form>
                </div>
            </div>
        </section>
    
        <section id="transactions" class="dashboard-section">
            <h1>Transaction History</h1>
            <?php if ($transactions && $transactions->num_rows > 0): ?>
            <ul class="transaction-list">
                <?php while ($txn = $transactions->fetch_assoc()): ?>
                    <?php if(isset($txn['acedemic_year'])):?>
                        <li>
                            <span class="icon">💳</span>
                            <div class="title"><?=htmlspecialchars($txn['fee_type'])?></div>
                            <span class="amount"><?= number_format($txn['amount'],2)?>ETB</span>
                            <div class="meta">
                                
                                <small>Year: <?= isset($txn['acedemic_year']) ? htmlspecialchars($txn['acedemic_year']) : 'N/A' ?></small>

                                <Small>Ref:<?=htmlspecialchars($txn['reference'])?></Small><br>
                                <small>Status:
                                    <Span class="status <?= strtolower($txn['status'])?>">
                                        <?=htmlspecialchars($txn['status'])?>
                                    </Span>
                                </small>
                            </div>
                        </li>
                        <?php endif;?>
                    <?php endwhile; ?>
            </ul>
            <?php else: ?>
              <p>No transactions found.</p>
            <?php endif; ?>

                <!-- <li><span class="icon">🛒</span><div class="title">Books</div><span class="amount">1200ETB</span></li>
                <li><span class="icon">📦</span><div class="title">Tuition</div><span class="amount">28000ETB</span></li>
                <li><span class="icon">☕</span><div class="title">Coffee</div><span class="amount">1200ETB</span></li>
                <li><span class="icon">⬇️</span><div class="title">Dorm</div><span class="amount">1200ETB</span></li>
                <li><span class="icon">🍽️</span><div class="title">Cafeteria</div><span class="amount">1200ETB</span></li>
            </ul> -->
        </section>


        <section id="notifications" class="dashboard-section">
            <h1>Notifications</h1>
            <ul class="transaction-list">
                <li><div class="title">Upcoming Payment: Tuition</div><div class="desc">Due: August 10</div></li>
                <li><div class="title">Upcoming Payment: Dorm</div><div class="desc">Due: August 15</div></li>
                <li><div class="title">Penalty Fee: Late Library Book</div><div class="desc">Fee: 200 ETB</div></li>
            </ul>
        </section>
        </main>
    </div>
    <script src="balance.js"></script>
    <script src="spa-nav.js"></script>
    <script>
    // Deposit button toggle
    document.addEventListener('DOMContentLoaded', function() {
        const depositBtn = document.getElementById('depositBtn');
        const depositInput = document.getElementById('depositInput');
        if (depositBtn && depositInput) {
            depositBtn.addEventListener('click', function() {
                if (depositInput.style.display === 'none' || depositInput.style.display === '') {
                    depositInput.style.display = 'block';
                    depositInput.focus();
                } else {
                    depositInput.style.display = 'none';
                }
            });
        }
    });
    // SPA-style navigation for dashboard sections
    document.addEventListener('DOMContentLoaded', function() {
        const navLinks = document.querySelectorAll('.main-navbar nav a');
        const sections = document.querySelectorAll('.dashboard-section');
        navLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                // Remove active from all links
                navLinks.forEach(l => l.classList.remove('active'));
                // Hide all sections
                sections.forEach(sec => sec.style.display = 'none');
                // Add active to clicked link
                this.classList.add('active');
                // Show the corresponding section
                const target = this.getAttribute('href').replace('#','');
                const section = document.getElementById(target);
                if(section) section.style.display = 'block';
            });
        });
        // Show only home by default
        sections.forEach(sec => sec.style.display = 'none');
        document.getElementById('home').style.display = 'block';
    });
    </script>
</body>
</html>