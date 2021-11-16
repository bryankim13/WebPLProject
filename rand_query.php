<?php
        include('database_connection.php');
        $connect = mysqli_connect("localhost", "bjk3yf", 'YtoTrLRymN8F', 'bjk3yf');
        $rand_stmt = $mysqli->query("select * from location order by rand() limit 1");
        $rand_entry = mysqli_fetch_all($rand_stmt, MYSQLI_ASSOC);
        echo "this page";
        foreach ($rand_entry as $display) {
          echo"<script type='text/javascript'>
                var obj2 = JSON.stringify({ name: '" . $display['name'] . "', address: '" . $display['address'] . "', inout: '" . $display['indoor'] . "', time: '" . $display['time'] . "', money: '" . $display['money'] . "', activity: '" . $display['activity'] . "'});
                console.log(obj);
              </script>"; 
          echo var_dump($display['name']);
        }
      ?>