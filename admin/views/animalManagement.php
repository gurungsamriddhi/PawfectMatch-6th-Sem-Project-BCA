<?php
// Simulated animal data (you can replace this with DB queries later)
$animals = [
    [
        'image' => 'admin/views/Images/charlie.png',
        'name' => 'Charlie',
        'type' => 'Dog',
        'breed' => 'Labrador',
        'age' => 2,
        'gender' => 'Male',
        'status' => 'Available',
        'posted_by' => 'Admin',
        'description' => 'Very friendly, playful and house-trained.',
        'health' => 'Vaccinated',
    ],
    [
        'image' => 'uploads/Coco.jpg',
        'name' => 'Coco',
        'type' => 'Dog',
        'breed' => 'Labrador',
        'age' => 3,
        'gender' => 'Female',
        'status' => 'Available',
        'posted_by' => 'Admin',
        'description' => 'Very friendly',
        'health' => 'Not Vaccinated',
    ],
    [
        'image' => 'uploads/luna.jpg',
        'name' => 'Luna',
        'type' => 'Cat',
        'breed' => 'Siamese',
        'age' => 1,
        'gender' => 'Female',
        'status' => 'Adopted',
        'posted_by' => 'Rejina',
        'description' => 'Calm and affectionate. Good with kids.',
        'health' => 'Healthy',
    ],
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Animal Management</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f2f6fa;
      margin: 0;
      padding: 20px;
    }

    h2, h3 {
      color: #2e8b57;
    }

    .actions {
      margin-bottom: 15px;
    }

    .actions button {
      padding: 10px 15px;
      margin-right: 10px;
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
      background-color: white;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }

    th, td {
      padding: 12px;
      text-align: left;
      border: 1px solid #ddd;
      vertical-align: top;
    }

    th {
      background-color: #2e8b57;
      color: white;
    }

    img {
      width: 60px;
      height: 60px;
      object-fit: cover;
      border-radius: 6px;
    }

    select.filter {
      padding: 8px;
      border-radius: 5px;
      border: 1px solid #ccc;
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

    .button-small.health {
      background-color: #f59e0b;
    }

    #addFormContainer {
      display: none;
      margin-top: 30px;
    }

    form input, form select, form textarea {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      margin-bottom: 15px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }

    form button {
      background-color: #2e8b57;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    form button:hover {
      background-color: #256f46;
    }
  </style>
</head>
<body>

  <h2>🐾 Animal Management</h2>

  <div class="actions">
    <button onclick="toggleAddForm()">➕ Add New Animal</button>
    <label for="typeFilter">🗂️ Filter by Type: </label>
    <select class="filter" id="typeFilter" onchange="filterByType(this)">
      <option value="All">All</option>
      <option value="Dog">Dog</option>
      <option value="Cat">Cat</option>
      <option value="Rabbit">Rabbit</option>
      <option value="Bird">Bird</option>
    </select>
  </div>

  <table id="animalTable">
    <thead>
      <tr>
        <th>Image</th>
        <th>Name</th>
        <th>Type</th>
        <th>Breed</th>
        <th>Age</th>
        <th>Gender</th>
        <th>Status</th>
        <th>Posted By</th>
        <th>Description</th>
        <th>Health</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($animals as $animal): ?>
      <tr data-type="<?= htmlspecialchars($animal['type']) ?>">
        <td><img src="<?= htmlspecialchars($animal['image']) ?>" alt="<?= htmlspecialchars($animal['name']) ?>"></td>
        <td><?= htmlspecialchars($animal['name']) ?></td>
        <td><?= htmlspecialchars($animal['type']) ?></td>
        <td><?= htmlspecialchars($animal['breed']) ?></td>
        <td><?= htmlspecialchars($animal['age']) ?></td>
        <td><?= htmlspecialchars($animal['gender']) ?></td>
        <td style="color: <?= $animal['status'] === 'Available' ? 'green' : ($animal['status'] === 'Adopted' ? 'red' : 'orange') ?>;">
          <?= htmlspecialchars($animal['status']) ?>
        </td>
        <td><?= htmlspecialchars($animal['posted_by']) ?></td>
        <td><?= htmlspecialchars($animal['description']) ?></td>
        <td><?= htmlspecialchars($animal['health']) ?></td>
        <td>
          <button class="button-small"> Edit</button>
          <button class="button-small delete"> Delete</button>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <!-- Add New Animal Form (toggle) -->
  <div id="addFormContainer">
    <h3>➕ Add New Animal</h3>
    <form action="add_pet.php" method="POST" enctype="multipart/form-data">
      <label>Name:</label>
      <input type="text" name="name" required>

      <label>Type:</label>
      <select name="type" required>
        <option value="">Select</option>
        <option value="Dog">Dog</option>
        <option value="Cat">Cat</option>
        <option value="Rabbit">Rabbit</option>
        <option value="Bird">Bird</option>
      </select>

      <label>Breed:</label>
      <input type="text" name="breed" required>

      <label>Age:</label>
      <input type="number" name="age" min="0" step="0.5" required>

      <label>Gender:</label>
      <select name="gender" required>
        <option value="">Select</option>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
      </select>

      <label>Status:</label>
      <select name="status" required>
        <option value="">Select</option>
        <option value="Available">Available</option>
        <option value="Adopted">Adopted</option>
        <option value="Reserved">Reserved</option>
      </select>

      <label>Health:</label>
      <select name="health" required>
        <option value="">Select</option>
        <option value="Vaccinated">Vaccinated</option>
        <option value="Vaccinated And Healthy">Vaccinated And Healthy</option>
        <option value="Not Vaccinated">Not Vaccinated</option>
      </select>

      <label>Posted By:</label>
      <input type="text" name="posted_by" required>

      <label>Description:</label>
      <textarea name="description" rows="4" required></textarea>

      <label>Image:</label>
      <input type="file" name="image" accept="image/*" required>

      <label>Created Date:</label>
      <input type="date" name="created_date" required>

      <button type="submit">💾 Save Animal</button>
    </form>
  </div>

  <script>
    function filterByType(select) {
      const type = select.value;
      const rows = document.querySelectorAll("#animalTable tbody tr");
      rows.forEach(row => {
        const rowType = row.getAttribute("data-type");
        row.style.display = (type === "All" || rowType === type) ? "" : "none";
      });
    }

    function toggleAddForm() {
      const form = document.getElementById("addFormContainer");
      form.style.display = (form.style.display === "none" || form.style.display === '') ? "block" : "none";
    }
  </script>

</body>
</html>
