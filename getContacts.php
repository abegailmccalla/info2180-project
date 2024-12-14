<?php 

// Database credentials
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'root');
define('DB_NAME', 'dolphin_crm');

/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME,3307);

// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

session_start();
$filterType = isset($_GET['filter']) ? $_GET['filter'] : 'all';

$sql = "SELECT title, firstname, lastname, email, company, type FROM Contacts";

if ($filterType == 'Sales Leads') {
    $sql .= " WHERE type = 'Sales Lead'";
} elseif ($filterType == 'Support') {
    $sql .= " WHERE type = 'Support'";
} elseif ($filterType == 'Assigned to me') {
    $userId = $_SESSION['id'];
    $sql .= " WHERE assigned_to = {$userId}";
}

echo '<table cellspacing="0">
        <thead>
          <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Company</th>
            <th>Type</th>
            <th></th>
          </tr>
        </thead>
        <tbody>';

if($result = mysqli_query($link, $sql)){
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_array($result)){
          $typeClass = ($row['type'] == 'SUPPORT') ? 'support' : 'sales-lead';
            echo "<tr>";
                echo "<td class='name-highlight'>".$row['title'].' ' . $row['firstname'] . " " . $row['lastname'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['company'] . "</td>";
                echo "<td><p class='" . $typeClass . "'>" . $row['type'] . "</p></td>";
                echo "<td><a class='defer-details' id='" . $row['email'] . "' href='contactDetails.php'>View</a></td>";
            echo "</tr>";
        }
        mysqli_free_result($result);
    } else{
        echo "<tr><td colspan='4'>No contacts found.</td></tr>";
    }
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}

echo '</tbody></table>';
?>