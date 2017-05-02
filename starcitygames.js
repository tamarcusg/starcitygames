var currentDeckName; //name of the selected deck 
var deck; //holds an array of card_id's
var savedDeck = new Array(); //holds original contents of the deck variable


$(document).ready(function() {
    //disables buttons until a deck has been selected
    document.getElementById("hand").disabled = true;
    document.getElementById("draw").disabled = true;

    /*
     * Checks the dropdown to see if a deck has been selected.
     * If so, it calls createDeckList and createDeck and saves the selection into savedDeck
     * then enables both buttons.
     */
    $("#drpdwn").change(function() {
        if ($("#drpdwn :selected").text() != "Select a Deck") {
            createDeckList();
            createDeck();
            for (var i = 0; i < deck.length; i++) {
                savedDeck[i] = deck[i];
            }
            document.getElementById("hand").disabled = false;
        }
    });

    /*
     * Checks to see if the "New Hand" button is clicked.
     * If so, load back in the savedDeck into the deck, shuffles the deck then calls drawCard 
     * seven times.
     */
    $(document).on("click", "#hand", function() {
        document.getElementById("hand").disabled = true;
        for (var i = 0; i < deck.length; i++) {
            deck[i] = savedDeck[i];
        }
        shuffle(deck);
        $("#divhand").empty();
        $("#divdraw").empty();
        for (var i = 0; i < 7; i++) {
            drawCard(true);
        }
        document.getElementById("draw").disabled = false;
        setTimeout(function(){document.getElementById("hand").disabled = false;}, 300); 
    });
    
    /*
     * Checks to see if "Draw Hand" button is clicked.
     * If so, call drawCard.
     */
    $(document).on("click", "#draw", function() {
        drawCard(false);
    });

    
});

/*
 * Grabs a single card_id from the deck array and pushes the array values down then puts -1 into
 * the last index of the deck array. 
 * If the deck is empty, it alerts the user and stops drawing.
 * The card_id is then passed in a call to showCardImage.php, which displays the card_image.
 * 
 * param->tohand determines if the card_image is added to the hand div or the draw div.
 */
function drawCard(tohand) {
    var emptyFlag = false;
    var newCard;
    if (deck[0] != -1) {
        if (deck[0] != "") {
            newCard = deck[0];
        }
        else {
            newCard = deck[1];
            emptyFlag = true;
        }
        for (var i = 0; i < deck.length; i++) {
            if (emptyFlag) {
                if (i != deck.length-1 && i != deck.length-2) {
                    deck[i] = deck[i+2];
                }
                
            } else {
                if (i != deck.length-1) {
                    deck[i] = deck[i+1];
                }
            }
        }
        deck[deck.length-1] = -1;
        if (emptyFlag) {
            deck[deck.length-2] = -1;
        }
    } else {
        alert("DECK IS EMPTY");
        throw new Error('Empty deck');
    }
    
    $.ajax({
        url: "showCardImage.php?q=" + newCard,
        type: "GET",
        success: function(data) {
            if (tohand) {
                $("#divhand").append(data);
            } else {
                $("#divdraw").append(data);
                $("#divdraw").scrollLeft($("#divdraw").scrollLeft() + 300);

            }
        }
    });
  
    console.log(savedDeck);
    console.log(newCard);
    console.log(deck);

}

/*
 * Passes the name of the selected deck in a call to printDeckList.php, which appends the decklist to 
 * the decklist div.
 * Once the decklist is displayed, it shows an image of a given card on the list on hover.
 */
function createDeckList() {
    
    currentDeckName = $("#drpdwn :selected").text();
    $.ajax({
        url: "printDeckList.php?q=" + currentDeckName,
        type: "GET",
        success: function(response) {
            $("#divdecklist").empty();
            $("#divdecklist").append(response);
             
            $('.card').popover({
                placement: 'right',
                trigger: 'hover',
                delay: {show: 100, hide:100},
                html: true,
                content: function(){
                    
                    return '<img src="'+ $(this).data('img') + '" />';}
                
            });
        }
    });
    
}

/*
 * Passes the name of the selected deck in a call to createDeck.php, which creates an array of
 * card_id's and stores it in the deck variable. 
 * The deck is also shuffled and stored in the savedDeck array.
 */
function createDeck() {
    var temp;
    $.ajax({
        url: "createDeck.php?q=" + currentDeckName,
        type: "GET",
        async: false,
        success: function(response) {
            deck = response.split(" ");
            shuffle(deck);
        }
    });
    for (var i = 0; i < deck.length; i++) {
        savedDeck[i] = deck[i];
    }
}

/*
 * I grabbed this function from stack overflow. The algorithm is based off the Knuth
 * Shuffle algorithm.
 * Link to stack overflow page: http://stackoverflow.com/a/2450976
 * Github to original code: https://github.com/coolaj86/knuth-shuffle
 */
function shuffle(array) {
    var currentIndex = array.length, temporaryValue, randomIndex;

    // While there remain elements to shuffle...
    while (0 !== currentIndex) {

    // Pick a remaining element...
    randomIndex = Math.floor(Math.random() * currentIndex);
    currentIndex -= 1;

    // And swap it with the current element.
    temporaryValue = array[currentIndex];
    array[currentIndex] = array[randomIndex];
    array[randomIndex] = temporaryValue;
  }

  return array;
}    
        

