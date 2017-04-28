<?php
    //$q = intval($_GET['q']);
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
 
        
    /*     
    $count = 0;
    
    $result = $mydb->query($query . "'%Land'");

    while($row = $result->fetch_assoc()) {
        $count += $row["qty"];
    }
    $result->data_seek(0);
    
    if ($count > 0) {
        $return .= "<div id = 'divtypetitle'>
                        <p>Lands(" . $count . ")</p>
                    </div>    
                   ";

        while($row = $result->fetch_assoc()) {
            $getImg = $mydb->query("SELECT card_image FROM cards WHERE card_id ='" . $row["card_id"] . "' limit 1");
            while($rowi = $getImg->fetch_assoc()) {      
            $return .= "<a id = '" . $row["card_name"] . "'
                        data-img='" . $rowi["card_image"] . "'>"  
                        . $row["qty"] . "x " . $row["card_name"] . "</a><br>";
            }
        
        }
    }

    $count = 0;

    $result = $mydb->query($query . "'%Creature'");

    while($row = $result->fetch_assoc()) {
        $count += $row["qty"];
    }
    if ($count > 0) {
        $result->data_seek(0);
        $return .= "<div id = 'divtypetitle'>
                        <p>Creatures(" . $count . ")</p>
                    </div>
                   ";

        while($row = $result->fetch_assoc()) {

            $getImg = $mydb->query("SELECT card_image FROM cards WHERE card_id ='" . $row["card_id"] . "'");
            while($rowi = $getImg->fetch_assoc()) {
            $return .= "<a id = '" . $row["card_name"] . "'
                        data-img='" . $rowi["card_image"] . "'>"
                        . $row["qty"] . "x " . $row["card_name"] . "</a><br>";
            }


        }
    }

    $count = 0;

    $result = $mydb->query($query . "'%Artifact'");

    while($row = $result->fetch_assoc()) {
        $count += $row["qty"];
    }
    if ($count > 0) {
        $result->data_seek(0);
        $return .= "<div id = 'divtypetitle'>
                        <p>Artifacts(" . $count . ")</p>
                    </div>
                   ";

        while($row = $result->fetch_assoc()) {

            $getImg = $mydb->query("SELECT card_image FROM cards WHERE card_id ='" . $row["card_id"] . "' limit 1");
            while($rowi = $getImg->fetch_assoc()) {
            $return .= "<a id = '" . $row["card_name"] . "'
                        data-img='" . $rowi["card_image"] . "'>"
                        . $row["qty"] . "x " . $row["card_name"] . "</a><br>";
            }


        }
    }

    $count = 0;

    $result = $mydb->query($query . "'%Instant'");

    while($row = $result->fetch_assoc()) {
        $count += $row["qty"];
    }
    if ($count > 0) {
        $result->data_seek(0);
        $return .= "<div id = 'divtypetitle'>
                        <p>Instants(" . $count . ")</p>
                    </div>
                   ";

        while($row = $result->fetch_assoc()) {

            $getImg = $mydb->query("SELECT card_image FROM cards WHERE card_id ='" . $row["card_id"] . "'");
            while($rowi = $getImg->fetch_assoc()) {
            $return .= "<a id = '" . $row["card_name"] . "'
                        data-img='" . $rowi["card_image"] . "'>"
                        . $row["qty"] . "x " . $row["card_name"] . "</a><br>";
            }


        }
    }     

    $count = 0;

    $result = $mydb->query($query . "'%Sorcery'");

    while($row = $result->fetch_assoc()) {
        $count += $row["qty"];
    }
    if ($count > 0) {
        $result->data_seek(0);
        $return .= "<div id = 'divtypetitle'>
                        <p>Sorcerys(" . $count . ")</p>
                    </div>
                   ";

        while($row = $result->fetch_assoc()) {

            $getImg = $mydb->query("SELECT card_image FROM cards WHERE card_id ='" . $row["card_id"] . "'");
            while($rowi = $getImg->fetch_assoc()) {
            $return .= "<a id = '" . $row["card_name"] . "'
                        data-img='" . $rowi["card_image"] . "'>"
                        . $row["qty"] . "x " . $row["card_name"] . "</a><br>";
            }


        }
    } 

    $count = 0;

    $result = $mydb->query($query . "'%Enchantment'");

    while($row = $result->fetch_assoc()) {
        $count += $row["qty"];
    }
    if ($count > 0) {
        $result->data_seek(0);
        $return .= "<div id = 'divtypetitle'>
                        <p>Enchantments(" . $count . ")</p>
                    </div>
                   ";

        while($row = $result->fetch_assoc()) {

            $getImg = $mydb->query("SELECT card_image FROM cards WHERE card_id ='" . $row["card_id"] . "'");
            while($rowi = $getImg->fetch_assoc()) {
            $return .= "<a id = '" . $row["card_name"] . "'
                        data-img='" . $rowi["card_image"] . "'>"
                        . $row["qty"] . "x " . $row["card_name"] . "</a><br>";
            }


        }
    }

    $count = 0;

    $result = $mydb->query($query . "'%Planeswalker'");

    while($row = $result->fetch_assoc()) {
        $count += $row["qty"];
    }
    if ($count > 0) {
        $result->data_seek(0);
        $return .= "<div id = 'divtypetitle'>
                        <p>Planeswalkers(" . $count . ")</p>
                    </div>
                   ";

        while($row = $result->fetch_assoc()) {

            $getImg = $mydb->query("SELECT card_image FROM cards WHERE card_id ='" . $row["card_id"] . "'");
            while($rowi = $getImg->fetch_assoc()) {
            $return .= "<a id = '" . $row["card_name"] . "'
                        data-img='" . $rowi["card_image"] . "'>"
                        . $row["qty"] . "x " . $row["card_name"] . "</a><br>";
            }


        }
    }

    $count = 0;

    $result = $mydb->query($query . "'%Conspiracy'");

    while($row = $result->fetch_assoc()) {
        $count += $row["qty"];
    }
    if ($count > 0) {
        $result->data_seek(0);
        $return .= "<div id = 'divtypetitle'>
                        <p>Conspiracies(" . $count . ")</p>
                    </div>
                   ";

        while($row = $result->fetch_assoc()) {

            $getImg = $mydb->query("SELECT card_image FROM cards WHERE card_id ='" . $row["card_id"] . "'");
            while($rowi = $getImg->fetch_assoc()) {
            $return .= "<a id = '" . $row["card_name"] . "'
                        data-img='" . $rowi["card_image"] . "'>"
                        . $row["qty"] . "x " . $row["card_name"] . "</a><br>";
            }


        }
    }
    */    
    echo $return;
?>
