public function updateProfile($user_id, $name, $email, $phone, $address, $description, $logoPath = null)
{
    global $conn;

    // Update users table email
    $sql1 = "UPDATE users SET email = ? WHERE user_id = ?";
    $stmt1 = $conn->prepare($sql1);
    $stmt1->bind_param("si", $email, $user_id);
    $stmt1->execute();

    // Update adoption center details
    if ($logoPath) {
        $sql2 = "UPDATE adoption_centers SET name = ?, phone = ?, location = ?, description = ?, logo = ?, updated_at = CURRENT_TIMESTAMP WHERE user_id = ?";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bind_param("sssssi", $name, $phone, $address, $description, $logoPath, $user_id);
    } else {
        $sql2 = "UPDATE adoption_centers SET name = ?, phone = ?, location = ?, description = ?, updated_at = CURRENT_TIMESTAMP WHERE user_id = ?";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bind_param("ssssi", $name, $phone, $address, $description, $user_id);
    }

    $stmt2->execute();
}
