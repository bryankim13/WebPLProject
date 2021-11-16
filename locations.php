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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
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
        
        <!-- use of a jumbotron for our to describe the content of the gallery -->
        <div class=" jumbo rounded-3 mx-auto m-3 jumbotron jumbotron-fluid border">
            <div class="container">
              <h1 class="display-4 text-center">Locations</h1>
              <br>
              <p class="lead text-center">Find inspiration from what your peers have suggested!</p>
            </div>
        </div>

        <div class="container">
          <h2 class="center" style="text-align: center">Search for Location</h2>
          <div class="form-group">
            <div class="input-group">
              <input type="text" name="search_text" id="search_text" class="form-control" placeholder="Enter a location name">
            </div>
          </div>
          <div id="result"></div>
        </div>
        
        <script>
          $(document).ready(function() {
            $('#search_text').keyup(function() {
              var txt = $(this).val();
              if (txt != "") {
                $.ajax({
                  url:"getSearch.php",
                  method:"post",
                  data:{search:txt},
                  dataType:"text",
                  success:function(data)
                  {
                    $('#result').html(data);
                  }
                });
              } else {
                $('#result').html('');
                $.ajax({
                  url:"getSearch.php",
                  method:"post",
                  data:{search:txt},
                  dataType:"text",
                  success:function(data)
                  {
                    $('#result').html(data);
                  }
                });
              }
            });
          });
        </script>

        
        <div class="center">
        
        <!-- this section uses an array with the fetch all command that will return an array of the query
        we want and using it within a foreach loop -->
        <?php
        include('rand_query.php');
        $stmt = $mysqli->query("select * from location;");
        $data_table = mysqli_fetch_all($stmt, MYSQLI_ASSOC);
        echo "<table class='center'><tr><td><center><b>Location Name</b></center></td><td><center><b>Address</b></center></td><td><center><b>In/Out</b></center></td><td><center><b>Time</b></center></td><td><center><b>Money</b></center></td><td><center><b>Activity</b></center></td></tr><br>";
        echo "<script type='text/javascript'>
                var data_list = [];
              </script>";
        foreach ($data_table as $row) {
          echo "<script type='text/javascript'>
                  var obj = JSON.stringify({ name: '" . $row['name'] . "', address: '" . $row['address'] . "', inout: '" . $row['indoor'] . "', time: '" . $row['time'] . "', money: '" . $row['money'] . "', activity: '" . $row['activity'] . "'});
                  data_list.push(obj);
                </script>";
          echo "<tr><td><center>" . $row['name'] . "</center></td><td><center>" . $row['address'] . "</center></td><td><center>" . $row['indoor'] . "</center></td><td><center>" . $row['time'] . "</center></td><td><center>" . $row['money'] . "</center></td><td><center>" . $row['activity'] . "</center></td></tr><br>";
        }
        echo "</table>";
        ?>
        </div>
        <br>
        <div class="center" style="text-align: center">
          <a href="json_maker.php" class="btn btn-primary">Get a Json File</a>
      </div>
      <div class="center">
      
      <?php
        $rand_stmt = $mysqli->query("select * from location order by rand() limit 1");
        $rand_entry = mysqli_fetch_all($rand_stmt, MYSQLI_ASSOC);
        foreach ($rand_entry as $display) {
          echo"<script type='text/javascript'>
                var obj2 = JSON.stringify({ name: '" . $display['name'] . "', address: '" . $display['address'] . "', inout: '" . $display['indoor'] . "', time: '" . $display['time'] . "', money: '" . $display['money'] . "', activity: '" . $display['activity'] . "'});
              </script>"; 
          echo var_dump($display['name']);
        }
      ?>

      <script>
        function get_rand() {
          $(document).ready(function() {
            // $('#rand_loc').click(function (){
              $.ajax({
                url: 'rand_query.php',
                type: 'get',
                data: {placeData: rand_obj},
                success: function (data) {
                  var name = JSON.parse(rand_obj);
                  $('#places').append('<p style="text-align: center">Name: <b>' + name.name + '</b><br>Address: ' + name.address + '<br>In/Out: ' + name.inout + '<br>Time: ' + name.time + '<br>Money: ' + name.money + '<br>Activity: ' + name.activity + '</p><br>');
                },
                error: function (jqXhr, textStatus, errorMessage) {
                  $('#places').append('Error: ' + errorMessage);
                }
              // });
            });
          });
        }
        </script>
      <h2 style='text-align: center'>Want a random location?</h2>
      <div style='text-align: center'><input type='submit' onclick='get_rand()' value="Get Random Location"/></div>
      <p id='places' style='text-align: center'></p>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>
