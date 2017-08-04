<!DOCTYPE html>
<!--
Driver page for the create quote interface
-->
<html>
    <head>
        <meta charset="utf-8">
<?php
    //needed files
    require "SalesAssociateInterface.php";
    require "CreateQuoteController.php";
    require "LegacyDatabaseInterface.php";
    require "QuoteStore.php";
    require "SAstore.php";

    //creates the instance of the class if not set
    if(!isset($interface))
        $interface=new SalesAssociateInterface;

    //when a post is submited
    if($_SERVER[REQUEST_METHOD]=="POST")
    {
        //login submit
        if(isset($_POST[login]))
        {
            $interface->submitLogin($_POST[pass],$_POST[user]);
        }

        //create submit
        if(isset($_POST[create]))
        {
            $interface->createQuote($_POST[cust]);
        }

        //finalize submit
        if(isset($_POST['final']))
        {
            $interface->finalizeQuote($_POST[customerName],$_POST[custId],$_POST[customerAdd],$_POST[customerCity],$_POST[email],$_POST[user]);
        }
    }
    //begining interface
    else
    {   
        $interface->index();
    }
?>
    </body>
</html>

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
        var dl=document.createElement("br");

        var price={};
        price[n]=document.createElement("input");
        var pl=document.createElement("br");

        var secret={};
        secret[n]=document.createElement("input");
	var sl=document.createElement("br");

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

        //append the line to the table
        document.getElementById("line1").appendChild(desc[n]);
	document.getElementById("line1").appendChild(dl);

        document.getElementById("line2").appendChild(price[n]);
        document.getElementById("line2").appendChild(pl);

        document.getElementById("line3").appendChild(secret[n]);
        document.getElementById("line3").appendChild(sl);

        //increase row count
        n++;
    }
</script>
