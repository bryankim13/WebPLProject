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
    $pattern = "/^[a-zA-Z\d\-_~]*[a-zA-Z\d.~\-_]@[a-zA-Z\d.-].[a-zA-Z\d.-]*$/";
    if (!preg_match($pattern, $_POST["email"])) {
        $error_msg2 = "Enter a valid email";
    }
    else {
        $insert = $mysqli->prepare("insert into user (name, email, password, role) values (?, ?, ?, ?);");
        $insert->bind_param("ssss", $_POST["name"], $_POST["email"], $hash, $_POST["role"]);
        if (!$insert->execute()) {
            $error_msg = "Error creating new user";
            } 
        // Save user information into the session to use later
        $_SESSION["name"] = $_POST["name"];
        $_SESSION["email"] = $_POST["email"];
        header("Location: setPreferences.php");
    }
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1"> 
        <title>KaClik!</title>
        <meta name="author" content="Bryan Kim : bjk3yf worked on gallery page and home page, Paul Ok : pso3td worked on suggestion page and home page">
        <meta name="description" content="Providing potential photoshoot locations to users">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
        <meta name="keywords" content="Photos, camera, location, suggestion, scenery">        
        <link rel="stylesheet" href="styles/main.css">
        <link rel="stylesheet" href="styles/home.css">

    </head>  
    <body>
    <header>
            <nav class="navbar navbar-expand-lg navbar-light bg-light border">
              <a class="navbar-brand px-3 mx-auto" href="index.php">KaClik!</a>
              <a class="navbar-brand px-3 mx-auto" href="upload.php">Upload</a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse justify-content-between"  id="navbarNavAltMarkup">
                <div class="navbar-nav mx-auto">
                  <a class="nav-item nav-link active" href="gallery.php">Gallery</a>
                  <a class="nav-item nav-link active" href="locations.php">Locations</a>
                  <?php
                    if (isset($_SESSION["email"])) {
                        echo "<a class='nav-item nav-link active' href='suggestions.php'>Suggestions</a>";
                        echo "<a class='nav-item nav-link active' href='updatePreference.php'>Update Preference</a>";
                        echo "<a class='nav-item nav-link active' href='profile.php'>Profile</a>";
                        echo "<a class='nav-item nav-link active' href='logout.php'>Log Out</a>";

                    }
                    else{
                        echo "<a class='nav-item nav-link active' href='login.php'>Log In</a>";
                        echo "<a class='nav-item nav-link active' href='signup.php'>Sign Up</a>";
                    }
                ?>
                </div>
              </div>
            </nav> 
        </header>
        <div class="row justify-content-center">
                <div class="col-4">
                <?php
                    if (!empty($error_msg)) {
                        echo "<div class='alert alert-danger'>$error_msg</div>";
                    }
                ?>
                <form action="signup.php" method="post">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required/>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required/>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required/>
                    </div>
                    <input type="hidden" id="role" name="role" value="user">
                    <div class="text-center">                
                    <button type="submit" class="btn btn-primary">Create Account</button>
                    <a href="login.php" class="btn btn-primary">Have an Account? Sign in</a>
                    </div>
                </form>
                </div>
            </div>
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    </body>
</html>