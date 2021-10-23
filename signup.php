<?php
/** DATABASE SETUP **/
include('database_connection.php');
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Extra Error Printing
$mysqli = new mysqli($dbserver, $dbuser, $dbpass, $dbdatabase);
//$mysqli = new mysqli("localhost", "root", "", "example"); // XAMPP

$error_msg = "";

// Logout component -- this might be best in a separate
// logout.php page that handles the logout and shows the
// user their score.  Once the session is destroyed, we will
// need to recreate (re-start) a session inorder to move
// forward with login.  We should therefore move the next two lines
// into a logout page.
session_start();
session_destroy();
// end of logout component

// Join the session or start a new one
session_start();

// user was not found, create an account
            // NEVER store passwords into the database, use a secure hash instead:
if (isset($_POST["email"])) { /// validate the email coming in
    $hash = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $insert = $mysqli->prepare("insert into user (name, email, password) values (?, ?, ?);");
    $insert->bind_param("sss", $_POST["name"], $_POST["email"], $hash);
    if (!$insert->execute()) {
        $error_msg = "Error creating new user";
        } 
    // Save user information into the session to use later
    $_SESSION["name"] = $_POST["name"];
    $_SESSION["email"] = $_POST["email"];
    header("Location: setup.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">  
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="your name">
        <meta name="description" content="include some description about your page">  
        <title>Trivia Game Login</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous"> 
    </head>
    <body>
        <div class="container" style="margin-top: 15px;">
            <div class="row col-xs-8">
                <h1>CS4640 Television Trivia Game - Get Started</h1>
                <p> Welcome to our trivia game!  To get started, login below or enter a new username and password to create an account</p>
            </div>
            <div class="row justify-content-center">
                <div class="col-4">
                <?php
                    if (!empty($error_msg)) {
                        echo "<div class='alert alert-danger'>$error_msg</div>";
                    }
                ?>
                <form action="login.php" method="post">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email"/>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name"/>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password"/>
                    </div>
                    <div class="text-center">                
                    <button type="submit" class="btn btn-primary">Create Account</button>
                    <a href="login.php" class="btn btn-primary">Have an Account? Sign in</a>
                    </div>
                </form>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    </body>
</html>