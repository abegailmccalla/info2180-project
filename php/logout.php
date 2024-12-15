<!DOCTYPE html>
<html lang="en">
    <?php
// Start the session
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to the login page or any other desired location
?>
 <script>
        window.location.assign('../pages/login.html');
    </script>
</html>

