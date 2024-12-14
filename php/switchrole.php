<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contactId'])) {
    $contactId = $_POST['contactId'];
    $newRole = switchRole($contactId);

    // Return the new role to update the button text
    echo $newRole;

} else {
    echo 'Invalid request';
}

function switchRole($contactId) {
    // Add your logic here to update the role in the database
    $conn = connectToDatabase();

    // Fetch the current role
    $currentRoleQuery = "SELECT _type FROM Contacts WHERE id = ?";
    $statement = $conn->prepare($currentRoleQuery);
    $statement->bind_param('i', $contactId);
    $statement->execute();
    $result = $statement->get_result();
    $row = $result->fetch_assoc();
    $currentRole = $row['_type'];

    // Update the role based on your logic
    $newRole = '';

    switch ($currentRole) {
        case 'Sales Lead':
            $newRole = 'Support';
            break;
        case 'Support':
            $newRole = 'Sales Lead';
            break;
        default:
            $newRole = 'Unknown Role';
    }

    // Update the _type field in the Contacts table
    $updateRoleQuery = "UPDATE Contacts SET _type = ? WHERE id = ?";
    $updateStatement = $conn->prepare($updateRoleQuery);
    $updateStatement->bind_param('si', $newRole, $contactId);
    $updateStatement->execute();

    // Close the database connection
    $conn->close();

    return $newRole;
}

function connectToDatabase()
{
    $servername = "localhost";
    $username = "proj2_user";
    $password = "groupbest1234";
    $dbname = "dolphin_crm";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

?>
