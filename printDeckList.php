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

    
    $query = "SELECT cards.card_name, cards.card_type, decks_to_cards.qty, cards.card_id From cards 
                            INNER JOIN decks_to_cards 
                            ON decks_to_cards.card_id = cards.card_id 
                            AND decks_to_cards.deck_id = (
                                SELECT decks.deck_id 
                                FROM decks  
                            WHERE decks.deck_name ='" . $q . "')
                            AND cards.card_type LIKE ";
    
    $formatquery = $mydb->query("SELECT deck_format FROM decks WHERE deck_name ='" . $q . "'");
    $format;
    while($row = $formatquery->fetch_assoc()) {
        $format = $row["deck_format"];
    }
    
    $return = "<div id = 'divdecktitle'>
                   <p>Deck Name: " . $q . "</p>
               </div>
               <div id = 'divformat'>
                   <p>Format: " . $format . "</p> 
               </div>
              ";

    $type = "Land";
    include("getCards.php");
    $type = "Creature";
    include("getCards.php");
    $type = "Planeswalker";
    include("getCards.php");
    $type = "Artifact";
    include("getCards.php");
    $type = "Instant";
    include("getCards.php");
    $type = "Sorcery";
    include("getCards.php");
    $type = "Enchantment";
    include("getCards.php");
    $type = "Conspiracy";
    include("getCards.php");
 
        
    echo $return;
?>
