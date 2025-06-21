<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
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
        <tr>
          <td>1</td>
          <td>Asmita Chhetri</td>
          <td>asmita11</td>
          <td>asmita11@gmail.com</td>
          <td>12345</td>
        <td>staff</td>
          <td>2020-03-15</td>
        </tr>
          <tr>
          <td>2</td>
          <td>Mamata Paudel</td>
          <td>mamata22</td>
          <td>mamata22@gmail.com</td>
          <td>12345</td>
          <td>user</td>
          <td>2020-03-15</td>
        </tr>
        <tr>
          <td></td>
          <td>Rejina Pokharel</td>
          <td>rejina10</td>
          <td>rejina10gmail.com</td3>
          <td>12345</td>
          <td>user</td>
          </td>
          <td>2020-03-15</td>
        </tr>
        <tr>
          <td>4</td>
          <td>Samriddhi Gurnung</td>
          <td>samriddhi13</td>
          <td>samriddhi13@gmail.com</td>
          <td>12345</td>
          <td>Admin</td>
          <td>2020-03-15</td>
        </tr><tr>
          <td>5</td>
          <td>Shyam adhikari</td>
          <td>shyam7</td>
          <td>adhikarishyam7@gmail.com</td>
          <td>12345</td>
          <td>user</td>
          <
          <td>2020-03-15</td>
        </tr>
        
      </tbody>
    </table>
  </div>

</body>
</html>
