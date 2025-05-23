<?php
session_start();

// Initialize session variables if they don't exist
if (!isset($_SESSION['wallet_balance'])) {
    $_SESSION['wallet_balance'] = 5000.00; // Initial sample balance
}
if (!isset($_SESSION['transactions'])) {
    $_SESSION['transactions'] = [
        ['type' => 'credit', 'description' => 'Initial Balance', 'amount' => 5000.00, 'date' => date('Y-m-d')],
    ];
}
if (!isset($_SESSION['profile'])) {
    $_SESSION['profile'] = [
        'name' => 'Salman',
        'mobile' => '1234567890',
        'email' => 'sample@gmail.com'
    ];
}

$current_action = $_GET['action'] ?? 'dashboard'; // Default action is dashboard
$message = ''; // For success/error messages

// --- --- --- FORM PROCESSING LOGIC --- --- ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['form_action'])) {
        switch ($_POST['form_action']) {
            case 'process_bbps':
                $billerId = htmlspecialchars($_POST['billerId'] ?? '');
                $amount = floatval($_POST['bbpsAmount'] ?? 0);
                $billerType = htmlspecialchars($_POST['billerType'] ?? 'Bill');

                if ($billerId && $amount > 0) {
                    if ($_SESSION['wallet_balance'] >= $amount) {
                        $_SESSION['wallet_balance'] -= $amount;
                        array_unshift($_SESSION['transactions'], [
                            'type' => 'debit',
                            'description' => "$billerType Payment: $billerId",
                            'amount' => $amount,
                            'date' => date('Y-m-d')
                        ]);
                        $message = "Payment of ₹" . number_format($amount, 2) . " for $billerId successful!";
                        // $current_action = 'dashboard'; // Optionally redirect after action
                    } else {
                        $message = "Insufficient balance for BBPS payment.";
                    }
                } else {
                    $message = "Invalid BBPS payment details.";
                }
                break;

            case 'process_add_fund':
                $amount = floatval($_POST['addFundAmount'] ?? 0);
                $gateway = htmlspecialchars($_POST['selected_gateway'] ?? 'Unknown Gateway');
                $paymentMethod = htmlspecialchars($_POST['selected_payment_method'] ?? 'UPI');

                if ($amount > 0) {
                    $_SESSION['wallet_balance'] += $amount;
                    array_unshift($_SESSION['transactions'], [
                        'type' => 'credit',
                        'description' => "Added via $gateway ($paymentMethod)",
                        'amount' => $amount,
                        'date' => date('Y-m-d')
                    ]);
                    $message = "₹" . number_format($amount, 2) . " added to wallet successfully via $gateway!";
                } else {
                    $message = "Invalid amount for adding funds.";
                }
                break;

            case 'process_money_transfer':
                $beneficiaryName = htmlspecialchars($_POST['beneficiaryName'] ?? '');
                $amount = floatval($_POST['transferAmount'] ?? 0);

                if ($beneficiaryName && $amount > 0) {
                    if ($_SESSION['wallet_balance'] >= $amount) {
                        $_SESSION['wallet_balance'] -= $amount;
                        array_unshift($_SESSION['transactions'], [
                            'type' => 'debit',
                            'description' => "Transferred to $beneficiaryName",
                            'amount' => $amount,
                            'date' => date('Y-m-d')
                        ]);
                        $message = "Transfer of ₹" . number_format($amount, 2) . " to $beneficiaryName successful!";
                    } else {
                        $message = "Insufficient balance for money transfer.";
                    }
                } else {
                    $message = "Invalid money transfer details.";
                }
                break;

            case 'process_cc_bill_payment':
                $ccBank = htmlspecialchars($_POST['ccBank'] ?? 'Unknown Bank');
                $ccNumberLast4 = htmlspecialchars($_POST['ccNumber'] ?? 'XXXX');
                $amount = floatval($_POST['ccBillAmount'] ?? 0);

                if ($amount > 0) {
                     if ($_SESSION['wallet_balance'] >= $amount) {
                        $_SESSION['wallet_balance'] -= $amount;
                        array_unshift($_SESSION['transactions'], [
                            'type' => 'debit',
                            'description' => "$ccBank CC Bill (..$ccNumberLast4)",
                            'amount' => $amount,
                            'date' => date('Y-m-d')
                        ]);
                        $message = "Bill payment of ₹" . number_format($amount, 2) . " for $ccBank card successful!";
                    } else {
                        $message = "Insufficient balance for CC bill payment.";
                    }
                } else {
                    $message = "Invalid CC bill payment amount.";
                }
                break;

            case 'process_apply_cc':
                $applicantName = htmlspecialchars($_POST['applicantName'] ?? '');
                $cardAppliedFor = htmlspecialchars($_POST['card_applied_for'] ?? 'Credit Card');
                if ($applicantName) {
                    $message = "Application for $cardAppliedFor submitted for $applicantName! Our team will contact you.";
                } else {
                    $message = "Please enter applicant name.";
                }
                break;
        }
    }
}

