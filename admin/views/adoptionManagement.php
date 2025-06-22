<?php
// Simulated data (In real use case, fetch from DB)
$adoptionRequests = [
    [
        'id' => 101,
        'applicant' => 'Asmita Chhetri',
        'pet' => 'Charlie (Dog)',
        'status' => 'pending',
        'date' => '2025-07-10'
    ],
    [
        'id' => 102,
        'applicant' => 'Samriddhi Gurnung',
        'pet' => 'Milo (Cat)',
        'status' => 'approved',
        'date' => '2025-07-15'
    ],
];

// Handle form submission to update status
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['request_id'], $_POST['new_status'])) {
    $requestId = intval($_POST['request_id']);
    $newStatus = $_POST['new_status'];

    // Update the status in the $adoptionRequests array (simulate DB update)
    foreach ($adoptionRequests as &$request) {
        if ($request['id'] === $requestId) {
            $request['status'] = $newStatus;
            break;
        }
    }
    unset($request); // break reference
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Adoption Management</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f1f5f9;
      margin: 0;
      padding: 20px;
    }

    h2 {
      color: #333;
      margin-bottom: 15px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: white;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }

    th, td {
      padding: 12px 15px;
      border: 1px solid #ddd;
      text-align: left;
    }

    th {
      background-color: #3b8beb;
      color: white;
    }

    select, button {
      padding: 6px 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      margin-right: 5px;
    }

    .actions button {
      background-color: #3b8beb;
      color: white;
      cursor: pointer;
    }

    .actions button:hover {
      background-color: #2563eb;
    }

    .status-pending { color: orange; font-weight: bold; }
    .status-approved { color: green; font-weight: bold; }
    .status-rejected { color: red; font-weight: bold; }

  </style>
</head>
<body>

  <h2>Adoption Requests</h2>

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
      <?php foreach ($adoptionRequests as $request): ?>
      <tr>
        <td>#<?= htmlspecialchars($request['id']) ?></td>
        <td><?= htmlspecialchars($request['applicant']) ?></td>
        <td><?= htmlspecialchars($request['pet']) ?></td>
        <td>
          <?php
            $statusClass = 'status-' . $request['status'];
            $statusText = ucfirst($request['status']);
          ?>
          <span class="<?= $statusClass ?>"><?= $statusText ?></span>
        </td>
        <td><?= htmlspecialchars($request['date']) ?></td>
        <td class="actions">
          <form method="post" style="display:inline;">
            <input type="hidden" name="request_id" value="<?= htmlspecialchars($request['id']) ?>">
            <select name="new_status">
              <option value="pending" <?= $request['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
              <option value="approved" <?= $request['status'] === 'approved' ? 'selected' : '' ?>>Approve</option>
              <option value="rejected" <?= $request['status'] === 'rejected' ? 'selected' : '' ?>>Reject</option>
            </select>
            <button type="submit">Update</button>
          </form>
          <button onclick="alert('View form for request #<?= $request['id'] ?>')">View Form</button>
          <button onclick="alert('Match pet for request #<?= $request['id'] ?>')">Match Pet</button>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

</body>
</html>
