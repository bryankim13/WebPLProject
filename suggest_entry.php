<?php
/** DATABASE SETUP **/
include('database_connection.php');
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Extra Error Printing
$mysqli = new mysqli($dbserver, $dbuser, $dbpass, $dbdatabase);
$user = null;
// Join session or start one
session_start();

$stmt = $mysqli->prepare("select uid from user where email = ?;");
$stmt->bind_param("s", $_SESSION["email"]);
if (!$stmt->execute()) {
  $message = "Error getting uid";
} else {
  $res = $stmt->get_result();
  $data = $res->fetch_all(MYSQLI_ASSOC);
  if (!empty($data)) {
    $suggest = $mysqli->prepare("insert into location (name, address, uid, indoor, time, money, activity) values (?, ?, ?, ?, ?, ?, ?)");
    $suggest->bind_param("ssissss", $_GET["place"], $_GET["add"], $data[0]["uid"], $_GET["inout"], $_GET["time"], $_GET["money"], $_GET["activity"]);
    if(!$suggest->execute()) {
      $error_msg = "Failed to insert data";
    }
    header("LocationL index.php");
  }
  else {
    $error_msg2 = "Failed to get uid";
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
        <meta name="author" content="Bryan Kim : bjk3yf, Paul Ok : pso3td">
        <meta name="description" content="Providing potential photoshoot locations to users">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
        <meta name="keywords" content="Photos, camera, location, suggestion, scenery">        
        <link rel="stylesheet" href="styles/main.css">
        <link rel="stylesheet" href="styles/suggest.css">
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
                  <?php
                    if (isset($_SESSION["email"])) {
                        echo "<a class='nav-item nav-link active' href='locations.php'>Locations</a>";
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
        <p class="text-center">
        <?php
            echo "Nice!  Your submission has been posted! <br>";
            
            echo "Your location was <b>" . $_GET["place"] . "</b>, the address is <b>" . $_GET["add"] . "</b> and the activity is <b>" . $_GET["activity"] . "</b> <br>";
            echo "You've also specified that this is <b>" . $_GET["inout"] . "</b>, can be done during the <b>" . $_GET["time"] . "</b>, and is <b>" . $_GET["money"] . "</b>."
        ?>
        </p>

        <p class="text-center"><a class="btn btn-primary" href="suggestions.php" role="button">Create Another Suggestion</a></p>
        <p class="text-center"><a class="btn btn-primary" href="index.php" role="button">Home</a></p>
    </body>
</html>