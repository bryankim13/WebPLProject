<?php
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

        <div class=" jumbo rounded-3 mx-auto m-3 jumbotron jumbotron-fluid light-yellow border">
            <div class="container">
              <h1 class="display-4 text-center">Json Readable File</h1>
              <p class="lead text-center">Show off the perfect spot to take a picture!</p>
            </div>
        </div>

        <?php
            $stmt = $mysqli->query("select * from location;");
            $data_table = mysqli_fetch_all($stmt, MYSQLI_ASSOC);
            $stmt2 = $mysqli->prepare("select indoor, time, money, activity from preference where uid = ?;");
            $stmt2->bind_param("i", $_SESSION['uid']);
            if (!$stmt2->execute()) {
                $message = "Error getting uid";
            }
            else {
                $res = $stmt2->get_result();
                $data = $res->fetch_all(MYSQLI_ASSOC);
            }
            $best = 0;
            $best_name = "";
            echo "<div style='text-align: center'><h4>Scroll to the bottom to see which places best matches your preferences!</h4></div>";
            foreach ($data_table as $row) {
                $temp = 0;
                $file = json_encode($row);
                $obj = json_decode($file);
                // echo "<h3>JSON Format</h3>";
                // echo var_dump($obj);
                echo "<script type='text/javascript'>
                        var data_obj = {name: '" . $obj->{'name'} . "', address: '" . $obj->{'address'} . "', inout: '" . $obj->{'indoor'} . "', time: '" . $obj->{'time'} . "', money: '" . $obj->{'money'} . "', activity: '" . $obj->{'activity'} . "'};
                      </script>";
                echo "<div style='text-align: center'><br><h3><script type='text/javascript'>document.write(data_obj.name)</script> <br></h3>";
                echo  "<b>Address:</b> <script type='text/javascript'>document.write(data_obj.address)</script> <br>";
                echo  "<b>In/Out:</b> <script type='text/javascript'>document.write(data_obj.inout)</script> <br>";
                echo  "<b>Time:</b> <script type='text/javascript'>document.write(data_obj.time)</script> <br>";
                echo  "<b>Money:</b> <script type='text/javascript'>document.write(data_obj.money)</script> <br>";
                echo  "<b>Activity:</b> <script type='text/javascript'>document.write(data_obj.activity)</script> <br></div>";
                if ($data[0]['indoor'] === $obj->{'indoor'}) {
                    $temp = $temp + 1;
                }
                if ($data[0]['time'] === $obj->{'time'}) {
                    $temp = $temp + 1;
                }
                if ($data[0]['money'] === $obj->{'money'}) {
                    $temp = $temp + 1;
                } 
                if ($data[0]['activity'] === $obj->{'activity'}) {
                    $temp = $temp + 1;
                }
                if ($temp >= $best) {
                    $best = $temp;
                    $best_name = $obj->{'name'};
                }
            }
            echo "<div style='text-align: center'><h4>Based on your preferences, <b>" . $best_name . "</b> would be a good place to check out.</h4></div>";
        ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>