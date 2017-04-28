<html>
    <head>
        <meta charset="utf-8">
        <title>StarCityGames.com Web Developer Test</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src = "starcitygames.js"></script>
        <link rel = "stylesheet" href = "starcitygames.css">
    </head>
    <body>
        <?php
            $servername = "45.56.114.155";
            $username = "db_user";
            $password = "0Y8RusveQ5n1rGfwixtI";

            $mydb = new mysqli($servername, $username, $password, "db");

            if ($mydb->connect_error) {
                echo("Connection failed <br>");
                exit();
            }
            /*
            else {
                echo("Connection passed <br>");
            }
            */
            
            //mysql_select_db("db_user", $mydb);
            
            $result = $mydb->query("SELECT * FROM decks WHERE 1");
            
            $decks = array();

            $i = 0;

            while($row = $result->fetch_assoc()) {
                $decks[$i] = $row["deck_name"];
                $i += 1;    
            }

            $length = $i + 1;
            $i = 0;


            $select = "";

            for ($i; $i < $length; $i++) {
                $select .= "<option value = '". $decks[$i] ."'>". $decks[$i] . " </option>";
            }
            
             
            
            echo("<table>
                      <tr>
                          <td><select id = 'drpdwn' name = 'selectdeck'>
                                  <option selected = 'selected' value = 'Select a Deck'>Select a Deck</option> " .
                                  $select .
                              "</select>
                          </td>
                          <td>
                              <button type = 'button' id = 'hand'>New Hand</button>
                          </td>
                          <td>
                              <button type = 'button' id = 'draw'>Draw Card</button>
                          </td>
                      <tr>
                  </table>
                  <br>
            ");


        ?>
        <fieldset id = "fieldsetdecklist">
            <legend>Deck List</legend>
            <div id = "divdecklist">
            </div>
        </fieldset>
        <fieldset id = "fieldsethand">
            <legend>Hand</legend>
            <div id = "divhand">
            </div>
        </fieldset>
        <fieldset id = "fieldsetdraw">
            <legend>Draw</legend>
            <div id = "divdraw">
            </div>
        </fieldset>
            
    </body>

</html>


