<?php
session_start();

if (isset($_SESSION["username"])) {
    // User is authenticated; get the username from the session.
    $username = $_SESSION["username"];

    // Establish a connection to the PostgreSQL database
    $db = new PDO('pgsql:host=localhost;port=5432;dbname=userdatabase;user=postgres;password=root');

    // Prepare a SQL query to update the session_logout_time in the usersession table
    $query = $db->prepare("UPDATE usersession SET session_logout_time = now() WHERE username = :username AND session_logout_time IS NULL");
    $query->bindParam(':username', $username);
    $query->execute();
}

// Close the session
session_destroy();

// Redirect to the homepage
header("Location: Homepage.php");
exit();
?>
