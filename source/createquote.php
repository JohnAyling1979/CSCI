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
