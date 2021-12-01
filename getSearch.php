<?php
    include('database_connection.php');
    $connect = mysqli_connect("localhost", "bjk3yf", 'YtoTrLRymN8F', 'bjk3yf');
    $result = '';
    $sql = "select * from location where name like '%" . $_POST['search'] . "%'";
    $res = mysqli_query($connect, $sql);
    if(mysqli_num_rows($res) > 0) {
        $result .= '<h4 class="center">Search Result</h4>';
        $result .= '<div class="table-responsive">
                        <table class="table table bordered">
                            <tr>
                                <th>Name</th>
                                <th>Address</th>
                                <th>In/Out</th>
                                <th>Time</th>
                                <th>Money</th>
                                <th>Activity</th>
                            </tr>';
        while($row = mysqli_fetch_array($res)) {
            $result .= '
                <tr>
                    <td>' .$row["name"] . '</td>
                    <td>' .$row["address"] . '</td>
                    <td>' .$row["indoor"] . '</td>
                    <td>' .$row["time"] . '</td>
                    <td>' .$row["money"] . '</td>
                    <td>' .$row["activity"] . '</td>
                </tr>
            ';
        }
        echo $result;
    } else {
        echo "Data Not Found";
    }
?>