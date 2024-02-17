

<?php
session_start(); // Start the session

// Check if the registration message is set
if (isset($_SESSION['registration_message'])) {
    $message = $_SESSION['registration_message'];

    // Display the message
    if (strpos($message, 'successful') !== false) {
        echo '<div class="alert alert-success alert-dismissible fade show text-center" role="alert">' . $message . '</div>';

        // If the message indicates success, redirect to Homepage.php after a 3-second delay
        header("refresh:4;url=Homepage.php");
    } else {
        echo '<div class="alert alert-danger alert-dismissible fade show text-center" role="alert">' . $message . '</div>';
    }

    // Unset the session variable to clear the message
    unset($_SESSION['registration_message']);
}

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<style>
    
body {
  position: relative;
  background-image: url("https://tse4.mm.bing.net/th?id=OIP.RxfjL6YRjSwrArxkfhAu8AHaEK&pid=Api&P=0&h=180");
  background-size: cover;
  background-repeat: no-repeat;
  background-attachment: fixed;
}

</style>

</head>
<body>




<div class="container mt-2 " >
    <div class="row justify-content-center">
        <div class="col-md-5 ">
            <div class="card border-0" >
                <div class="card-body bg-secondary text-light ">
                    <h5 class="card-title text-center">Registration</h5>
                    <form id="registrationForm" method="post" action="register_process.php" enctype="multipart/form-data" >
                        <div class="mb-3 ">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                            <div id="nameError" class="text-danger"></div>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label ">Create Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            <div id="passwordError" class="text-danger"></div>
                        </div>

                        <div class="mb-3">
                            <label for="age" class="form-label">Age</label>
                            <input type="text" class="form-control" id="age" name="age" required>
                            <div id="ageError" class="text-danger"></div>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                            <div id="emailError" class="text-danger"></div>
                        </div>
                        <div class="mb-3">
                            <label for="dob" class="form-label">DOB</label>
                            <input type="text" class="form-control" id="dob" name="dob" placeholder="dd-mm-yyyy" required>
                            <div id="dobError" class="text-danger"></div>
                        </div>
                        <div class="mb-3">
                            <label for="contact" class="form-label">Contact No</label>
                            <input type="text" class="form-control" id="contact" name="contact" required>
                            <div id="contactError" class="text-danger"></div>
                        </div>
                        <div class="mb-3">
                            <label for="profileImage" class="form-label">Profile Image</label>
                            <input type="file" class="form-control" id="profileImage" name="profileImage" required>
                            <div id="profileImageError" class="text-danger"></div>
                        </div>
                       <!-- <button type="submit" class="btn btn-primary btn-block w-50 mt-3 ms-5">Register</button> -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary mt-2 ">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

  

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#registrationForm').submit(function(event) {
        var isValid = true;
        
        // Reset previous error messages
        $('.text-danger').text('');

        
       // Validate Name
var nameValue = $('#name').val().trim();
if (!/^[A-Za-z\s]+$/.test(nameValue)) {
    $('#nameError').text('Name should only contain alphabets and spaces.');
    isValid = false;
}

// Validate Password
var passwordValue = $('#password').val();
        if (passwordValue.length < 6) {
            $('#passwordError').text('Password should be at least 6 characters long.');
            isValid = false;
        }

        // Validate Age
        var ageValue = $('#age').val().trim();
        if (!/^\d+$/.test(ageValue)) {
            $('#ageError').text('Age should only contain numbers.');
            isValid = false;
        }

        // Validate Email
        var emailValue = $('#email').val().trim();
        if (!/^\S+@\S+\.\S+$/.test(emailValue)) {
            $('#emailError').text('Please enter a valid email address.');
            isValid = false;
        }

        // Validate DOB
        var dobValue = $('#dob').val().trim();
        if (!/^\d{2}-\d{2}-\d{4}$/.test(dobValue)) {
            $('#dobError').text('Date format must be (dd-mm-yyyy).');
            isValid = false;
        }

        // Validate Contact
        var contactValue = $('#contact').val().trim();
        if (!/^\d{10}$/.test(contactValue)) {
            $('#contactError').text('Contact number should consist of 10 digits.');
            isValid = false;
        }

        // Validate Profile Image (Assuming you want to check file type)
        var profileImageValue = $('#profileImage').val().trim();
        if (!/\.(png|jpg|jpeg)$/i.test(profileImageValue)) {
            $('#profileImageError').text('Allowed file types: PNG, JPG, and JPEG.');
            isValid = false;
        }

        if (!isValid) {
            event.preventDefault(); // Prevent form submission
        }
    });
});
</script>
</body>
</html>
