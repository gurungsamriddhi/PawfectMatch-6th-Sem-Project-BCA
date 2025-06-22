<?php
// Sample donation data array
$donations = [
    ['user_id' => 101, 'donor_name' => 'Asmita Chhetri', 'email' => 'asmita11@gmail.com', 'amount' => 500.50, 'date' => '2024-06-20', 'payment_method' => 'Credit Card', 'message' => 'Keep up the great work!'],
    ['user_id' => 102, 'donor_name' => 'Mamata Paudel', 'email' => 'mamata22@gmail.com', 'amount' => 1000.00, 'date' => '2024-06-21', 'payment_method' => 'Paypal', 'message' => 'Happy to support!'],
    ['user_id' => 103, 'donor_name' => 'Rejina Pokharel', 'email' => 'rejina10@gmail.com', 'amount' => 250.75, 'date' => '2024-06-22', 'payment_method' => 'Bank Transfer', 'message' => 'Hope this helps a lot!'],
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Donation Records</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(120deg, #f6f8fd, #e3efff);
      padding: 40px;
      margin: 0;
    }
    .table-container {
      max-width: 100%;
      overflow-x: auto;
      background: #fff;
      border-radius: 15px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }
    table {
      width: 100%;
      border-collapse: collapse;
      min-width: 900px;
    }
    th {
      background: #3b5f51;
      color: white;
      font-weight: 600;
      text-transform: uppercase;
      font-size: 14px;
      padding: 15px;
    }
    td {
      padding: 15px 20px;
      border-bottom: 1px solid #ddd;
      font-size: 14px;
      color: #333;
      text-align: center;
    }
    tr:hover {
      background-color: #e0f2f1;
    }
  </style>
</head>
<body>

  <div class="table-container">
    <h2>💖 Donation Records</h2>
    <table>
      <thead>
        <tr>
          <th>User ID</th>
          <th>Donor Name</th>
          <th>Email</th>
          <th>Donation Amount (NRs.)</th>
          <th>Donation Date</th>
          <th>Payment Method</th>
          <th>Message</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($donations as $donation): ?>
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
