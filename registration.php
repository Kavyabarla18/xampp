<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $servername = "localhost";
  $username = "root";
  $password = ""; // Default for XAMPP
  $dbname = "student_registration";

  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Helper for safe value
  function safeGet($conn, $key) {
    return isset($_POST[$key]) ? $conn->real_escape_string(trim($_POST[$key])) : '';
  }

  // Checkbox handling
  $cat_eamcet = isset($_POST['admit_eamcet']) ? 1 : 0;
  $cat_spot   = isset($_POST['admit_spot'])   ? 1 : 0;
  $cat_ecet   = isset($_POST['admit_ecet'])   ? 1 : 0;

  // Collect all fields
  $fields = [
    'ht_no'=>safeGet($conn, 'htno'),
    'student_name'=>safeGet($conn, 'student_name'),
    'branch'=>safeGet($conn, 'branch'),
    'dob'=>safeGet($conn, 'dob'),
    'aadhar'=>safeGet($conn, 'aadhar'),
    'mobile'=>safeGet($conn, 'mobile'),
    'email'=>safeGet($conn, 'email'),
    'ssc_marks'=>safeGet($conn, 'ssc_marks'),
    'ssc_school'=>safeGet($conn, 'ssc_school'),
    'inter_marks'=>safeGet($conn, 'inter_marks'),
    'inter_college'=>safeGet($conn, 'inter_college'),
    'eamcet_htno'=>safeGet($conn, 'eamcet_htno'),
    'eamcet_year'=>safeGet($conn, 'eamcet_year'),
    'eamcet_rank'=>safeGet($conn, 'eamcet_rank'),
    'ecet_htno'=>safeGet($conn, 'ecet_htno'),
    'ecet_year'=>safeGet($conn, 'ecet_year'),
    'ecet_rank'=>safeGet($conn, 'ecet_rank'),
    'nationality'=>safeGet($conn, 'nationality'),
    'caste'=>safeGet($conn, 'caste'),
    'state'=>safeGet($conn, 'state'),
    'fee'=>safeGet($conn, 'fee_scheme'),
    'father_qualification'=>safeGet($conn, 'father_qualification'),
    'father_occupation'=>safeGet($conn, 'father_occupation'),
    'father_income'=>safeGet($conn, 'father_income'),
    'father_landline'=>safeGet($conn, 'father_landline'),
    'father_mobile'=>safeGet($conn, 'father_mobile'),
    'father_email'=>safeGet($conn, 'father_email'),
    'mother_qualification'=>safeGet($conn, 'mother_qualification'),
    'mother_occupation'=>safeGet($conn, 'mother_occupation'),
    'mother_income'=>safeGet($conn, 'mother_income'),
    'mother_landline'=>safeGet($conn, 'mother_landline'),
    'mother_mobile'=>safeGet($conn, 'mother_mobile'),
    'mother_email'=>safeGet($conn, 'mother_email'),
    'permanent_address'=>safeGet($conn, 'permanent_address'),
    'contact_address'=>safeGet($conn, 'contact_address'),
    'hostel_type'=>safeGet($conn, 'hostel_type'),
    'hostel_name'=>safeGet($conn, 'hostel_name'),
    'hostel_room'=>safeGet($conn, 'hostel_room'),
    'guardian_name'=>safeGet($conn, 'guardian_name'),
    'guardian_address'=>safeGet($conn, 'guardian_address'),
    'guardian_phone'=>safeGet($conn, 'guardian_phone'),
    'guardian_mobile'=>safeGet($conn, 'guardian_mobile')
  ];

  $sql = "INSERT INTO students (
    ht_no, student_name, branch, dob, aadhar, mobile, email, ssc_marks, ssc_school, inter_marks, inter_college,
    eamcet_htno, eamcet_year, eamcet_rank,
    ecet_htno, ecet_year, ecet_rank,
    cat_eamcet, cat_spot, cat_ecet, nationality, caste, state, fee,
    father_qualification, father_occupation, father_income, father_landline, father_mobile, father_email,
    mother_qualification, mother_occupation, mother_income, mother_landline, mother_mobile, mother_email,
    permanent_address, contact_address, hostel_type, hostel_name, hostel_room,
    guardian_name, guardian_address, guardian_phone, guardian_mobile
  ) VALUES (
    '{$fields['ht_no']}', '{$fields['student_name']}', '{$fields['branch']}', '{$fields['dob']}', '{$fields['aadhar']}',
    '{$fields['mobile']}', '{$fields['email']}', '{$fields['ssc_marks']}', '{$fields['ssc_school']}', '{$fields['inter_marks']}',
    '{$fields['inter_college']}', '{$fields['eamcet_htno']}', '{$fields['eamcet_year']}', '{$fields['eamcet_rank']}',
    '{$fields['ecet_htno']}', '{$fields['ecet_year']}', '{$fields['ecet_rank']}',
    $cat_eamcet, $cat_spot, $cat_ecet, '{$fields['nationality']}', '{$fields['caste']}', '{$fields['state']}', '{$fields['fee']}',
    '{$fields['father_qualification']}', '{$fields['father_occupation']}', '{$fields['father_income']}', '{$fields['father_landline']}',
    '{$fields['father_mobile']}', '{$fields['father_email']}', '{$fields['mother_qualification']}', '{$fields['mother_occupation']}',
    '{$fields['mother_income']}', '{$fields['mother_landline']}', '{$fields['mother_mobile']}', '{$fields['mother_email']}',
    '{$fields['permanent_address']}', '{$fields['contact_address']}', '{$fields['hostel_type']}', '{$fields['hostel_name']}',
    '{$fields['hostel_room']}', '{$fields['guardian_name']}', '{$fields['guardian_address']}',
    '{$fields['guardian_phone']}', '{$fields['guardian_mobile']}'
  )";

  if ($conn->query($sql) === TRUE) {
    echo "<h2>Registration Successful!</h2>";
    echo "<p>Thank you, <b>{$fields['student_name']}</b>. Your data has been saved.</p>";
    echo "<p><a href='registration.html'>Go back to Form</a></p>";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
  $conn->close();

} else {
  header("Location: registration.html");
  exit();
}
?>