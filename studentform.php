<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "student_registration";

  // Connect to DB
  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

  function safe($conn, $name) {
    return $conn->real_escape_string(trim($_POST[$name]??''));
  }

  $htno = safe($conn,'htno');
  $student_name = safe($conn,'student_name');
  $branch = safe($conn,'branch');
  $dob = safe($conn,'dob');
  $aadhar = safe($conn,'aadhar');
  $mobile = safe($conn,'mobile');
  $email = safe($conn,'email');
  $ssc_marks = safe($conn,'ssc_marks');
  $ssc_school = safe($conn,'ssc_school');
  $inter_marks = safe($conn,'inter_marks');
  $inter_college = safe($conn,'inter_college');
  $nationality = safe($conn,'nationality');
  $caste = safe($conn,'caste');
  $state = safe($conn,'state');
  $father_name = safe($conn,'father_name');
  $father_mobile = safe($conn,'father_mobile');
  $mother_name = safe($conn,'mother_name');
  $mother_mobile = safe($conn,'mother_mobile');
  $address = safe($conn,'address');

  $sql = "INSERT INTO studentsdetails (
    htno, student_name, branch, dob, aadhar, mobile, email, ssc_marks, ssc_school,
    inter_marks, inter_college, nationality, caste, state, father_name, father_mobile,
    mother_name, mother_mobile, address
  ) VALUES (
    '$htno', '$student_name', '$branch', '$dob', '$aadhar', '$mobile', '$email', '$ssc_marks', '$ssc_school',
    '$inter_marks', '$inter_college', '$nationality', '$caste', '$state', '$father_name', '$father_mobile',
    '$mother_name', '$mother_mobile', '$address'
  )";

  if ($conn->query($sql) === TRUE) {
    echo "<h2>Registration Successful!</h2>";
    echo "<p>Thank you, <b>" . htmlspecialchars($student_name) . "</b>, your data has been saved.</p>";
    echo '<p><a href="studentform.html">Submit another response</a></p>';
  } else {
    echo "Error: " . $conn->error;
  }
  $conn->close();
} else {
  header("Location: studentform.html");
  exit();
}
?>