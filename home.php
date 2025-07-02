<?php
session_start();
    require_once "backend/model/TransactionModel.php";
    if (!isset($_SESSION['user_id'])){
        die("Unauthorized access");
        
    }
    $user_id = $_SESSION['user_id'];
    $transactions = getUserTransaction($user_id);
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
            </nav>
        </header>
        <main class="dashboard">
        <section id="home" class="dashboard-section">
            <h1>Account Balance</h1>
            <p class="subtitle">Your current balance across all accounts</p>
            <div class="balance-card">
                <span class="balance-label">Balance</span>
                <span class="balance-amount" id="balanceAmount">ETB <span class="stars">****</span></span>
                <button class="toggle-visibility" id="toggleBalanceBtn" aria-label="Show/Hide Balance">
                    <span id="eyeIcon">👁️</span>
                </button>
            </div>
            <div class="transactions">
                <h2>Recent Activity</h2>
                <ul class="transaction-list">
                    <li>
                        <span class="icon">🛒</span>
                        <div>
                            <div class="title">Books</div>
                            <div class="desc">Campus Store</div>
                        </div>
                        <span class="amount">1200ETB</span>
                    </li>
                    <li>
                        <span class="icon">📦</span>
                        <div>
                            <div class="title">Tuition</div>
                            <div class="desc">Online Retailer</div>
                        </div>
                        <span class="amount">28000ETB</span>
                    </li>
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
            <form class="send-form">
                <div class="form-group">
                    <label for="deposit">Deposit Money</label>
                    <input type="number" id="deposit" name="deposit" min="0" step="0.01" placeholder="Amount to deposit">
                </div>
                <div class="form-group">
                    <label for="makePayment">Make Payment</label>
                    <input type="number" id="makePayment" name="makePayment" min="0" step="0.01" placeholder="Amount to pay">
                </div>
                <button type="submit" class="continue-btn">Submit</button>
            </form>
        </section>
    
        <section id="transactions" class="dashboard-section">
            <h1>Transaction History</h1>
            <?php if ($transactions && $transactions->num_rows > 0): ?>
            <ul class="transaction-list">
                <?php while ($txn = $transactions->fetch_assoc()): ?>
                    <li>
                        <span class="icon">💳</span>
                        <div class="title"><?=htmlspecialchars($txn['fee_type'])?></div>
                        <span class="amount"><?= number_format($txn['amount'],2)?>ETB</span>
                        <div class="meta">
                            <Small>Year: <?=htmlspecialchars($txn['acedmic_year'])?></Small>
                            <Small>Ref:<?=htmlspecialchars($txn['reference'])?></Small><br>
                            <small>Status:
                                <Span class="status <?= strtolower($txn['status'])?>">
                                    <?=htmlspecialchars($txn['status'])?>
                                </Span>
                            </small>
                        </div>
                    </li>
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