// Function to display a screen
function display_screen($screen_id, $current_action) {
    return $screen_id === $current_action ? 'active' : '';
}

// --- --- --- HTML STRUCTURE --- --- ---
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Quick-Quids App Sample</title>
    <link rel="icon" type="image/png" href="assets/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #e9eff3; margin: 0; padding: 0;
            display: flex; justify-content: center; align-items: flex-start;
            min-height: 100vh; padding-top: 20px; padding-bottom: 20px;
        }
        .mobile-screen {
            width: 375px; max-width: 95%; min-height: 700px;
            background-color: #ffffff; border-radius: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            overflow: hidden; display: flex; flex-direction: column; position: relative;
        }
        .app-header {
            background-color: #007bff; color: white; padding: 15px 20px;
            display: flex; align-items: center; box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            position: sticky; top: 0; z-index: 10;
        }
        .app-header img { height: 30px; margin-right: 12px; }
        .app-header h1 { font-size: 1.4rem; margin: 0; font-weight: 600; flex-grow: 1; text-align: center;}
        .app-header .back-button {
            color: white; font-size: 1.2rem; cursor: pointer;
            position: absolute; left: 20px;
        }
        .screen {
            padding: 20px; flex-grow: 1; overflow-y: auto; display: none; flex-direction: column;
        }
        .screen.active { display: flex; }

        /* Common form styles */
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: 500; color: #495057; }
        .form-group input[type="text"], .form-group input[type="number"],
        .form-group input[type="tel"], .form-group input[type="email"], .form-group select {
            width: 100%; padding: 10px; border: 1px solid #ced4da;
            border-radius: 5px; font-size: 1rem; box-sizing: border-box;
        }
        .app-button {
            background-color: #007bff; color: white; padding: 12px 15px;
            border: none; border-radius: 5px; font-size: 1rem; cursor: pointer;
            width: 100%; text-align: center; margin-top: 10px; transition: background-color 0.2s ease;
        }
        .app-button:hover { background-color: #0056b3; }
        .app-button.secondary { background-color: #6c757d; }
        .app-button.secondary:hover { background-color: #545b62; }

        /* Dashboard */
        #dashboardScreen .wallet-balance { text-align: center; margin-bottom: 25px; padding: 15px; background-color: #f0f8ff; border-radius: 8px;}
        #dashboardScreen .wallet-balance h3 { margin-top: 0; margin-bottom: 5px; color: #007bff; font-size: 1rem;}
        #dashboardScreen .wallet-balance .amount { font-size: 2rem; font-weight: bold; color: #2c3e50;}
        #dashboardScreen .features-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; }
        #dashboardScreen .feature-button {
            background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 10px;
            padding: 15px; text-align: center; text-decoration: none; color: #343a40;
            display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 120px;
            transition: background-color 0.2s ease, transform 0.1s ease;
        }
        #dashboardScreen .feature-button:hover { background-color: #e9ecef; }
        #dashboardScreen .feature-button:active { transform: scale(0.98); }
        #dashboardScreen .feature-button i { font-size: 2.2rem; margin-bottom: 10px; }
        #dashboardScreen .feature-button span { font-size: 0.85rem; font-weight: 500; line-height: 1.3; }
        #dashboardScreen .fa-receipt { color: #fd7e14; } #dashboardScreen .fa-wallet { color: #20c997; }
        #dashboardScreen .fa-paper-plane { color: #6f42c1; } #dashboardScreen .fa-credit-card { color: #dc3545; }
        #dashboardScreen .fa-address-card { color: #17a2b8; } #dashboardScreen .fa-history { color: #ffc107; }

        /* BBPS Screen */
        #bbpsScreen .biller-options .app-button { margin-bottom: 10px; background-color: #f8f9fa; color: #333; border: 1px solid #ddd;}
        #bbpsScreen .biller-options .app-button:hover { background-color: #e9ecef; }
        #bbpsPaymentForm h3 { text-align: center; margin-bottom: 15px; color: #007bff;}

        /* Add Fund Screen - Gateway Selection & Payment Form */
        .gateway-selection .app-button { margin-bottom: 10px;}
        .payment-gateway-form-container {
            border: 1px solid #ddd; border-radius: 8px; padding: 20px; margin-top: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        .payment-gateway-form-container .pg-header {
            display: flex; align-items: center; margin-bottom: 20px;
            border-bottom: 1px solid #eee; padding-bottom: 10px;
        }
        .payment-gateway-form-container .pg-header img { height: 25px; margin-right: 10px; } /* PG Logo */
        .payment-gateway-form-container .pg-header span { font-weight: bold; color: #555; }
        .payment-options-tabs { display: flex; margin-bottom: 15px; border-bottom: 1px solid #eee;}
        .payment-options-tabs button {
            flex: 1; padding: 10px; background-color: transparent; border: none;
            border-bottom: 3px solid transparent; font-weight: 500; color: #6c757d; cursor: pointer;
        }
        .payment-options-tabs button.active { border-bottom-color: #007bff; color: #007bff; }
        .payment-method-details { margin-top: 15px; }

        /* Transactions Screen */
        #transactionsScreen ul { list-style: none; padding: 0; }
        #transactionsScreen li { display: flex; justify-content: space-between; align-items: center; padding: 12px 0; border-bottom: 1px solid #eee; }
        #transactionsScreen li:last-child { border-bottom: none; }
        #transactionsScreen .transaction-icon { margin-right: 12px; font-size: 1.2rem; }
        #transactionsScreen .transaction-details { flex-grow: 1; }
        #transactionsScreen .transaction-description { font-weight: 500; display: block; }
        #transactionsScreen .transaction-date { font-size: 0.8rem; color: #777; }
        #transactionsScreen .transaction-amount { font-weight: bold; }
        #transactionsScreen .transaction-amount.credit { color: #28a745; }
        #transactionsScreen .transaction-amount.debit { color: #dc3545; }
        
        /* Profile Screen */
        #profileScreen .profile-info p { font-size: 1.1rem; margin-bottom: 8px; }
        #profileScreen .profile-info strong { color: #34495e; margin-right: 5px; }

        /* Settings Screen */
        #settingsScreen .settings-list a {
            display: block; padding: 15px; background-color: #f8f9fa;
            border: 1px solid #dee2e6; border-radius: 8px; margin-bottom: 10px;
            text-decoration: none; color: #343a40; font-weight: 500;
            transition: background-color 0.2s;
        }
        #settingsScreen .settings-list a:hover { background-color: #e9ecef; }
        #settingsScreen .settings-list i { margin-right: 10px; color: #007bff; }

        /* Apply CC Screen */
        #applyCCScreen .card-listing .card-offer {
            background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 8px;
            padding: 15px; margin-bottom: 15px;
        }
        #applyCCScreen .card-listing .card-offer img { max-width: 80px; margin-bottom: 10px; display: block;}
        #applyCCScreen .card-listing .card-offer h4 { margin-top:0; margin-bottom: 8px; color: #007bff; }
        #applyCCScreen .card-listing .card-offer p { font-size: 0.9rem; margin-bottom: 10px; }

        .app-toast {
            position: fixed; bottom: 70px; left: 50%; transform: translateX(-50%);
            background-color: #333; color: white; padding: 10px 20px;
            border-radius: 20px; font-size: 0.9rem; opacity: 0; visibility: hidden;
            transition: opacity 0.3s, visibility 0.3s; z-index: 1000;
        }
        .app-toast.show { opacity: 1; visibility: visible; }

        /* Footer Nav */
        .app-footer-nav {
            display: flex; justify-content: space-around; align-items: center;
            padding: 10px 0; background-color: #f8f9fa; border-top: 1px solid #e0e0e0;
            box-shadow: 0 -2px 5px rgba(0,0,0,0.05); position: sticky; bottom: 0; z-index: 10;
        }
        .nav-item { text-decoration:none; display: flex; flex-direction: column; align-items: center; color: #6c757d; font-size: 0.75rem; flex: 1; text-align: center;}
        .nav-item i { font-size: 1.5rem; margin-bottom: 3px; }
        .nav-item.active { color: #007bff; }
    </style>
</head>
<body>
    <div class="mobile-screen">
        <header class="app-header">
            <?php if ($current_action !== 'dashboard'): ?>
                <a href="?action=dashboard" class="back-button"><i class="fas fa-arrow-left"></i></a>
            <?php endif; ?>
            <img src="assets/logo.png" alt="Quick-Quids Logo">
            <h1>
                <?php
                // Dynamically set header title based on action
                switch ($current_action) {
                    case 'bbps': echo 'BBPS Payments'; break;
                    case 'add_fund': echo 'Add Funds'; break;
                    case 'add_fund_pg': echo 'Payment Gateway'; break;
                    case 'money_transfer': echo 'Money Transfer'; break;
                    case 'cc_bill_payment': echo 'CC Bill Payment'; break;
                    case 'apply_cc': echo 'Apply Credit Card'; break;
                    case 'apply_cc_form': echo 'Application Form'; break;
                    case 'transactions': echo 'Transactions'; break;
                    case 'profile': echo 'My Profile'; break;
                    case 'settings': echo 'Settings'; break;
                    default: echo 'Quick-Quids'; // Dashboard
                }
                ?>
            </h1>
        </header>

        <?php if ($message): ?>
            <div class="app-toast show" id="appToastImmediate"><?php echo $message; ?></div>
            <script>
                setTimeout(() => {
                    const toast = document.getElementById('appToastImmediate');
                    if(toast) toast.classList.remove('show');
                }, 3000);
            </script>
        <?php endif; ?>

        <!-- Dashboard Screen -->
        <main id="dashboardScreen" class="screen <?php echo display_screen('dashboard', $current_action); ?>">
            <div class="wallet-balance">
                <h3>Available Balance</h3>
                <div class="amount">₹ <?php echo number_format($_SESSION['wallet_balance'], 2); ?></div>
            </div>
            <div class="features-grid">
                <a href="?action=bbps" class="feature-button"><i class="fas fa-receipt"></i><span>BBPS</span></a>
                <a href="?action=add_fund" class="feature-button"><i class="fas fa-wallet"></i><span>Add Funds (CC)</span></a>
                <a href="?action=money_transfer" class="feature-button"><i class="fas fa-paper-plane"></i><span>Money Transfer</span></a>
                <a href="?action=cc_bill_payment" class="feature-button"><i class="fas fa-credit-card"></i><span>CC Bill Payment</span></a>
                <a href="?action=apply_cc" class="feature-button"><i class="fas fa-address-card"></i><span>Apply Credit Card</span></a>
                <a href="?action=transactions" class="feature-button"><i class="fas fa-history"></i><span>Transactions</span></a>
            </div>
        </main>

        <!-- BBPS Screen - Biller Selection -->
        <main id="bbpsScreen" class="screen <?php echo display_screen('bbps', $current_action); ?>">
            <h2>BBPS Payments</h2>
            <p>Select a biller to proceed:</p>
            <div class="biller-options">
                <a href="?action=bbps_form&biller=Electricity Bill" class="app-button">Electricity Bill</a>
                <a href="?action=bbps_form&biller=Mobile Recharge" class="app-button">Mobile Recharge</a>
                <a href="?action=bbps_form&biller=DTH Recharge" class="app-button">DTH Recharge</a>
                <a href="?action=bbps_form&biller=Gas Bill" class="app-button">Gas Bill</a>
            </div>
        </main>
        
        <!-- BBPS Screen - Payment Form -->
        <main id="bbpsFormScreen" class="screen <?php echo display_screen('bbps_form', $current_action); ?>">
            <?php $selected_biller = htmlspecialchars($_GET['biller'] ?? 'Bill'); ?>
            <form method="POST" action="?action=bbps_form&biller=<?php echo urlencode($selected_biller); ?>">
                <input type="hidden" name="form_action" value="process_bbps">
                <input type="hidden" name="billerType" value="<?php echo $selected_biller; ?>">
                <h3>Pay <?php echo $selected_biller; ?></h3>
                <div class="form-group">
                    <label for="billerId">Biller ID / Mobile No.</label>
                    <input type="text" id="billerId" name="billerId" placeholder="Enter ID or Mobile Number" required>
                </div>
                <div class="form-group">
                    <label for="bbpsAmount">Amount (₹)</label>
                    <input type="number" id="bbpsAmount" name="bbpsAmount" placeholder="Enter Amount" required step="0.01">
                </div>
                <button type="submit" class="app-button">Pay Now</button>
            </form>
        </main>

        <!-- Add Fund Screen - Gateway Selection -->
        <main id="addFundScreen" class="screen <?php echo display_screen('add_fund', $current_action); ?>">
            <h2>Add Funds to Wallet</h2>
            <p>Choose your preferred payment gateway:</p>
            <div class="gateway-selection">
                <a href="?action=add_fund_pg&gateway=Razorpay" class="app-button">Razorpay</a>
                <a href="?action=add_fund_pg&gateway=Cashfree" class="app-button secondary">Cashfree</a>
            </div>
        </main>

        <!-- Add Fund Screen - Payment Gateway Form -->
        <main id="addFundPGScreen" class="screen <?php echo display_screen('add_fund_pg', $current_action); ?>">
            <?php $selected_gateway = htmlspecialchars($_GET['gateway'] ?? 'Payment Gateway'); ?>
            <div class="payment-gateway-form-container">
                <div class="pg-header">
                    <!-- You can add actual Razorpay/Cashfree tiny logos here if you have them in assets -->
                    <!-- <img src="assets/<?php echo strtolower($selected_gateway); ?>_logo.png" alt="<?php echo $selected_gateway; ?> Logo"> -->
                    <span>Pay securely with <?php echo $selected_gateway; ?></span>
                </div>
                <form method="POST" action="?action=add_fund_pg&gateway=<?php echo urlencode($selected_gateway); ?>" id="addFundPaymentForm">
                    <input type="hidden" name="form_action" value="process_add_fund">
                    <input type="hidden" name="selected_gateway" value="<?php echo $selected_gateway; ?>">
                    <input type="hidden" name="selected_payment_method" id="selectedPaymentMethodInput" value="upi">

                    <div class="form-group">
                        <label for="addFundAmount">Amount to Add (₹)</label>
                        <input type="number" id="addFundAmount" name="addFundAmount" placeholder="Enter Amount" value="100" required step="0.01">
                    </div>

                    <div class="payment-options-tabs">
                        <button type="button" id="upiTabBtn" class="active" onclick="togglePaymentMethod('upi')">UPI</button>
                        <button type="button" id="cardTabBtn" onclick="togglePaymentMethod('card')">Card</button>
                        <button type="button" id="netbankingTabBtn" onclick="togglePaymentMethod('netbanking')">NetBanking</button>
                    </div>

                    <div id="upiDetailsTab" class="payment-method-details">
                        <div class="form-group">
                            <label for="vpa">Enter VPA (UPI ID)</label>
                            <input type="text" id="vpa" name="vpa" placeholder="yourname@upi">
                        </div>
                    </div>
                    <div id="cardDetailsTab" class="payment-method-details" style="display:none;">
                        <div class="form-group">
                            <label for="cardNumber">Card Number</label>
                            <input type="tel" id="cardNumber" name="cardNumber" placeholder="0000 0000 0000 0000" maxlength="19">
                        </div>
                        <div style="display: flex; gap: 10px;">
                            <div class="form-group" style="flex:1;">
                                <label for="expiryDate">Expiry (MM/YY)</label>
                                <input type="text" id="expiryDate" name="expiryDate" placeholder="MM/YY" maxlength="5">
                            </div>
                            <div class="form-group" style="flex:1;">
                                <label for="cvv">CVV</label>
                                <input type="number" id="cvv" name="cvv" placeholder="123" maxlength="3">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="cardHolderName">Cardholder Name</label>
                            <input type="text" id="cardHolderName" name="cardHolderName" placeholder="Name on Card">
                        </div>
                    </div>
                     <div id="netbankingDetailsTab" class="payment-method-details" style="display:none;">
                        <div class="form-group">
                            <label for="bankSelect">Select Bank</label>
                            <select id="bankSelect" name="bankSelect">
                                <option>Select Your Bank</option>
                                <option>SBI</option>
                                <option>HDFC Bank</option>
                                <option>ICICI Bank</option>
                                <option>Axis Bank</option>
                                <option>Kotak Mahindra Bank</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="app-button">Pay ₹<span id="payButtonAmount">100.00</span></button>
                </form>
            </div>
        </main>

        <!-- Money Transfer Screen -->
        <main id="moneyTransferScreen" class="screen <?php echo display_screen('money_transfer', $current_action); ?>">
            <h2>Money Transfer</h2>
            <form method="POST" action="?action=money_transfer">
                <input type="hidden" name="form_action" value="process_money_transfer">
                <div class="form-group">
                    <label for="beneficiaryName">Beneficiary Name</label>
                    <input type="text" id="beneficiaryName" name="beneficiaryName" placeholder="Enter Name" required>
                </div>
                <div class="form-group">
                    <label for="beneficiaryAccount">Account Number</label>
                    <input type="number" id="beneficiaryAccount" name="beneficiaryAccount" placeholder="Enter Account Number" required>
                </div>
                <div class="form-group">
                    <label for="ifscCode">IFSC Code</label>
                    <input type="text" id="ifscCode" name="ifscCode" placeholder="Enter IFSC Code" required>
                </div>
                <div class="form-group">
                    <label for="transferAmount">Amount (₹)</label>
                    <input type="number" id="transferAmount" name="transferAmount" placeholder="Enter Amount" required step="0.01">
                </div>
                <button type="submit" class="app-button">Transfer Funds</button>
            </form>
        </main>

        <!-- Credit Card Bill Payment Screen -->
        <main id="ccBillPaymentScreen" class="screen <?php echo display_screen('cc_bill_payment', $current_action); ?>">
            <h2>Credit Card Bill Payment</h2>
            <form method="POST" action="?action=cc_bill_payment">
                <input type="hidden" name="form_action" value="process_cc_bill_payment">
                <div class="form-group">
                    <label for="ccBank">Select Bank</label>
                    <select id="ccBank" name="ccBank">
                        <option value="Axis Bank">Axis Bank</option>
                        <option value="SBI Card">SBI Card</option>
                        <option value="ICICI Bank">ICICI Bank</option>
                        <option value="HDFC Bank">HDFC Bank</option>
                        <option value="Other Bank">Other Bank</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="ccNumber">Credit Card Number (Last 4 Digits)</label>
                    <input type="number" id="ccNumber" name="ccNumber" placeholder="XXXX" required maxlength="4">
                </div>
                 <div class="form-group">
                    <label for="ccBillAmount">Amount (₹)</label>
                    <input type="number" id="ccBillAmount" name="ccBillAmount" placeholder="Enter Bill Amount" required step="0.01">
                </div>
                <button type="submit" class="app-button">Pay Bill</button>
            </form>
        </main>

        <!-- Apply Credit Card Screen - Listing -->
        <main id="applyCCScreen" class="screen <?php echo display_screen('apply_cc', $current_action); ?>">
            <h2>Apply for a New Credit Card</h2>
            <p>Explore offers from our partner banks:</p>
            <div class="card-listing">
                <div class="card-offer">
                    <!-- <img src="assets/axis_card_sample.png" alt="Axis Bank Card"> You can add sample card images -->
                    <h4>Axis Bank Ace Credit Card</h4>
                    <p>5% cashback on bill payments, recharges via Google Pay. 2% on all other spends.</p>
                    <a href="?action=apply_cc_form&card=Axis Bank Ace" class="app-button secondary">Apply Now</a>
                </div>
                <div class="card-offer">
                    <h4>ICICI Bank Amazon Pay Card</h4>
                    <p>Up to 5% back for Prime members on Amazon.in. No joining or annual fees.</p>
                    <a href="?action=apply_cc_form&card=ICICI Amazon Pay" class="app-button secondary">Apply Now</a>
                </div>
                 <div class="card-offer">
                    <h4>SBI SimplyCLICK Credit Card</h4>
                    <p>10X rewards on online spends with exclusive partners. Welcome voucher.</p>
                    <a href="?action=apply_cc_form&card=SBI SimplyCLICK" class="app-button secondary">Apply Now</a>
                </div>
            </div>
        </main>

        <!-- Apply Credit Card Screen - Form -->
         <main id="applyCCFormScreen" class="screen <?php echo display_screen('apply_cc_form', $current_action); ?>">
            <?php $card_applied_for = htmlspecialchars($_GET['card'] ?? 'Credit Card'); ?>
            <h3>Apply for <?php echo $card_applied_for; ?></h3>
            <form method="POST" action="?action=apply_cc_form&card=<?php echo urlencode($card_applied_for); ?>">
                <input type="hidden" name="form_action" value="process_apply_cc">
                <input type="hidden" name="card_applied_for" value="<?php echo $card_applied_for; ?>">
                 <div class="form-group">
                    <label for="applicantName">Full Name</label>
                    <input type="text" id="applicantName" name="applicantName" placeholder="Enter Your Full Name" required>
                </div>
                <div class="form-group">
                    <label for="applicantMobile">Mobile Number</label>
                    <input type="tel" id="applicantMobile" name="applicantMobile" placeholder="Enter Mobile Number" required>
                </div>
                <div class="form-group">
                    <label for="applicantEmail">Email ID</label>
                    <input type="email" id="applicantEmail" name="applicantEmail" placeholder="Enter Email ID" required>
                </div>
                <div class="form-group">
                    <label for="applicantPAN">PAN Card Number</label>
                    <input type="text" id="applicantPAN" name="applicantPAN" placeholder="Enter PAN Number" required>
                </div>
                <button type="submit" class="app-button">Submit Application</button>
            </form>
        </main>


        <!-- Transactions Screen -->
        <main id="transactionsScreen" class="screen <?php echo display_screen('transactions', $current_action); ?>">
            <h2>Recent Transactions</h2>
            <?php if (empty($_SESSION['transactions']) || count($_SESSION['transactions']) === 1 && $_SESSION['transactions'][0]['description'] === 'Initial Balance' && $_SESSION['transactions'][0]['amount'] == 0 ): ?>
                <p style="text-align:center; color:#777; margin-top:20px;">No transactions yet.</p>
            <?php else: ?>
                <ul>
                    <?php foreach ($_SESSION['transactions'] as $tx): ?>
                        <?php if ($tx['description'] === 'Initial Balance' && $tx['amount'] == 0 && count($_SESSION['transactions']) > 1) continue; // Skip empty initial balance if other tx exist ?>
                        <li>
                            <i class="fas <?php echo $tx['type'] === 'credit' ? 'fa-arrow-down' : 'fa-arrow-up'; ?> transaction-icon" style="color: <?php echo $tx['type'] === 'credit' ? '#28a745' : '#dc3545'; ?>;"></i>
                            <div class="transaction-details">
                                <span class="transaction-description"><?php echo htmlspecialchars($tx['description']); ?></span>
                                <span class="transaction-date"><?php echo htmlspecialchars($tx['date']); ?></span>
                            </div>
                            <span class="transaction-amount <?php echo $tx['type']; ?>">
                                <?php echo $tx['type'] === 'credit' ? '+' : '-'; ?> ₹<?php echo number_format(htmlspecialchars($tx['amount']), 2); ?>
                            </span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </main>

        <!-- Profile Screen -->
        <main id="profileScreen" class="screen <?php echo display_screen('profile', $current_action); ?>">
            <h2>My Profile</h2>
            <div class="profile-info">
                <p><strong>Name:</strong> <?php echo htmlspecialchars($_SESSION['profile']['name']); ?></p>
                <p><strong>Mobile:</strong> <?php echo htmlspecialchars($_SESSION['profile']['mobile']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['profile']['email']); ?></p>
            </div>
            <!-- Add more profile details or an edit button if needed -->
        </main>

        <!-- Settings Screen -->
        <main id="settingsScreen" class="screen <?php echo display_screen('settings', $current_action); ?>">
            <h2>Settings</h2>
            <div class="settings-list">
                <a href="#"><i class="fas fa-lock"></i> Change Password</a>
                <a href="#"><i class="fas fa-key"></i> Forgot Password (Reset)</a>
                <a href="#"><i class="fas fa-bell"></i> Notification Preferences</a>
                <a href="#"><i class="fas fa-shield-alt"></i> Security & Privacy</a>
                <a href="?action=dashboard&logout=true" style="color: #dc3545;"><i class="fas fa-sign-out-alt"></i> Logout (Simulated - Resets Session)</a>
                 <?php 
                    if(isset($_GET['logout']) && $_GET['logout'] == 'true'){
                        session_unset(); 
                        session_destroy();
                        // Redirect to prevent resubmission and clear GET param
                        echo "<script>window.location.href = 'quick_quids_app_sample.php?action=dashboard';</script>";
                        exit;
                    }
                 ?>
            </div>
        </main>
        
        <nav class="app-footer-nav">
            <a href="?action=dashboard" class="nav-item <?php if($current_action == 'dashboard' || $current_action == '') echo 'active'; ?>">
                <i class="fas fa-home"></i><span>Home</span>
            </a>
            <a href="?action=transactions" class="nav-item <?php if($current_action == 'transactions') echo 'active'; ?>">
                <i class="fas fa-history"></i><span>History</span>
            </a>
             <a href="?action=add_fund" class="nav-item <?php if($current_action == 'add_fund' || $current_action == 'add_fund_pg') echo 'active'; ?>" style="font-size:1.2rem; padding: 5px; background-color:#007bff; color:white; border-radius:50%; width:50px; height:50px; margin-top:-25px; box-shadow: 0 -2px 10px rgba(0,123,255,0.5);">
                <i class="fas fa-plus" style="font-size:1.5rem; margin:0;"></i>
            </a>
            <a href="?action=profile" class="nav-item <?php if($current_action == 'profile') echo 'active'; ?>">
                <i class="fas fa-user-circle"></i><span>Profile</span>
            </a>
            <a href="?action=settings" class="nav-item <?php if($current_action == 'settings') echo 'active'; ?>">
                <i class="fas fa-cog"></i><span>Settings</span>
            </a>
        </nav>
    </div>
<script>
    // JavaScript for Add Fund Payment Method Toggle and Amount Update
    const addFundAmountInput = document.getElementById('addFundAmount');
    const payButtonAmountSpan = document.getElementById('payButtonAmount');
    const selectedPaymentMethodInput = document.getElementById('selectedPaymentMethodInput');

    if (addFundAmountInput && payButtonAmountSpan) {
        addFundAmountInput.addEventListener('input', function() {
            const amount = parseFloat(this.value) || 0;
            payButtonAmountSpan.textContent = amount.toFixed(2);
        });
         // Initialize button amount if pre-filled
        const initialAmount = parseFloat(addFundAmountInput.value) || 0;
        payButtonAmountSpan.textContent = initialAmount.toFixed(2);
    }


    function togglePaymentMethod(method) {
        document.getElementById('upiDetailsTab').style.display = (method === 'upi') ? 'block' : 'none';
        document.getElementById('cardDetailsTab').style.display = (method === 'card') ? 'block' : 'none';
        document.getElementById('netbankingDetailsTab').style.display = (method === 'netbanking') ? 'block' : 'none';

        document.getElementById('upiTabBtn').classList.toggle('active', method === 'upi');
        document.getElementById('cardTabBtn').classList.toggle('active', method === 'card');
        document.getElementById('netbankingTabBtn').classList.toggle('active', method === 'netbanking');
        
        if(selectedPaymentMethodInput) {
            selectedPaymentMethodInput.value = method;
        }
    }

    // Auto-format card number and expiry
    const cardNumberInput = document.getElementById('cardNumber');
    if(cardNumberInput) {
        cardNumberInput.addEventListener('input', function (e) {
            e.target.value = e.target.value.replace(/[^\dA-Z]/g, '').replace(/(.{4})/g, '$1 ').trim();
        });
    }
    const expiryDateInput = document.getElementById('expiryDate');
    if(expiryDateInput) {
        expiryDateInput.addEventListener('input', function (e) {
            let value = e.target.value.replace(/[^\d]/g, '');
            if (value.length > 2) {
                value = value.substring(0, 2) + '/' + value.substring(2,4);
            }
            e.target.value = value;
        });
    }
</script>
</body>
</html>
