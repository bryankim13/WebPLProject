<?php

/** DATABASE SETUP **/
include('database_connection.php');
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Extra Error Printing
$mysqli = new mysqli($dbserver, $dbuser, $dbpass, $dbdatabase);
$user = null;

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
        <link rel="stylesheet" href="styles/suggest.css">
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

        <div class=" jumbo rounded-3 mx-auto m-3 jumbotron jumbotron-fluid light-yellow border">
            <div class="container">
              <h1 class="display-4 text-center">Location Suggestions</h1>
              <p class="lead text-center">Show off the perfect spot to take a picture!</p>
            </div>
        </div>

        <div>
            <form action="suggest_entry.php" method="get">
                <div class="container-fluid px-5">
                <div class="mx-6">
                    <label for="location" class="form-label">Location Name</label>
                    <input type="text" class="form-control" id="location" name="place" required>
                </div>
                <div class="mx-6">
                    <label for="address" class="form-label"> Location Address</label>
                    <input type="text" class="form-control" id="address" name="add" required>
                </div>
                <div class="mx-6">
                    <label for="inout" class="form-label">Indoor or Outdoor</label>
                    <select id="inout" name="inout" class="form-select" required size="2">
                        <option value="indoor" selected>Indoor</option>
                        <option value="outdoor">Outdoor</option>
                    </select>
                </div>
                <div class="mx-6">
                    <label for="time" class="form-label">Time of Day</label>
                    <select id="time" name="time" class="form-select" required size="3">
                        <option value="morning" selected>Morning</option>
                        <option value="noon">Afternoon</option>
                        <option value="night">Night</option>
                    </select>
                </div>
                <div class="mx-6">
                    <label for="money" class="form-label">Money Spent</label>
                    <select id="money" name="money" class="form-select" required size="4">
                        <option value="free" selected>Free</option>
                        <option value="cheap">Cheap</option>
                        <option value="avg">Average</option>
                        <option value="expensive">Expensive</option>
                    </select>
                </div>
                <div class="mx-6">
                    <label for="activity" class="form-label">Activity</label>
                    <select id="activity" name="activity" class="form-select" required size="5">
                        <option value="food" selected>Food</option>
                        <option value="landscape">Landscape</option>
                        <option value="events">Events</option>
                        <option value="pfp">Profile Pictures</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <button type="submit" id="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
        <script>
            function locCheck(){
                var locName = document.getElementById("location");
                var addy = document.getElementById("address");
                var subButton = document.getElementById("submit");


                if(locName.value.length < 1){
                    locName.classList.add("is-invalid");
                    if(addy.value.length < 1){
                        addy.classList.add("is-invalid");
                    }
                    subButton.disabled = true;
                } else{
                    locName.classList.remove("is-invalid");
                    if(addy.value.length > 0){
                        addy.classList.remove("is-invalid");
                        subButton.disabled = false;
                    }
                    else{
                        addy.classList.add("is-invalid");
                        subButton.disabled = true;

                    }
                }
            }
            document.getElementById("location").addEventListener("keyup", locCheck);
            document.getElementById("address").addEventListener("keyup", locCheck);

        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>