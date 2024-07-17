<?php
session_start();

if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

require 'conn.php';

if (isset($_POST['change_password'])) {
    $email = $_SESSION['email'];
    $oldPassword = $_POST['oldPassword'];
    $newPassword = $_POST['newPassword'];

    $stmt = $pdo->prepare("SELECT password FROM tbl_users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($oldPassword, $user['password'])) {
        $newPasswordHash = password_hash($newPassword, PASSWORD_BCRYPT);
        $stmt = $pdo->prepare("UPDATE tbl_users SET password = ? WHERE email = ?");
        $stmt->execute([$newPasswordHash, $email]);

        $success = "Password changed successfully!";
    } else {
        $error = "Old password is incorrect!";
    }
}
?>

<?php include 'header.php'; ?>

<div class="account-form">
    <form method="POST" action="account.php">
        <h2>Change Password</h2>
        <?php if (isset($success)) echo "<p class='success'>$success</p>"; ?>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <label for="oldPassword">Old Password:</label>
        <input type="password" id="oldPassword" name="oldPassword" required>
        <label for="newPassword">New Password:</label>
        <input type="password" id="newPassword" name="newPassword" required>
        <button type="submit" name="change_password">Change Password</button>
    </form>
</div>

<?php include 'footer.php'; ?>
