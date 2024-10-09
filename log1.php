<?php
session_start(); // Start the session

// Define the file to store user information
define('USER_DATA_FILE', 'users.txt');

// Function to check if the user already exists in the file
function user_exists($username, $password_hash) {
    if (file_exists(USER_DATA_FILE)) {
        $file = fopen(USER_DATA_FILE, "r");
        while (($line = fgets($file)) !== false) {
            list($stored_username, $stored_password_hash) = explode(':', trim($line));
            if ($stored_username == $username && $stored_password_hash == $password_hash) {
                fclose($file);
                return true; // User exists
            }
        }
        fclose($file);
    }
    return false; // User does not exist
}

// Function to check if the user is already logged in
function user_logged_in($username) {
    return isset($_SESSION['username']) && $_SESSION['username'] == $username;
}

// Function to save user info into the file
function save_user_info($username, $password_hash) {
    $file = fopen(USER_DATA_FILE, "a");
    fwrite($file, $username . ":" . $password_hash . "\n");
    fclose($file);
}

// If the user logs out
if (isset($_POST['logout'])) {
    session_unset(); // Clear session variables
    session_destroy(); // Destroy the session
    header("Location: log1.php"); // Reload the page after logout
    exit;
}

// Variable to hold login message (empty by default)
$login_message = '';

// Handle login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['logout'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hash the password
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Check if the user is already logged in
    if (user_logged_in($username)) {
        $login_message = '<p style="color:red;">You are already logged in with these credentials!</p>';
    } else {
        // Check if the user already exists
        if (user_exists($username, $password_hash)) {
            $login_message = '<p style="color:red;">User already exists with the same username and password!</p>';
        } else {
            // Save user info in file
            save_user_info($username, $password_hash);

            // Store the username and hashed password in session
            $_SESSION['username'] = $username;
            $_SESSION['password_hash'] = $password_hash;

            // Set login success message
            $login_message = '<h2>Welcome, ' . htmlspecialchars($username) . '!</h2>';
            $login_message .= '<p>Password Hash: ' . $password_hash . '</p>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
</head>
<body>
    <form method="post" action="">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required><br><br>

        <input type="submit" value="Login">
    </form>

    <!-- Logout button if the user is logged in -->
    <?php if (isset($_SESSION['username'])): ?>
        <form method="post" action="">
            <input type="submit" name="logout" value="Logout">
        </form>
    <?php endif; ?>

    <!-- Display login message and password hash if available -->
    <div>
        <?php
        if (!empty($login_message)) {
            echo $login_message;
        }
        ?>
    </div>
</body>
</html>
