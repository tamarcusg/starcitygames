<?php  
    $count = 0;

    $result = $mydb->query($query . "'%" . $type . "'");

    while($row = $result->fetch_assoc()) {
        $count += $row["qty"];
    }
    $result->data_seek(0);

    if ($count > 0) {
        $return .= "<div id = 'divtypetitle'>
                        <p>" . $type . "s(" . $count . ")</p>
                    </div>
                   ";

        while($row = $result->fetch_assoc()) {
            $getImg = $mydb->query("SELECT card_image FROM cards WHERE card_id ='" . $row["card_id"] . "'");
            while($rowi = $getImg->fetch_assoc()) {
            $return .= "<a id = '" . $row["card_name"] . "' class = 'card'
                        data-img='" . $rowi["card_image"] . "'>"
                        . $row["qty"] . "x " . $row["card_name"] . "</a><br>";
            }

        
        }
    }
    
?>

