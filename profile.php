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
        <div class="container justify-content-center">
            <h1 style="font-size:45px;">Your Profile</h1>
            <div class="m-3 flex text-center">
                <h2>Information: </h2>
                    <div id="personalId" style="visibility:hidden;">
                        <?php
                            echo "<p>Name: ".$_SESSION['name'] . "</p>";
                            echo "<p>Email: ".$_SESSION['email'] . "</p>";
                        ?>    
                    </div>
                <h2>Preferences</h2>
                <div id="profPref" style="visibility:hidden;">
                    <?php
                        $stmt = $mysqli->prepare("select * from preference where uid = ?;");
                        $stmt->bind_param("i", $_SESSION["uid"]);
                        if (!$stmt->execute()) {
                            $message = "Error getting preferences";
                        }
                        else{
                            $res = $stmt->get_result();
                            $data = $res->fetch_all(MYSQLI_ASSOC);
                            echo "<p>Location Type: ".$data[0]['indoor'] . "</p>";
                            echo "<p>Time of Day: ".$data[0]['time'] . "</p>";
                            echo "<p>Cost: ".$data[0]['money'] . "</p>";
                            echo "<p>Activity: ".$data[0]['activity'] . "</p>";
                        }
                    ?>  
                </div>
                <button id="persButt" class="btn btn-primary">Toggle your privacy</button>
            </div>
        </div>
        <script>
            function hideProfile(){
                var persId = document.getElementById("personalId");
                var profPref = document.getElementById("profPref");

                if(persId.style.visibility == "hidden"){
                    persId.style.visibility = "visible";
                    profPref.style.visibility = "visible";

                }
                else{
                    persId.style.visibility = "hidden";
                    profPref.style.visibility = "hidden";

                }
            }
            document.getElementById("persButt").addEventListener("click", hideProfile);
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    </body>
</html>