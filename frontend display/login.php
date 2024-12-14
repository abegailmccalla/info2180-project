<?php
session_start();
// Database connection parameters
$host = 'localhost';
$db = 'dolphin_crm';
$user = 'user';
$pass = 'password123';
$charset = 'utf8mb4';
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

// Create PDO 
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database connection error: ' . $e->getMessage()]);
    exit;
}

// POST request
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

if (!$email || !$password) {
    echo json_encode(['success' => false, 'message' => 'Invalid email or password']);
    exit;
}

// Prepare SQL and fetch user
$stmt = $pdo->prepare("SELECT * FROM Users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();

if (!$user || !password_verify($password, $user['password'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid email or password']);
    exit;
}

// Start session and redirect to dashboard
session_start();
$_SESSION['user_id'] = $user['id'];
header('Location: dashboard.php');
exit;
?>