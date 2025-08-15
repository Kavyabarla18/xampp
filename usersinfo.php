<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "student_registration";

    // Create DB connection
    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

    if ($conn->connect_error) {
        die("<h3 style='color:red;'>Database connection failed</h3>");
    }

    // Get and sanitize inputs
    $user = trim($_POST['username'] ?? '');
    $pass = trim($_POST['password'] ?? '');

    // Input validation
    if (!$user || !$pass || strlen($pass) < 6) {
        echo "<h3 style='color:red;'>Invalid username or password (minimum 6 characters).</h3>";
        echo "<a href='usersinfo.html'>Back to Register</a>";
        exit();
    }

    // Escape input to prevent SQL injection
    $user_sql = $conn->real_escape_string($user);

    // Check if username already exists
    $check_sql = "SELECT id FROM users WHERE username='$user_sql'";
    $result = $conn->query($check_sql);

    if ($result && $result->num_rows > 0) {
        echo "<h3 style='color:#ab2323;'>Username already taken!</h3>";
        echo "<a href='usersinfo.html'>Try another username</a>";
        $conn->close();
        exit();
    }

    // Hash password securely
    $hashed = password_hash($pass, PASSWORD_BCRYPT);

    // Insert into DB using prepared statement
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    if ($stmt === false) {
        echo "<h3 style='color:red;'>Server error. Please try again.</h3>";
        echo "<a href='usersinfo.html'>Back</a>";
        $conn->close();
        exit();
    }

    $stmt->bind_param("ss", $user, $hashed);

    if ($stmt->execute()) {
        echo "<h2 style='color: #227e36;'>Registration successful! You can <a href='usersinfo.html' style='color:#1976d2;'>login now</a>.</h2>";
    } else {
        echo "<h3 style='color:red;'>Registration failed (server error)!</h3>";
        echo "<a href='usersinfo.html'>Try Again</a>";
    }

    $stmt->close();
    $conn->close();

} else {
    // If not a POST request, redirect to registration form
    header("Location: usersinfo.html");
    exit();
}
?>
