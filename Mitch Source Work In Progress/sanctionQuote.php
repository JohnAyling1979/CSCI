<?php session_start();?>

<!-- SanctionQuoteGUI Driver Page -->

<!DOCTYPE html>
<HTML>
<head>
    <meta charset="utf-8">
	<?php
        // files required for operation
        require "QuoteStore.php";
        require "ManageQuote.php";
        require "SanctionQuoteGUI.php";
        require "dbconnect.php";

        // create new instance of the classes
        $quoteList = new QuoteStore;
        $controller = new ManageQuote;
        $interface = new SanctionQuoteGUI;

        $interface->displayQuote($controller, $quoteList);
    ?>
</body>
</HTML>

<!--javascript to add line items to the screen -->
<script>
    //starting row number
    var n=1;

    /****************************************************************
       FUNCTION:   addLine
       ARGUMENTS:  none
       RETURNS:    none
       USAGE:      adds a row to the screen for a new line item
    ****************************************************************/
    function addLine()
    {
        //arrays for each input
        var desc={};
        desc[n]=document.createElement("input");
        var price={};
        price[n]=document.createElement("input");
        var secret={};
        secret[n]=document.createElement("input");

        //attributes for each element
        desc[n].type="text";
        desc[n].id=n;
        desc[n].size="50";
        desc[n].name="desc"+n;

        price[n].type="text";
        price[n].id=n;
        price[n].size="10";
        price[n].name="price"+n;


        secret[n].type="text";
        secret[n].id=n;
        secret[n].size="50";
        secret[n].name="secret"+n;

        //append the table to the table
        document.getElementById("line1").appendChild(desc[n]);
        document.getElementById("line2").appendChild(price[n]);
        document.getElementById("line3").appendChild(secret[n]);

        //increase row count
        n++;        
    }
</script>