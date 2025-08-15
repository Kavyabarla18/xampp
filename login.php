<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli("localhost", "root", "", "student_registration");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (!$username || !$password) {
        echo "All fields required. <a href='usersinfo.html'>Try again</a>";
        exit();
    }

    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($hashed);
        $stmt->fetch();

        if (password_verify($password, $hashed)) {
            echo "<h2>Login successful. Welcome, $username!</h2>";
        } else {
            echo "Incorrect password. <a href='usersinfo.html'>Try again</a>";
        }
    } else {
        echo "User not found. <a href='usersinfo.html'>Try again</a>";
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: usersinfo.html");
    exit();
}
?>
