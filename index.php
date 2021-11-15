<?php
/** DATABASE SETUP **/
include('database_connection.php');
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Extra Error Printing
$mysqli = new mysqli($dbserver, $dbuser, $dbpass, $dbdatabase);
$user = null;

// Join session or start one
session_start();
?>
<!--
    link to website:
      Link to index.php https://cs4640.cs.virginia.edu/bjk3yf/project/ 
    sources: 
      https://www.w3schools.com/howto/howto_css_modal_images.asp
      https://css-tricks.com/creating-a-modal-image-gallery-with-bootstrap-components/  
      https://getbootstrap.com/docs/5.1/getting-started/introduction/ - for carousel, navbar, cards, etc.
      https://www.youtube.com/watch?v=1NiJcZrPHvA&ab_channel=TechWorldwithNana
      https://developer.mozilla.org/en-US/docs/Web/CSS/filter - blurring effect
      Javascript 
      https://www.w3schools.com/jsref/prop_node_childnodes.asp - for getting child names
      https://www.youtube.com/watch?v=wCsPAquMNVw&ab_channel=Webslesson 
      Stackoverflow
      https://www.w3schools.com/php/php_ajax_livesearch.asp
      https://www.cloudways.com/blog/live-search-php-mysql-ajax/
      https://www.w3schools.com/jquery/ajax_ajax.asp
      https://api.jquery.com/jquery.ajax/
    -->
    <!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1"> 
        <title>KaClik!</title>
        <meta name="author" content="Bryan Kim : bjk3yf worked on upload and profile, Paul Ok : pso3td worked on suggestion forms and gallery, everything else was done together">
        <meta name="description" content="Providing potential photoshoot locations to users">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
        <meta name="keywords" content="Photos, camera, location, suggestion, scenery">        
        <link rel="stylesheet" href="styles/main.css">
        <link rel="stylesheet" href="styles/home.css">

    </head>  
    <body>
    <header>
      <!-- Link to index.php https://cs4640.cs.virginia.edu/bjk3yf/project/ -->
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
        
        <!-- use of a jumbotron for our main header for our home page to grab the user's attention -->
        <div class=" jumbo rounded-3 mx-auto m-3 jumbotron jumbotron-fluid light-yellow border">
            <div class="container">
              <h1 class="display-4 text-center">KaClik!</h1>
              <?php
                    if (isset($_SESSION["email"])) {
                        echo "<p class='lead text-center'>Welcome " . $_SESSION["name"] . "</p>";
                    }
                    else{
                        echo "<p class='lead text-center'>Welcome!</p>";
                    }
                ?>
            </div>
        </div>
        <!-- A home image to show the mission statement of the site -->
        <div class = "homeImage container-fluid py-4 text-center rounded-3 border">
            <div class="homeText countainer-fluid py-4">
                <p>Find your next photoshoot location today!</p>
            </div>
        </div>

        
        <!-- use of multiple cards for better navigation purposes and cleaner organization of content -->
        <div class="container-fluid py-4">
            <div class="row shrink-pad">
                <!-- one section card for recommended locations -->
                <div class="col-sm">
                    <div class="card light-green">
                        <div class="card-body">
                            <h2 class="text-center">
                                Recommended Locations
                            </h2>
                            <p class="text-center">
                                This website provides a space for aspiring photographers to share ideas with one
                                another.  If you've found the perfect spot and idea.  Click the button below
                                to share your ideas to inspire other photographers.  Help each other out!
                            </p>
                            <p class="text-center"><a class="btn btn-primary" href="suggestions.php" role="button">Create Suggestion</a></p>
                        </div>
                    </div>
                </div>
                <!-- one section card for recently added photos -->
                <div class="col-sm">
                    <div class="card light-blue">
                        <div class="card-body">
                            <section>
                              <h2 class="text-center">
                                Recently Added Photos
                              </h2>
                                <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel" data-bs-interval="false">
                                    <div class="carousel-indicators">
                                      <?php
                                        $res = $mysqli->query("select * from picture limit 4");
                                        $index = 0;
                                        while ($data = $res->fetch_assoc()) {
                                          if ($index == 0) {
                                            echo "<button type=\"button\" data-bs-target=\"#carouselExampleCaptions\" data-bs-slide-to=\"{$index}\" class=\"active\" aria-current=\"true\" aria-label=\"Slide {$index}\"></button>";
                                          } else {
                                            echo "<button type=\"button\" data-bs-target=\"#carouselExampleCaptions\" data-bs-slide-to=\"{$index}\" aria-label=\"Slide {$index}\"></button>";
                                          }
                                          $index += 1;
                                        }
                                      ?>
                                      <!-- <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                      <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                      <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                      <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="3" aria-label="Slide 4"></button> -->
                                    </div>
                                    <div class="carousel-inner">
                                    <?php
                                        $res = $mysqli->query("select * from picture limit 4");
                                        $index = 0;
                                        while ($data = $res->fetch_assoc()) {
                                          if ($index == 0) {
                                            echo "<div class=\"carousel-item active\"><img src=\"images/{$data['img_dir']}\" class=\"d-block w-100 pic-dim\" alt=\"{$data['name']}\"></div>";
                                          } else {
                                            echo "<div class=\"carousel-item\"><img src=\"images/{$data['img_dir']}\" class=\"d-block w-100 pic-dim\" alt=\"{$data['name']}\"></div>";
                                          }
                                          $index += 1;
                                        }
                                      ?>
                                      <!-- <div class="carousel-item active">
                                        <img src="images/aesthetic.png" class="d-block w-100 pic-dim" alt="nature">
                                      </div>
                                      <div class="carousel-item">
                                        <img src="images/alley.jpg" class="d-block w-100 pic-dim" alt="alley">
                                      </div>
                                      <div class="carousel-item">
                                        <img src="images/city.jpg" class="d-block w-100 pic-dim" alt="city">
                                      </div>
                                      <div class="carousel-item">
                                        <img src="images/sign.jpg" class="d-block w-100 pic-dim" alt="sign">
                                      </div> -->
                                    </div>
                          
                          
                                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                      <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                      <span class="visually-hidden">Next</span>
                                    </button>
                                  </div>
                          </section>
                          <br>
                            <p class="text-center">
                                Want to view more pictures?  View our image gallery.
                            </p>
                            <p class="text-center"><a class="btn btn-primary" href="gallery.php" role="button">Gallery</a></p>
                        </div>
                    </div>
                </div>
                <!-- one section card for new locations that have been suggested -->
                <div class="col-sm">
                    <div class="card light-grey">
                        <div class="card-body">
                            <h2 class="text-center">
                                New Locations
                            </h2>
                            <p class="text-center">
                                In need of a fresh spot to capture a moment in time?  View these suggested locations
                                submitted by your peers to discover some hidden gem spots around Charlottesville.  We've listed
                                a few of the more popular locations here but click the button below to view all suggestions!
                            </p>
                            <!-- <table class="center"> -->
                            <?php
                              $stmt = $mysqli->query("select * from location;");
                              $data_table = mysqli_fetch_all($stmt, MYSQLI_ASSOC);
                              echo "<table class=\"center\"><tr class=\"text-center\"><td><center><b>Place</b></center></td><td><center><b>Address</b></center></td><td><center><b>Activity</b></center></td></tr><br>";
                              foreach ($data_table as $row) {
                                echo "<tr><td><center>" . $row['name'] . "</center></td><td><center>" . $row['address'] . "</center></td><td><center>" . $row['activity'] . "</center></td></tr><br>";
                              }
                              echo "</table>";
                            ?>
                                <!-- <tr class="text-center">
                                  <th>Location</th>
                                  <th>Category</th>
                                </tr>
                                <tr class="text-center">
                                  <td>Rotunda</td>
                                  <td>University</td>
                                </tr>
                                <tr class="text-center">
                                  <td>Carter's Mountain</td>
                                  <td>Nature</td>
                                </tr>
                                <tr class="text-center">
                                  <td>Scott's Stadium</td>
                                  <td>Sports</td>
                                </tr>
                                <tr class="text-center">
                                  <td>Downtown Mall</td>
                                  <td>Lifestyle</td>
                                </tr>
                                <tr class="text-center">
                                  <td>Ravens Roost Overlook</td>
                                  <td>Nature</td>
                                </tr>
                                <tr class="text-center">
                                  <td>The Corner</td>
                                  <td>Lifestyle</td>
                                </tr>
                            </table> -->
                            <br>
                            <p class="text-center"><a class="btn btn-primary" href="locations.php" role="button">Locations</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    </body>
</html>


