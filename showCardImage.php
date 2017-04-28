<?php
    $q = $_REQUEST['q'];

    $servername = "45.56.114.155";
    $username = "db_user";
    $password = "0Y8RusveQ5n1rGfwixtI";

    $mydb = new mysqli($servername, $username, $password, "db");

    if ($mydb->connect_error) {
       echo("Connection failed <br>");
       exit();
    }

    $query = "SELECT card_image FROM cards WHERE card_id =" . $q;
    
    $result = $mydb->query($query);
    
    $return = "";
    while($row = $result->fetch_assoc()) {
        $return .= "<img id = 'cardImg' src='" . $row["card_image"] . "' width = '200'>";
    }

    echo $return;
?>
