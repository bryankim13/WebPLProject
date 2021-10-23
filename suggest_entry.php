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
              <a class="navbar-brand px-3 mx-auto" href="index.html">KaClik!</a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse justify-content-between"  id="navbarNavAltMarkup">
                <div class="navbar-nav mx-auto">
                  <a class="nav-item nav-link active" href="gallery.html">Gallery</span></a>
                  <a class="nav-item nav-link active" href="locations.html">Locations</a>
                  <a class="nav-item nav-link active" href="suggestions.php">Suggestions</a>
                </div>
              </div>
            </nav> 
        </header>

        <p class="text-center">
        <?php
            echo "Nice!  Your submission has been posted! \n";
            
            echo "Your location was " . $_GET["location"] . ", the address is " . $_GET["address"] . " and the activity is " . $_GET["activity"] . "<br>";
            echo "You've also specified that this is a ." . $_GET["inout"] . ", can be done during the " . $_GET["time"] . ", and is " . $_GET["money"] . "."
        ?>
        </p>

        <p class="text-center"><a class="btn btn-primary" href="suggestions.html" role="button">Create Another Suggestion</a></p>
        <p class="text-center"><a class="btn btn-primary" href="index.html" role="button">Home</a></p>
    </body>
</html>