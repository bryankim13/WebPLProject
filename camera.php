<?php
/** DATABASE SETUP **/
include('database_connection.php');
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Extra Error Printing
$mysqli = new mysqli($dbserver, $dbuser, $dbpass, $dbdatabase);
$user = null;

// Join session or start one
session_start();
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

        <div class=" jumbo rounded-3 mx-auto m-3 jumbotron jumbotron-fluid border" style="background-color: lightblue" id="mainbanner">
            <div class="container">
              <h1 class="display-4 text-center">Camera Builds</h1>
              <p style="text-align: center">Come see all the different camera builds other users have to start saving for your next camera!</p>
            </div>
        </div>
        <br>
        <br>
        <?php
            $stmt = $mysqli->query("select * from build");
            $data_table = mysqli_fetch_all($stmt, MYSQLI_ASSOC);
            echo "<table class='table table-warning table-hover'><tr><td><center><b>Brand</b></td></td><td><center><b>Model</b></center></td><td><center><b>Lens</b></center></td><td><center><b>Megapixels</b></center></td><td><center><b>Description</b></center></td><tr>";
            foreach ($data_table as $row) {
            echo "<tr><td><center>" . $row['brand'] . "</center></td><td><center>" . $row['model'] . "</center></td><td><center>" . $row['lens'] . "</center></td><td><center>" . $row['megaPix'] . "</center></td><td><center>" . $row['description'] . "</center></td></tr>";
            }
            echo "</table>";
        ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    </body>
</html>