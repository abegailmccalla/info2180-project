<?php
// Database connection parameters
$host = 'localhost'; // Database host
$db = 'dolphin_crm'; // Database name
$user = 'user'; // Database username
$pass = 'password123'; // Database password
$charset = 'utf8mb4';
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

// Create PDO instance
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database connection error: ' . $e->getMessage()]);
    exit;
}

// Prepare SQL to fetch all users
$stmt = $pdo->prepare("SELECT * FROM Users");
$stmt->execute();
$users = $stmt->fetchAll();

// Check if the current user is an admin
session_start();
$userId = $_SESSION['user_id'] ?? null;
$stmt = $pdo->prepare("SELECT role FROM Users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch();

if ($user && $user['role'] === 'Admin') {
    // Display the list of users
    ?>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Created</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user) { ?>
                <tr>
                    <td><?php echo $user['firstname'] . ' ' . $user['lastname']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                    <td><?php echo $user['role']; ?></td>
                    <td><?php echo date('Y-m-d H:i:s', strtotime($user['created_at'])); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <?php
} else {
    echo "You are not authorized to view the list of users.";
}
?>