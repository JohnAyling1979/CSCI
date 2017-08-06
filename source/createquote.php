<!DOCTYPE html>
<!--
Driver page for the create quote interface
-->
<html>
    <head>
        <meta charset="utf-8">
<?php
    //needed files
    require "CreateQuoteGUI.php";
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
            $interface->submitLogin($_POST[name],$_POST[password]);
        }

        //create submit
        if(isset($_POST[create]))
        {
            $interface->createQuote($_POST[id],$_POST[name]);
        }

        //finalize submit
        if(isset($_POST['final']))
        {
            $interface->finalizeQuote($_POST[customerName],$_POST[custId],$_POST[customerAddress],$_POST[customerCity],$_POST[customerEmail],$_POST[salesAssociate]);
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
