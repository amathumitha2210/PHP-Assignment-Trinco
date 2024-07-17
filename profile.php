<?php
session_start();

if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

require 'conn.php';

if (isset($_POST['update_profile'])) {
    $email = $_SESSION['email'];
    $fullName = $_POST['fullName'];
    $city = $_POST['city'];

    $stmt = $pdo->prepare("UPDATE tbl_users SET fullName = ?, city = ? WHERE email = ?");
    $stmt->execute([$fullName, $city, $email]);

    $success = "Profile updated successfully!";
}

$stmt = $pdo->prepare("SELECT * FROM tbl_users WHERE email = ?");
$stmt->execute([$_SESSION['email']]);
$user = $stmt->fetch();
?>

<?php include 'header.php'; ?>

<div class="profile-form">
    <form method="POST" action="profile.php">
        <h2>Update Profile</h2>
        <?php if (isset($success)) echo "<p class='success'>$success</p>"; ?>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" readonly>
        <label for="fullName">Full Name:</label>
        <input type="text" id="fullName" name="fullName" value="<?php echo $user['fullName']; ?>" required>
        <label for="city">City:</label>
        <input type="text" id="city" name="city" value="<?php echo $user['city']; ?>" required>
        <button type="submit" name="update_profile">Update Profile</button>
    </form>
</div>

<?php include 'footer.php'; ?>
