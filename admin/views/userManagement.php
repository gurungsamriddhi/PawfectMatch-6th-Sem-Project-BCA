<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>User Management </title>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', sans-serif;
    }

    body {
      background-color: #f4f6f9;
      padding: 30px;
    }

    h2 {
      color: #2e8b57;
      margin-bottom: 20px;
    }

    .actions {
      margin-bottom: 20px;
    }

    .actions button {
         background-color:rgb(78, 203, 124);
      color: white;
      border: none;
      padding: 10px 18px;
      border-radius: 5px;
      font-size: 15px;
      cursor: pointer;
    }

    .actions button:hover {
         background-color:rgb(78, 203, 124);
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background-color: #fff;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
      border-radius: 10px;
      overflow: hidden;
    }

    th, td {
      padding: 14px;
      text-align: left;
      border-bottom: 1px solid #eee;
    }

    th {
      background-color: #2e8b57;
      color: white;
      text-transform: uppercase;
      font-size: 13px;
    }

    td {
      font-size: 14px;
    }

    tr:hover {
      background-color: #f0f9f0;
    }

    .button-small {
      background-color: #3b82f6;
      color: white;
      padding: 6px 10px;
      border: none;
      border-radius: 4px;
      margin-right: 5px;
      cursor: pointer;
    }

    .button-small.delete {
      background-color: #dc2626;
    }

    .form-container {
      margin-top: 30px;
      background: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.08);
      max-width: 600px;
      display: none;
    }

    .form-container h3 {
      margin-bottom: 15px;
      color: #2e8b57;
    }

    .form-container input,
    .form-container select {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 6px;
    }

    .form-container button {
      background-color: #2e8b57;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }

    .form-container button:hover {
      background-color: #256f46;
    }
  </style>
</head>
<body>

  <h2>👤 User Management</h2>

  <div class="actions">
    <button onclick="toggleAddForm()">➕ Add New User</button>
  </div>

  <table>
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
      <tr>
        <td>1</td>
        <td>Asmita Chhetri</td>
        <td>asmita11</td>
        <td>asmita11@gmail.com</td>
        <td>Staff</td>
        <td>2020-03-15</td>
        <td>
          <button class="button-small" onclick="toggleEditForm(this)"> Edit</button>
          <button class="button-small delete"> Delete</button>
        </td>
      </tr>
      <tr>
        <td>2</td>
        <td>Mamata Paudel</td>
        <td>mamata22</td>
        <td>mamata22@gmail.com</td>
        <td>User</td>
        <td>2020-03-15</td>
        <td>
          <button class="button-small" onclick="toggleEditForm(this)"> Edit</button>
          <button class="button-small delete"> Delete</button>
        </td>
      </tr>
    </tbody>
  </table>

  <!-- Add User Form -->
  <div class="form-container" id="addUserForm">
    <h3>➕ Add New User</h3>
    <input type="text" placeholder="Full Name">
    <input type="text" placeholder="Username">
    <input type="email" placeholder="Email">
    <input type="password" placeholder="Password">
    <select>
      <option value="">Select Role</option>
      <option value="Admin">Admin</option>
      <option value="Staff">Staff</option>
      <option value="User">User</option>
    </select>
    <input type="date" placeholder="Created Date">
    <button>💾 Save User</button>
  </div>

  <!-- Edit User Form -->
  <div class="form-container" id="editUserForm">
    <h3> Edit User</h3>
    <input type="text" placeholder="Full Name">
    <input type="text" placeholder="Username">
    <input type="email" placeholder="Email">
    <input type="password" placeholder="New Password (optional)">
    <select>
      <option value="">Select Role</option>
      <option value="Admin">Admin</option>
      <option value="Staff">Staff</option>
      <option value="User">User</option>
    </select>
    <input type="date" placeholder="Created Date">
    <button>💾 Update User</button>
  </div>

  <script>
    function toggleAddForm() {
      document.getElementById('addUserForm').style.display = 'block';
      document.getElementById('editUserForm').style.display = 'none';
    }

    function toggleEditForm(button) {
      document.getElementById('editUserForm').style.display = 'block';
      document.getElementById('addUserForm').style.display = 'none';
    }
  </script>

</body>
</html>
