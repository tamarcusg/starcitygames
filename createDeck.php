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

    $deck;

    $query = $mydb->query("SELECT card_id, qty FROM decks_to_cards WHERE deck_id = 
                           (
                               SELECT deck_id FROM decks WHERE deck_name = '" . $q . "'
                           )
                           ORDER BY RAND()");

    while($row = $query->fetch_assoc()) {
        for ($i = 0; $i < $row["qty"]; $i++) {
            $deck .= $row["card_id"] . " ";
        }
    }

    echo $deck;
?>
