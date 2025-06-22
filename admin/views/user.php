<?php
// User data array
$users = [
    ['sn' => 1, 'name' => 'Asmita Chhetri', 'username' => 'asmita11', 'email' => 'asmita11@gmail.com', 'password' => '12345', 'role' => 'staff', 'created_date' => '2020-03-15'],
    ['sn' => 2, 'name' => 'Mamata Paudel', 'username' => 'mamata22', 'email' => 'mamata22@gmail.com', 'password' => '12345', 'role' => 'user', 'created_date' => '2020-03-15'],
    ['sn' => 3, 'name' => 'Rejina Pokharel', 'username' => 'rejina10', 'email' => 'rejina10gmail.com', 'password' => '12345', 'role' => 'user', 'created_date' => '2020-03-15'],
    ['sn' => 4, 'name' => 'Samriddhi Gurnung', 'username' => 'samriddhi13', 'email' => 'samriddhi13@gmail.com', 'password' => '12345', 'role' => 'Admin', 'created_date' => '2020-03-15'],
    ['sn' => 5, 'name' => 'Shyam adhikari', 'username' => 'shyam7', 'email' => 'adhikarishyam7@gmail.com', 'password' => '12345', 'role' => 'user', 'created_date' => '2020-03-15'],
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>User Management</title>
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

    select {
      padding: 5px;
      border-radius: 5px;
    }
  </style>
</head>
<body>

  <div class="table-container">
    <table>
      <thead>
        <tr>
          <th>SN</th>
          <th>Name</th>
          <th>Username</th>
          <th>Email</th>
          <th>Password</th>
          <th>Role</th>
          <th>Created Date</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($users as $user): ?>
          <tr>
            <td><?= htmlspecialchars($user['sn']) ?></td>
            <td><?= htmlspecialchars($user['name']) ?></td>
            <td><?= htmlspecialchars($user['username']) ?></td>
            <td><?= htmlspecialchars($user['email']) ?></td>
            <td><?= htmlspecialchars($user['password']) ?></td>
            <td><?= htmlspecialchars($user['role']) ?></td>
            <td><?= htmlspecialchars($user['created_date']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

</body>
</html>
