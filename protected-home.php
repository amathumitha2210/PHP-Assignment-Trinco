<?php
session_start();

if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

include 'header.php';
?>

<div class="protected-home">
    <h2>Welcome, <?php echo $_SESSION['email']; ?>!</h2>
    <ul>
        <li><a href="profile.php">Update Profile</a></li>
        <li><a href="account.php">Change Password</a></li>
        <li><a href="holiday.php">View Public Holidays</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</div>

<?php include 'footer.php'; ?>
