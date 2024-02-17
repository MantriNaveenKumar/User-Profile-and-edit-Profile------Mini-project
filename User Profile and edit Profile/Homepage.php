<?php
                    session_start(); // Start a PHP session

                    if ($_SERVER["REQUEST_METHOD"] === "POST") {
                        // Retrieve the submitted username and password
                        $username = $_POST["username"];
                        $password = $_POST["password"];

                        // Establish a connection to your PostgreSQL database (replace with your database details)
                        $db = new PDO('pgsql:host=localhost;port=5432;dbname=userdatabase;user=postgres;password=root');

                        // Prepare a SQL query to fetch the user by username (email)
                        $query = $db->prepare("SELECT * FROM userdetails WHERE email = :username");
                        $query->bindParam(':username', $username);
                        $query->execute();
                        $user = $query->fetch();

                        // Check if a user with the provided username (email) exists and verify the password
                        if ($user && password_verify($password, $user['password'])) {
                            // Authentication successful

                            // Store the username in the session
                            $_SESSION["username"] = $username;

                            // Create a record in the usersession table with the current time (replace with your table and column names)
                            $query = $db->prepare("INSERT INTO usersession (session_created_time, username) VALUES (now(), :username)");
                            $query->bindParam(':username', $username);
                            $query->execute();

                            // Redirect to the profile editing page (replace with the actual URL)
                            header("Location: edit_profile.php");
                            exit();
                        } else {
                            // Authentication failed, set an error message
                            echo '<div class="alert alert-danger alert-dismissible fade show text-center" role="alert">Username or password is not matched</div>';
                        }
                    }
            ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

<style>
    body
        {
            background-image: url("https://tse2.mm.bing.net/th?id=OIP.TBUrA49M61yVCfKWVe4AqwHaE8&pid=Api&P=0&h=180");
        }
</style>

</head>
<body class="bg-warning">



<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center">Login</h5>
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="mt-3" >
                    <div class="mb-3">
    <label for="username" class="form-label text-secondary">Username</label>
    <input type="text" class="form-control bg-light" id="username" name="username" placeholder="Enter your username">
</div>
<div class="mb-3">
    <label for="password" class="form-label text-secondary">Password</label>
    <input type="password" class="form-control bg-light" id="password" name="password" placeholder="Enter your password">
</div>
                        <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-block mt-3 w-50">Login</button>
                        </div>
                        
                    </form>
                    <div class="text-center mt-5">
                        <p>New user? Click for registration</p>
                        <form action="register.php">
                            <button type="submit" class="btn btn-dark ">Signup</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
