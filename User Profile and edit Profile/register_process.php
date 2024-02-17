<?php
session_start(); // Start the session

// Database connection parameters
$db_host = 'localhost';
$db_name = 'userdatabase';
$db_user = 'postgres';
$db_password = 'root';

try {
    // Create a database connection
    $pdo = new PDO("pgsql:host=$db_host;dbname=$db_name", $db_user, $db_password);

    // Set PDO to throw exceptions on errors
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get form data
    $name = $_POST['name'];
    $age = $_POST['age'];
    $email = $_POST['email'];
    $dob = $_POST['dob'];
    $contact = $_POST['contact'];
    $password = $_POST['password']; // Retrieve the password

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check if the email already exists
    $sql_check_email = "SELECT COUNT(*) FROM UserDetails WHERE email = :email";
    $stmt = $pdo->prepare($sql_check_email);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        $message = "User with this email or mobile already exists.";
    } else {
        // Check if the file upload is set and no errors occurred
        
 if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] === UPLOAD_ERR_OK) {
    // Get the temporary file name
    $tmp_name = $_FILES['profileImage']['tmp_name'];
   
$profileImageData = file_get_contents($tmp_name);

} else {
   
    $profileImageData = null; // Set to null or handle appropriately
}

        // Insert the user's information into the database
        $sql_insert = "INSERT INTO UserDetails (name, age, email, dob, contact, profile_image, password) VALUES (:name, :age, :email, :dob, :contact, :profile_image, :password)";
        $stmt = $pdo->prepare($sql_insert);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':age', $age);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':dob', $dob);
        $stmt->bindParam(':contact', $contact);
        $stmt->bindParam(':profile_image', $profileImageData, PDO::PARAM_LOB);
        $stmt->bindParam(':password', $hashedPassword); // Store the hashed password
        $stmt->execute();
        $message = "Registration successful!";
    }

    // Set the message in a session variable
 $_SESSION['registration_message'] = $message;

   // Redirect back to Register.php
header("Location: Register.php");
    exit();

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
