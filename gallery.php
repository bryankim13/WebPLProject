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
        <link rel="stylesheet" href="styles/gallery.css">

    </head>  
    <body>
        <header>
            <nav class="navbar navbar-expand-lg navbar-light bg-light border">
              <a class="navbar-brand px-3 mx-auto" href="index.html">KaClik!</a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse justify-content-between"  id="navbarNavAltMarkup">
                <div class="navbar-nav mx-auto">
                  <a class="nav-item nav-link active" href="gallery.html">Gallery</a>
                  <a class="nav-item nav-link active" href="locations.html">Locations</a>
                  <a class="nav-item nav-link active" href="suggestions.html">Suggestions</a>
                </div>
              </div>
            </nav> 
        </header>
        
        <!-- use of a jumbotron for our to describe the content of the gallery -->
        <div class=" jumbo rounded-3 mx-auto m-3 jumbotron jumbotron-fluid border">
            <div class="container">
              <h1 class="display-4 text-center">The Gallery</h1>
              <br>
              <p class="lead text-center">Come and see what others have taken around Charllotesville!</p>
            </div>
        </div>

        <!-- used a row to list out the pictures and to flow nicely on the screen -->
        <div class="container">
            <div class="row" id="gallery" data-bs-toggle="modal" data-bs-target="#exampleModal">
                <?php
                  $res = $mysqli->query("select * from picture");
                  $index = 0;
                  while ($data = $res->fetch_assoc()) {
                    echo "<div class=\"col-12 col-sm-6 col-lg-3\"><img class=\"w-100 rounded-3\" src=\"images/{$data['img_dir']}\" data-bs-target=\"#carouselExample\" data-bs-slide-to=\"{$index}\"</div>";
                    $index += 1;
                  }
                ?>
            </div> 

            <!-- Modal from bootstrap to use as a popup for users to interact with. 
                Provides better view for what people have taken and uploaded.
                As of right now, we did not incorporate a database, so we manually added the
                pictures. 
            -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                              <?php
                                $res2 = $mysqli->query("select * from picture");
                                while ($data2 = $res2->fetch_assoc()) {
                                  echo "<div class=\"carousel-item active\"><img class=\"d-block w-100\" src=\"images/{$data2['img_dir']}\" alt=\"{$data2['name']}\"></div>";
                                }
                              ?>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
        </div>


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>


