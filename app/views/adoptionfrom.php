<?php
// Handle form data if coming back after submit or prefill
$has_other_pets = isset($_POST['has_other_pets']) ? $_POST['has_other_pets'] : 0;
$other_pet_details = isset($_POST['other_pet_details']) ? $_POST['other_pet_details'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Adoption Form</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f0f8ff;
      padding: 20px;
      display: flex;
      justify-content: center;
    }

    .form-box {
      background: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 6px 20px rgba(0,0,0,0.1);
      max-width: 600px;
      width: 100%;
    }

    h2 {
      text-align: center;
      color: #4CAF50;
      margin-bottom: 25px;
    }

    label {
      font-weight: bold;
      display: block;
      margin: 12px 0 6px;
    }

    input, select, textarea {
      width: 100%;
      padding: 10px;
      border-radius: 6px;
      border: 1px solid #ccc;
      margin-bottom: 12px;
    }

    textarea {
      resize: vertical;
    }

    .form-group {
      margin-bottom: 15px;
    }

    button {
      width: 100%;
      background-color: #4CAF50;
      color: white;
      padding: 12px;
      font-size: 16px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }

    button:hover {
      background-color: #45a049;
    }
  </style>
</head>
<body>
  <div class="form-box">
    <h2>🐾 Animal Adoption Form</h2>
    <form action="submit_adoption.php" method="POST">
      <!-- Example hidden fields -->
      <input type="hidden" name="user_id" value="1" />
      <input type="hidden" name="request_id" value="101" />

      <label for="pet_id">Select Pet</label>
      <select id="pet_id" name="pet_id" required>
        <option value="">-- Choose a Pet --</option>
        <option value="1">Buddy (Dog)</option>
        <option value="2">Whiskers (Cat)</option>
        <option value="3">Chirpy (Bird)</option>
      </select>

      <label for="address">Your Address</label>
      <textarea id="address" name="address" required><?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : ''; ?></textarea>

      <label for="phone">Phone Number</label>
      <input type="tel" id="phone" name="phone" value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>" required />

      <label for="reason">Reason for Adopting</label>
      <textarea id="reason" name="reason" required><?php echo isset($_POST['reason']) ? htmlspecialchars($_POST['reason']) : ''; ?></textarea>

      <label for="preferred_date">Preferred Adoption Date</label>
      <input type="date" id="preferred_date" name="preferred_date" value="<?php echo isset($_POST['preferred_date']) ? htmlspecialchars($_POST['preferred_date']) : ''; ?>" />

      <label for="home_type">Home Type</label>
      <select id="home_type" name="home_type" required>
        <option value="">-- Select Home Type --</option>
        <option value="house" <?php if(isset($_POST['home_type']) && $_POST['home_type']=='house') echo 'selected'; ?>>House</option>
        <option value="apartment" <?php if(isset($_POST['home_type']) && $_POST['home_type']=='apartment') echo 'selected'; ?>>Apartment</option>
        <option value="other" <?php if(isset($_POST['home_type']) && $_POST['home_type']=='other') echo 'selected'; ?>>Other</option>
      </select>

      <label>Do you have other pets?</label>
      <select name="has_other_pets">
        <option value="0" <?php if ($has_other_pets == 0) echo 'selected'; ?>>No</option>
        <option value="1" <?php if ($has_other_pets == 1) echo 'selected'; ?>>Yes</option>
      </select>

      <?php if ($has_other_pets == 1): ?>
        <label for="other_pet_details">Please describe your other pets:</label>
        <textarea id="other_pet_details" name="other_pet_details"><?php echo htmlspecialchars($other_pet_details); ?></textarea>
      <?php endif; ?>

      <button type="submit">Submit Adoption Request</button>
    </form>
  </div>
</body>
</html>
