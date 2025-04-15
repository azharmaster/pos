<?php
// Start the session to transfer data between pages if needed
session_start();

// Get receipt data sent via POST or from session
$orderItems = isset($_POST['orderItems']) ? json_decode($_POST['orderItems'], true) : 
              (isset($_SESSION['orderItems']) ? $_SESSION['orderItems'] : []);
$totalAmount = isset($_POST['totalAmount']) ? floatval($_POST['totalAmount']) : 
               (isset($_SESSION['totalAmount']) ? $_SESSION['totalAmount'] : 0);

// Clear session data after retrieving
unset($_SESSION['orderItems']);
unset($_SESSION['totalAmount']);

// Generate receipt number
$receiptNumber = 'R' . date('YmdHis') . rand(100, 999);

// Get current date and time
$currentDate = date("d/m/Y");
$currentTime = date("H:i:s");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resit Pembayaran - Restoran Mamak Sedap</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
        }
        
        .receipt-container {
            background-color: white;
            padding: 20px;
            max-width: 300px;
            border: 1px dashed #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        
        .receipt-header {
            text-align: center;
            margin-bottom: 15px;
        }
        
        .receipt-header h2 {
            margin: 5px 0;
            font-size: 18px;
        }
        
        .receipt-header p {
            margin: 3px 0;
            font-size: 12px;
        }
        
        .divider {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }
        
        .receipt-info {
            margin-bottom: 15px;
            font-size: 12px;
        }
        
        .receipt-info p {
            margin: 3px 0;
            display: flex;
            justify-content: space-between;
        }
        
        .receipt-items {
            margin-bottom: 15px;
        }
        
        .item-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
            font-size: 12px;
        }
        
        .receipt-total {
            padding-top: 10px;
            margin-top: 10px;
            font-weight: bold;
            font-size: 14px;
        }
        
        .receipt-footer {
            text-align: center;
            margin-top: 15px;
            font-size: 12px;
        }
        
        .button-container {
            text-align: center;
            margin-top: 20px;
        }
        
        .action-button {
            padding: 8px 16px;
            margin: 0 5px;
            background-color: #d35400;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            font-size: 14px;
        }
        
        .action-button:hover {
            background-color: #e67e22;
        }
        
        @media print {
            .button-container {
                display: none;
            }
            
            body {
                padding: 0;
                background-color: white;
            }
            
            .receipt-container {
                box-shadow: none;
                border: none;
                padding: 0;
            }
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <div class="receipt-header">
            <h2>RESTORAN MAMAK SEDAP</h2>
            <p>No. 123, Jalan Mamak</p>
            <p>Kuala Lumpur</p>
            <p>Tel: 03-12345678</p>
        </div>
        
        <div class="divider"></div>
        
        <div class="receipt-info">
            <p>
                <span>No. Resit:</span>
                <span><?php echo $receiptNumber; ?></span>
            </p>
            <p>
                <span>Tarikh:</span>
                <span><?php echo $currentDate; ?></span>
            </p>
            <p>
                <span>Masa:</span>
                <span><?php echo $currentTime; ?></span>
            </p>
        </div>
        
        <div class="divider"></div>
        
        <div class="receipt-items">
            <?php if (!empty($orderItems)): ?>
                <?php foreach ($orderItems as $item): ?>
                    <div class="item-row">
                        <span><?php echo $item['name'] . ' x' . $item['quantity']; ?></span>
                        <span>RM<?php echo number_format($item['total'], 2); ?></span>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="item-row">
                    <span>Tiada item</span>
                    <span>RM0.00</span>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="divider"></div>
        
        <div class="receipt-total">
            <div class="item-row">
                <span>JUMLAH:</span>
                <span>RM<?php echo number_format($totalAmount, 2); ?></span>
            </div>
        </div>
        
        <div class="divider"></div>
        
        <div class="receipt-footer">
            <p>Terima kasih kerana datang!</p>
            <p>Silakan datang lagi</p>
        </div>
        
        <div class="button-container">
            <button class="action-button" onclick="window.print()">CETAK</button>
            <button class="action-button" onclick="window.location.href='index.html'">KEMBALI</button>
        </div>
    </div>
</body>
</html>