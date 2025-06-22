<?php

$users = [
    [
        'sn' => 1,
        'name' => 'Asmita Chhetri',
        'username' => 'asmita11',
        'email' => 'asmita11@gmail.com',
        'role' => 'Staff',
        'created_date' => '2020-03-15'
    ],
    [
        'sn' => 2,
        'name' => 'Mamata Paudel',
        'username' => 'mamata22',
        'email' => 'mamata22@gmail.com',
        'role' => 'User',
        'created_date' => '2020-03-15'
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>User Management</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f2f6fa;
      padding: 20px;
    }

    h2, h3 {
      color: #2e8b57;
    }

    .actions {
      margin-bottom: 20px;
    }

    .actions button {
      padding: 10px 15px;
      background-color: #2e8b57;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .actions button:hover {
      background-color: #256f46;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: white;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
      margin-top: 20px;
    }

    th, td {
      padding: 12px;
      border: 1px solid #ddd;
      text-align: left;
    }

    th {
      background-color: #2e8b57;
      color: white;
    }

    .button-small {
      background-color: #3b82f6;
      color: white;
      padding: 6px 10px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      margin-right: 5px;
    }

    .button-small.delete {
      background-color: #dc2626;
    }

    #addUserForm, #editUserForm {
      display: none;
      margin-top: 30px;
      background-color: white;
      padding: 20px;
      border-radius: 8px;
      max-width: 600px;
    }

    input, select {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    form button {
      background-color: #2e8b57;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
    }

    form button:hover {
      background-color: #256f46;
    }
  </style>
</head>
<body>

  <h2>👤 User Management</h2>

  <div class="actions">
    <button onclick="toggleUserForm()">➕ Add New User</button>
  </div>

  <!-- Table of Users -->
  <table id="userTable">
    <thead>
      <tr>
        <th>SN</th>
        <th>Name</th>
        <th>Username</th>
        <th>Email</th>
        <th>Role</th>
        <th>Created Date</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($users as $user): ?>
      <tr>
        <td><?= htmlspecialchars($user['sn']) ?></td>
        <td><?= htmlspecialchars($user['name']) ?></td>
        <td><?= htmlspecialchars($user['username']) ?></td>
        <td><?= htmlspecialchars($user['email']) ?></td>
        <td><?= htmlspecialchars($user['role']) ?></td>
        <td><?= htmlspecialchars($user['created_date']) ?></td>
        <td>
          <button class="button-small" onclick="showEditForm(this)"> Edit</button>
          <button class="button-small delete"> Delete</button>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <!-- Add User Form -->
  <div id="addUserForm">
    <h3>➕ Add New User</h3>
    <form action="add_user.php" method="POST">
      <label>Full Name:</label>
      <input type="text" name="name" required>

      <label>Username:</label>
      <input type="text" name="username" required>

      <label>Email:</label>
      <input type="email" name="email" required>

      <label>Password:</label>
      <input type="password" name="password" required>

      <label>Role:</label>
      <select name="role" required>
        <option value="">Select</option>
        <option value="Admin">Admin</option>
        <option value="Staff">Staff</option>
        <option value="User">User</option>
      </select>

      <label>Created Date:</label>
      <input type="date" name="created_date" required>

      <button type="submit">💾 Save User</button>
    </form>
  </div>

  <!-- Edit User Form -->
  <div id="editUserForm">
    <h3>✏️ Edit User</h3>
    <form action="update_user.php" method="POST">
      <label>Full Name:</label>
      <input type="text" name="name" id="edit_name" required>

      <label>Username:</label>
      <input type="text" name="username" id="edit_username" required>

      <label>Email:</label>
      <input type="email" name="email" id="edit_email" required>

      <label>New Password:</label>
      <input type="password" name="password" placeholder="Leave blank to keep old password">

      <label>Role:</label>
      <select name="role" id="edit_role" required>
        <option value="">Select</option>
        <option value="Admin">Admin</option>
        <option value="Staff">Staff</option>
        <option value="User">User</option>
      </select>

      <label>Created Date:</label>
      <input type="date" name="created_date" id="edit_created_date" required>

      <button type="submit">💾 Update User</button>
    </form>
  </div>

  <script>
    function toggleUserForm() {
      const form = document.getElementById('addUserForm');
      form.style.display = form.style.display === 'none' || form.style.display === '' ? 'block' : 'none';
      document.getElementById('editUserForm').style.display = 'none';
    }

    function showEditForm(button) {
      const row = button.closest('tr');
      const cells = row.querySelectorAll('td');

      document.getElementById('edit_name').value = cells[1].innerText;
      document.getElementById('edit_username').value = cells[2].innerText;
      document.getElementById('edit_email').value = cells[3].innerText;
      document.getElementById('edit_role').value = cells[4].innerText;
      document.getElementById('edit_created_date').value = cells[5].innerText;

      document.getElementById('editUserForm').style.display = 'block';
      document.getElementById('addUserForm').style.display = 'none';
    }
  </script>

</body>
</html>
