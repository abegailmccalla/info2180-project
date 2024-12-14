<?php
//header('Content-Type: application/json');

//session_start();
// Database connection parameters
// $host = 'localhost';
// $db = 'dolphin_crm';
// $user = 'user';
// $pass = 'password123';
// $charset = 'utf8mb4';
// $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
// $options = [
//     PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
//     PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
//     PDO::ATTR_EMULATE_PREPARES => false,
// ];

// Create PDO 
// try {
//     $pdo = new PDO($dsn, $user, $pass);
// } catch (\PDOException $e) {
//     echo json_encode(['success' => false, 'message' => 'Database connection error: ' . $e->getMessage()]);
//     exit;
// }

// POST request
// $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
// $password = $_POST['password'] ?? '';  // Use $_POST directly to get the raw password

// if (!$email || !$password) {
//     echo json_encode(['success' => false, 'message' => 'No email or password']);
//     exit;
// }

// Prepare SQL and fetch user
// $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
// $stmt->execute([$email]);
// $user = $stmt->fetch();

// if (!$user || !password_verify($password, $user['password'])) {
//     echo json_encode(['success' => false, 'message' => 'Invalid email or password']);
//     exit;
// }


// Start session and redirect to dashboard
// session_start();
// $_SESSION['user_id'] = $user['id'];
// header('Location: dashboard.php');
// echo json_encode(['success' => true, 'message' => 'Login successful']);
// exit;






// Ensure clean output
ob_clean();

// Set headers
header('Content-Type: application/json');
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

// Database connection parameters
$host = 'localhost';
$db = 'dolphin_crm';
$user = 'user';
$pass = 'password123';
$charset = 'utf8mb4';

// Detailed error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

try {
    // Create PDO connection
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    $pdo = new PDO($dsn, $user, $pass, $options);

    // Get email and password from POST
    $email = isset($_POST['email']) ? trim($_POST['email']) : null;
    $password = isset($_POST['password']) ? trim($_POST['password']) : null;

    // Validate inputs
    if (empty($email) || empty($password)) {
        echo json_encode([
            'success' => false, 
            'message' => 'Email and password are required'
        ]);
        exit;
    }

    // Prepare and execute query
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // Verify credentials
    if (!$user || !password_verify($password, $user['password'])) {
        echo json_encode([
            'success' => false, 
            'message' => 'Invalid email or password'
        ]);
        exit;
    }

    // Successful login
    session_start();
    $_SESSION['user_id'] = $user['id'];
    
    echo json_encode([
        'success' => true, 
        'message' => 'Login successful'
    ]);
    exit;

} catch (PDOException $e) {
    // Log the full error (in a production environment, log to file)
    error_log($e->getMessage());
    
    // Send generic error to client
    echo json_encode([
        'success' => false, 
        'message' => 'Database error occurred'
    ]);
    exit;
} catch (Exception $e) {
    // Catch any other unexpected errors
    error_log($e->getMessage());
    
    echo json_encode([
        'success' => false, 
        'message' => 'An unexpected error occurred'
    ]);
    exit;
}