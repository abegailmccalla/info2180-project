<?php
session_start();

$host = 'localhost';
$username = 'user';
$password = 'password123';
$dbname = 'dolphin_crm';

$firstName = $_POST["firstName"] ?? '';
$lastName = $_POST["lastName"] ?? '';
$email = $_POST["email"] ?? '';
$password_get = $_POST["password"] ?? '';
$role = $_POST["role"] ?? '';

$firstName_filter = filter_var($firstName, FILTER_SANITIZE_STRING);
$lastName_filter = filter_var($lastName, FILTER_SANITIZE_STRING);
$email_filter = filter_var($email, FILTER_SANITIZE_STRING);
$password_filter = filter_var($password_get, FILTER_SANITIZE_STRING);
$role_filter = filter_var($role, FILTER_SANITIZE_STRING);

$hashedPassword = password_hash($password_get, PASSWORD_DEFAULT);

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Failed to connect: " . $conn->connect_error);
}

// Only roles allowed Admin or Member
try{
    if (preg_match('/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).{8,}$/', $password)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    }
}catch{
    die("<script> alert('Password does not meet these requirements: password must have atleast one number, one letter, one capital letter and must be atleast 8 characters long.'); window.close(); window.open('../pages/new_user.html', '_blank'); </script>");
}



// } else {
//     //header("Location: ../php/dashboard.php");
    
//     //die("Password does not meet these requirements: password must have atleast one number, one letter, one capital letter and must be atleast 8 characters long.");
//     // Redirect to another page 
    
//     //exit; // Ensure no further code is executed
// }


// Only roles allowed Admin or Member
if ($role_filter !== 'Admin' && $role_filter !== 'Member') {
    die("Invalid role selected.");
}


$sql = "INSERT INTO Users (firstname, lastname, email, pwd, _role) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Error in the SQL query: " . $conn->error);
}

if (!$stmt->bind_param("sssss", $firstName_filter, $lastName_filter, $email_filter, $hashedPassword, $role_filter)) {
    die("Error binding parameters: " . $stmt->error);
}

if ($stmt->execute()) {
    echo "User Added Successfully!";
} else {
    echo "Error Adding User!";
}

$stmt->close();
$conn->close();
?>