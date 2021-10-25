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
        <meta name="author" content="Bryan Kim : bjk3yf, Paul Ok : pso3td">
        <meta name="description" content="Providing potential photoshoot locations to users">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
        <meta name="keywords" content="Photos, camera, location, suggestion, scenery">        
        <link rel="stylesheet" href="styles/main.css">
        <link rel="stylesheet" href="styles/gallery.css">

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
                  <a class="nav-item nav-link active" href="suggestions.php">Suggestions</a>
                <?php
                    if (isset($_SESSION["email"])) {
                        echo "<a class='nav-item nav-link active' href='updatePreference.php'>Update Preference</a>";
                        echo "<a class='nav-item nav-link active' href='profile.php'>Profile</a>";
                        echo "<a class='nav-item nav-link active' href='logout.php'>Log Out</a>";

                    }
                    else{
                        echo "<a class='nav-item nav-link active' href='login.php'>Log In</a>";
                    }
                ?>
                </div>
              </div>
            </nav> 
        </header>
        
        <!-- use of a jumbotron for our to describe the content of the gallery -->
        <div class=" jumbo rounded-3 mx-auto m-3 jumbotron jumbotron-fluid border">
            <div class="container">
              <h1 class="display-4 text-center">Locations</h1>
              <br>
              <p class="lead text-center">Find inspiration from what your peers have suggested!</p>
            </div>
        </div>

        <center>
        <!-- this section uses an array with the fetch all command that will return an array of the query
        we want and using it within a foreach loop -->
        <?php
        $stmt = $mysqli->query("select * from location;");
        $data_table = mysqli_fetch_all($stmt, MYSQLI_ASSOC);
        echo "<table><tr><td><center><b>Location Name</b></center></td><td><center><b>Address</b></center></td><td><center><b>In/Out</b></center></td><td><center><b>Time</b></center></td><td><center><b>Money</b></center></td><td><center><b>Activity</b></center></td></tr><br>";
        foreach ($data_table as $row) {
          echo "<tr><td><center>" . $row['name'] . "</center></td><td><center>" . $row['address'] . "</center></td><td><center>" . $row['indoor'] . "</center></td><td><center>" . $row['time'] . "</center></td><td><center>" . $row['money'] . "</center></td><td><center>" . $row['activity'] . "</center></td></tr><br>";
        }
        echo "</table>";
        ?>
        </center>

        <center>
          <a href="json_maker.php" class="btn btn-primary">Get a Json File</a>
        </center>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>
