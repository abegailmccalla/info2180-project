<?php
session_start();

function connectToDatabase()
{
    $servername = "localhost";
    $username = 'user';
    $password = 'password123';
    $dbname = "dolphin_crm";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

function fetchContacts($filter = "")
{
    $conn = connectToDatabase();

    $contacts = [];

    $sql = "SELECT id, title, firstname, lastname, email, company, _type FROM Contacts";

    if ($filter) {
        switch ($filter) {
            case 'Sales Leads':
                $sql .= " WHERE _type = 'Sales Lead'";
                break;
            case 'Support':
                $sql .= " WHERE _type = 'Support'";
                break;
            case 'Assigned to me':
                $user_id = $_SESSION['user_id'] ?? null;
                if ($user_id) {
                    $sql .= " WHERE assigned_to = '$user_id'";
                }
            break;
        }
    }

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $contacts[] = $row;
        }
    }

    $conn->close();

    return $contacts;
}

// Check if a filter is selected
$filter = isset($_GET['filter']) ? $_GET['filter'] : "";
$contacts = fetchContacts($filter);
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/dashboard.css">

    <title>Dolphin CRM Dashboard</title>

    <script>
        function addContact() {
        // Navigate to the contact page (contacts.html)
        window.location.assign('../pages/contacts.html');
        }

        const contacts = [
            { title: 'Mr', fullName: 'John Doe', email: 'john.doe@example.com', company: 'ABC Inc.', type: 'Sales Lead' },
            // List for Contacts
        ];

        function applyFilter() {
            var filter = document.getElementById('contactFilter').value;
            var url = 'dashboard.php?filter=' + filter;
            window.location.href = url;
        }

        function viewDetails(contactId) {
            window.location.href = 'contact_details.php?id=' + contactId;
        }

    </script>
</head>

<body>
    <header>
    <?php include('header.php');?>
    </header>

    <?php
    // Check if the session variable 'full_name' is set
    $fullName = isset($_SESSION['full_name']) ? $_SESSION['full_name'] : null;
    ?>

    

    <div id="contacts" action="">
    <div id="header-info">
    <?php if ($fullName): ?>
        <button class="add-contact-btn" onclick="addContact()">&#43; Add Contact</button>
    <?php endif; ?>
    <h1>Dashboard</h1></div>
    <div id="form-info">
    <header>
            <form method="post" action="">
                <label><i class="fa fa-filter" style="font-size:24px"></i><img src="../images/filter-icon.jpg" alt="Filter By Icon" style="width:20px">&nbsp;Filter By:</label>
                <button type="submit" name="filter" value="All Contacts">All</button>
                <button type="submit" name="filter" value="Sales Leads">Sales Leads</button>
                <button type="submit" name="filter" value="Support">Support</button>
                <button type="submit" name="filter" value="Assigned to me">Assigned to me</button>
            </form>
        </header>
    </div>
        <table>
            <thead>
                <th>Name</th>
                <th>Email</th>
                <th>Company</th>
                <th>Type</th>
                <th> </th>
            </thead>
            <tbody>
                <?php $filter = isset($_POST['filter']) ? $_POST['filter'] : null; ?>
                <?php $contacts = fetchContacts($filter); ?>
                <?php foreach ($contacts as $contact): ?>
                <tr>
                    <td>
                        <?php echo $contact['title'] . ' ' . $contact['firstname'] . ' ' . $contact['lastname']; ?>
                    </td>
                    <td>
                        <?php echo $contact['email']; ?>
                    </td>
                    <td>
                        <?php echo $contact['company']; ?>
                    </td>
                    <td>
                        <?php echo $contact['_type'];  ?>
                    </td>
                    <td>
                        <button type="button" class = "view-contact-btn" onclick="viewDetails(<?php echo $contact['id']; ?>)">View</button>
                    </td>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
    </div>
</body>
</html>