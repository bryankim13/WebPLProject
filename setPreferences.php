<?php
/** DATABASE SETUP **/
include('database_connection.php');
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Extra Error Printing
$mysqli = new mysqli($dbserver, $dbuser, $dbpass, $dbdatabase);
$user = null;
// Join session or start one
session_start();
if (isset($_POST['indoor'])) { /// validate the email coming in
$stmt = $mysqli->prepare("select * from user where email = ?;");
$stmt->bind_param("s", $_SESSION["email"]);
if (!$stmt->execute()) {
        $message = "Error getting uid";
    } 
else { 
    $res = $stmt->get_result();
    $data = $res->fetch_all(MYSQLI_ASSOC);
    if (!empty($data)) {    
        $_SESSION["uid"] = $data[0]["uid"];
        $insert = $mysqli->prepare("insert into preference (uid, indoor, time,money,activity) values (?, ?, ?, ?, ?);");
        $insert->bind_param("issss", $_SESSION["uid"], $_POST["indoor"], $_POST["time"],$_POST["cost"],$_POST["activity"]); 
        if(!$insert->execute()){
            $message = "Error inserting data";
        }
        header("Location: index.php");
    } 
    else {
        $message = "<div class='alert alert-danger'>Could not get UID!</div>";
    }
}
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
              <?php
              if (isset($_SESSION["email"])) {
                echo "<a class=\"navbar-brand px-3 mx-auto\" href=\"upload.php\">Upload</a>";
              }
              ?>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse justify-content-between"  id="navbarNavAltMarkup">
                <div class="navbar-nav mx-auto">
                  <a class="nav-item nav-link active" href="gallery.php">Gallery</a>
                  <a class="nav-item nav-link active" href="locations.php">Locations</a>
                  <a class='nav-item nav-link active' href='camera.php'>Camera Builds</a>
                  <?php
                    if (isset($_SESSION["email"])) {
                        echo "<a class='nav-item nav-link active' href='suggestions.php'>Suggestions</a>";
                        echo "<a class='nav-item nav-link active' href='updatePreference.php'>Update Preference</a>";
                        echo "<a class='nav-item nav-link active' href='profile.php'>Profile</a>";
                        echo "<a class='nav-item nav-link active' href='logout.php'>Log Out</a>";

                    }
                    else{
                        echo "<a class='nav-item nav-link active' href='angComp'>Make a Build</a>";
                        echo "<a class='nav-item nav-link active' href='login.php'>Log In</a>";
                        echo "<a class='nav-item nav-link active' href='signup.php'>Sign Up</a>";
                    }
                ?>
                </div>
              </div>
            </nav> 
        </header>
        
        <div class="container" style="margin-top: 15px;">
            <div class="row col-xs-8 justify-content-center">
                <h1>KaClik</h1>
                <p>Let the clicks begin</p>
            </div>
            <div class="row justify-content-center">
                <div class="col-4">
                <?php
                    if (!empty($message)) {
                        echo "<div class='alert alert-danger'>$message</div>";
                    }
                ?>
                <form action="setPreferences.php" method="post">
                    <div class="mb-3">
                    <label for="indoor">Indoors or Outdoors</label>
                    <select class="form-control" id="indoor" name="indoor" required="required" size="2">
                        <option>Indoors</option>
                        <option>Outdoors</option>
                    </select>
                    </div>
                    <div class="mb-3">
                    <label for="time">Time</label>
                    <select class="form-control" id="time" name="time" required="required" size="2">
                        <option>Day</option>
                        <option>Night</option>
                    </select>
                    </div>
                    <div class="mb-3">
                    <label for="cost">Cost</label>
                    <select class="form-control" id="cost" name="cost" required="required" size="4">
                        <option>Free</option>
                        <option>Cheap</option>
                        <option>Moderate</option>
                        <option>Expensive</option>
                    </select>
                    </div>
                    <div class="mb-3">
                    <label for="activity">Activity</label>
                    <select class="form-control" id="activity" name="activity" required="required" size="5">
                        <option>Food</option>
                        <option>Landscape</option>
                        <option>Events</option>
                        <option>Profile Pictures</option>
                        <option>Other</option>
                    </select>
                    </div>
                    <div class="text-center">                
                    <button type="submit" class="btn btn-primary">Submit</button>
                    </div>                
                </form>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    </body>
</html>