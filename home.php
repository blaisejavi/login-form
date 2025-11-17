<?php
session_start();

// Connect using mysqli_connect
$conn = mysqli_connect("localhost", "root", "", "test_db");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get form values
$email = $_POST['email'];
$password = $_POST['password'];

// Prepare SQL
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = mysqli_prepare($conn, $sql);

// Bind
mysqli_stmt_bind_param($stmt, "s", $email);

// Execute
mysqli_stmt_execute($stmt);

// Get result
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) === 1) {

    $user = mysqli_fetch_assoc($result);

    // Verify password (recommended)
    if (password_verify($password, $user['password'])) {

        $_SESSION['user'] = $user['email'];
        echo "Login successful! Welcome " . $_SESSION['user'];

    } else {
        echo "Incorrect password!";
    }

} else {
    echo "User not found!";
}

// Close
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
