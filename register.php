<?php
session_start(); 
require 'conn.php'; 


$email = '';
$fullName = '';
$city = '';
$error = '';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $email = trim($_POST['email']);
    $fullName = trim($_POST['fullName']);
    $city = trim($_POST['city']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirmPassword']);

   
    if (empty($email) || empty($fullName) || empty($city) || empty($password) || empty($confirmPassword)) {
        $error = "All fields are required.";
    } elseif ($password !== $confirmPassword) {
        $error = "Passwords do not match.";
    } else {
        
        $stmt = $pdo->prepare("SELECT * FROM tbl_users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user) {
            $error = "Email already exists. Please choose a different one.";
        } else {
            
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

           
            $stmt = $pdo->prepare("INSERT INTO tbl_users (email, password, fullName, city) VALUES (?, ?, ?, ?)");
            if ($stmt->execute([$email, $hashedPassword, $fullName, $city])) {
                
                $_SESSION['email'] = $email; 
                header('Location: protected-home.php');
                exit();
            } else {
                $error = "Registration failed. Please try again later.";
            }
        }
    }
}
?>


    <?php include 'header.php'; ?>
    <div class="container">
        <h2>Register</h2>
        <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
            
            <label for="fullName">Full Name:</label>
            <input type="text" id="fullName" name="fullName" value="<?php echo htmlspecialchars($fullName); ?>" required>
            
            <label for="city">City:</label>
            <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($city); ?>" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <label for="confirmPassword">Confirm Password:</label>
            <input type="password" id="confirmPassword" name="confirmPassword" required>
            
            <button type="submit">Register</button>
        </form>
    </div>
    <?php include 'footer.php'; ?>

