<?php
// Sample donation data
$donations = [
  ['user_id' => 101, 'donor_name' => 'Asmita Chhetri', 'email' => 'asmita11@gmail.com', 'amount' => 500.50, 'date' => '2024-06-20', 'payment_method' => 'Credit Card', 'message' => 'Keep up the great work!'],
  ['user_id' => 102, 'donor_name' => 'Mamata Paudel', 'email' => 'mamata22@gmail.com', 'amount' => 1000.00, 'date' => '2024-06-21', 'payment_method' => 'Paypal', 'message' => 'Happy to support!'],
  ['user_id' => 103, 'donor_name' => 'Rejina Pokharel', 'email' => 'rejina10@gmail.com', 'amount' => 250.75, 'date' => '2024-06-22', 'payment_method' => 'Bank Transfer', 'message' => 'Hope this helps a lot!'],
  ['user_id' => 104, 'donor_name' => 'Samriddhi Gurnung', 'email' => 'samriddhi13@gmail.com', 'amount' => 800.00, 'date' => '2024-06-23', 'payment_method' => 'Credit Card', 'message' => 'Great cause!'],
];

// Calculate summary
$totalDonations = 0;
$totalDonors = [];
$paymentMethods = [];

foreach ($donations as $donation) {
  $totalDonations += $donation['amount'];
  $totalDonors[$donation['user_id']] = true;
  $paymentMethods[$donation['payment_method']] = ($paymentMethods[$donation['payment_method']] ?? 0) + 1;
}

$totalDonorsCount = count($totalDonors);
$averageDonation = $totalDonations / count($donations);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Donation Report</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, sans-serif;
      margin: 0;
      padding: 40px;
      background: #f2f6fa;
    }

    h2 {
      color: #2e3a59;
      margin-bottom: 20px;
    }

    .summary-box {
      background: #ffffff;
      padding: 25px;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
      margin-bottom: 30px;
      max-width: 600px;
    }

    .summary-box div {
      margin-bottom: 12px;
      font-size: 16px;
      color: #333;
    }

    .summary-box ul {
      margin-top: 8px;
      padding-left: 20px;
    }

    .table-container {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
      overflow-x: auto;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      min-width: 900px;
    }

    th {
      background: #2c3e50;
      color: #fff;
      padding: 14px;
      font-size: 14px;
      text-transform: uppercase;
    }

    td {
      padding: 14px;
      border-bottom: 1px solid #eee;
      font-size: 14px;
      text-align: center;
    }

    tr:hover {
      background-color: #eaf2ff;
    }

    @media (max-width: 768px) {
      body {
        padding: 20px;
      }

      table {
        font-size: 12px;
        min-width: unset;
      }

      .summary-box {
        max-width: 100%;
      }
    }
  </style>
</head>
<body>

  <h2>📊 Donation Summary Report</h2>

  <div class="summary-box">
    <div><strong>Total Donation Amount:</strong> NPR <?= number_format($totalDonations, 2) ?></div>
    <div><strong>Total Number of Donors:</strong> <?= $totalDonorsCount ?></div>
    <div><strong>Average Donation:</strong> NPR <?= number_format($averageDonation, 2) ?></div>
    <div><strong>Donations by Payment Method:</strong></div>
    <ul>
      <?php foreach ($paymentMethods as $method => $count): ?>
        <li><?= htmlspecialchars($method) ?> – <?= $count ?> donation(s)</li>
      <?php endforeach; ?>
    </ul>
  </div>

  <h2>💖 All Donations</h2>

  <div class="table-container">
    <table>
      <thead>
        <tr>
          <th>User ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Amount (NPR)</th>
          <th>Date</th>
          <th>Payment</th>
          <th>Message</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($donations as $donation): ?>
        <tr>
          <td><?= htmlspecialchars($donation['user_id']) ?></td>
          <td><?= htmlspecialchars($donation['donor_name']) ?></td>
          <td><?= htmlspecialchars($donation['email']) ?></td>
          <td><?= number_format($donation['amount'], 2) ?></td>
          <td><?= htmlspecialchars($donation['date']) ?></td>
          <td><?= htmlspecialchars($donation['payment_method']) ?></td>
          <td><?= htmlspecialchars($donation['message']) ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

</body>
</html>
