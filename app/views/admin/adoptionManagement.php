<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Adoption Management UI</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f1f5f9;
      margin: 0;
      padding: 20px;
    }

    h2 {
      color: #333;
      margin-bottom: 20px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: #fff;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
      border-radius: 8px;
      overflow: hidden;
    }

    th, td {
      padding: 12px 15px;
      border: 1px solid #ddd;
      text-align: left;
    }

    th {
      background-color:rgb(79, 225, 110);
      color: white;
      font-size: 14px;
      text-transform: uppercase;
    }

    select, button {
      padding: 6px 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      margin-right: 5px;
    }

    .actions button {
      background-color:rgb(78, 203, 124);
      color: white;
      cursor: pointer;
      font-size: 13px;
    }

    .actions button:hover {
      background-color:rgb(78, 203, 124);
    }

    .status-pending {
      color: orange;
      font-weight: bold;
    }

    .status-approved {
      color: green;
      font-weight: bold;
    }

    .status-rejected {
      color: red;
      font-weight: bold;
    }

    .pet-table > tbody > tr:hover, 
    .pet-table tbody tr:hover, 
    .table.pet-table tbody tr:hover {
      background: #e0e0e0 !important;
    }
  </style>
</head>
<body>

  <h2>🐾 Adoption Requests</h2>

  <table>
    <thead>
      <tr>
        <th>Request ID</th>
        <th>Applicant Name</th>
        <th>Pet Name</th>
        <th>Status</th>
        <th>Preferred Date</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>#101</td>
        <td>Asmita Chhetri</td>
        <td>Charlie (Dog)</td>
        <td><span class="status-pending">Pending</span></td>
        <td>2025-07-10</td>
        <td class="actions">
          <select>
            <option value="pending" selected>Pending</option>
            <option value="approved">Approve</option>
            <option value="rejected">Reject</option>
          </select>
          <button>Update</button>
          <button onclick="alert('View form for request #101')">View Form</button>
          <button onclick="alert('Match pet for request #101')">Match Pet</button>
        </td>
      </tr>

      <tr>
        <td>#102</td>
        <td>Samriddhi Gurnung</td>
        <td>Milo (Cat)</td>
        <td><span class="status-approved">Approved</span></td>
        <td>2025-07-15</td>
        <td class="actions">
          <select>
            <option value="pending">Pending</option>
            <option value="approved" selected>Approve</option>
            <option value="rejected">Reject</option>
          </select>
          <button>Update</button>
          <button onclick="alert('View form for request #102')">View Form</button>
          <button onclick="alert('Match pet for request #102')">Match Pet</button>
        </td>
      </tr>
    </tbody>
  </table>

</body>
</html>
