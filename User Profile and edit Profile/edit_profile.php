<?php
session_start();

if (!isset($_SESSION["username"])) {
    // If the user is not authenticated, redirect to the login page.
    header("Location: login.php");
    exit();
}

// User is authenticated; get the username from the session.
$username = $_SESSION["username"];

// Establish a connection to the PostgreSQL database
$db = new PDO('pgsql:host=localhost;port=5432;dbname=userdatabase;user=postgres;password=root');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // User submitted the form, update the profile in the database.
  // Validate and sanitize the user inputs before updating the database.

    $name = $_POST["name"];
    $age = $_POST["age"];
    $email = $_POST["email"];
    $dob = $_POST["dob"];
    $contact = $_POST["contact"];

    // Prepare an SQL query to update the user's profile
    $query = $db->prepare("UPDATE userdetails SET name = :name, age = :age, email = :email, dob = :dob, contact = :contact WHERE email = :username");
    $query->bindParam(':name', $name);
    $query->bindParam(':age', $age);
    $query->bindParam(':email', $email);
    $query->bindParam(':dob', $dob);
    $query->bindParam(':contact', $contact);
   $query->bindParam(':username', $username);

    if ($query->execute()) {
        // Profile updated successfully
        echo  '<div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
            Changes saved successfully.
            
        </div>
    </div>';
    

        // Use JavaScript to reload the page after 2 seconds
        echo '<script>
        setTimeout(function() {
            location.href = "edit_profile.php"; // Replace with the URL you want to navigate to
        }, 2000);
        
              </script>';

    } else {
        // Handle the update error
        echo "Error updating profile.";
    }
}

// Fetch the user's current profile details
$query = $db->prepare("SELECT * FROM userdetails WHERE email = :username");
$query->bindParam(':username', $username);
$query->execute();
$user = $query->fetch();
$name = $user['name'];
$age = $user['age'];
$email = $user['email'];
$dob = $user['dob'];
$contact = $user['contact'];
?>

<!DOCTYPE html>
<html>
<head>
    <!-- Include your CSS and JS libraries here -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <style>
        body
        {
            background-image: url("https://tse4.mm.bing.net/th?id=OIP.RxfjL6YRjSwrArxkfhAu8AHaEK&pid=Api&P=0&h=180");
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-white bg-dark p-3">
        <a class="navbar-brand ms-5 text-white" href="#">Welcome, <?php echo $name; ?></a>
        <form class="form-inline ms-auto" method="post" action="logout.php">
            <button type="submit" class="btn btn-danger me-2">Logout</button>
        </form>
    </nav>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card bg-success text-light">
                    <div class="card-body">
                        <h5 class="card-title text-center">Edit Profile</h5>
                        <form method="post" action="edit_profile.php">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="age" class="form-label">Age</label>
                                <input type="text" class="form-control" id="age" name="age" value="<?php echo $age; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="dob" class="form-label">DOB</label>
                                <input type="text" class="form-control" id="dob" name="dob" value="<?php echo $dob; ?>" placeholder="dd-mm-yyyy" required>
                            </div>
                            <div class="mb-3">
                                <label for="contact" class="form-label">Contact No</label>
                                <input type="text" class="form-control" id="contact" name="contact" value="<?php echo $contact; ?>" required>
                            </div>
                            <div class="text-center">
                            <button type="submit" class="btn btn-warning mt-3">Save Profile</button>
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
