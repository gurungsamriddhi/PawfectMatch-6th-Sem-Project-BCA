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

   <!--<h2>📊 Donation Summary Report</h2>

  <div class="summary-box">
    <div><strong>Total Donation Amount:</strong> NPR 2,551.25</div>
    <div><strong>Total Number of Donors:</strong> 4</div>
    <div><strong>Average Donation:</strong> NPR 637.81</div>
    <div><strong>Donations by Payment Method:</strong></div>
    <ul>
      <li>Credit Card – 2 donation(s)</li>
      <li>Paypal – 1 donation(s)</li>
      <li>Bank Transfer – 1 donation(s)</li>
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
        <tr>
          <td>101</td>
          <td>Asmita Chhetri</td>
          <td>asmita11@gmail.com</td>
          <td>500.50</td>
          <td>2024-06-20</td>
          <td>Credit Card</td>
          <td>Keep up the great work!</td>
        </tr>
        <tr>
          <td>102</td>
          <td>Mamata Paudel</td>
          <td>mamata22@gmail.com</td>
          <td>1000.00</td>
          <td>2024-06-21</td>
          <td>Paypal</td>
          <td>Happy to support!</td>
        </tr>
        <tr>
          <td>103</td>
          <td>Rejina Pokharel</td>
          <td>rejina10@gmail.com</td>
          <td>250.75</td>
          <td>2024-06-22</td>
          <td>Bank Transfer</td>
          <td>Hope this helps a lot!</td>
        </tr>
        <tr>
          <td>104</td>
          <td>Samriddhi Gurnung</td>
          <td>samriddhi13@gmail.com</td>
          <td>800.00</td>
          <td>2024-06-23</td>
          <td>Credit Card</td>
          <td>Great cause!</td>
        </tr>
      </tbody>
    </table>
  </div>

</body>
</html>
