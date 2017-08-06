<!DOCTYPE html>
<!--
Driver page for the create quote interface
-->
<html>
    <head>
        <meta charset="utf-8">
<?php
    //needed files
    require "SanctionGUI.php";
    require "ManageQuote.php";
    require "QuoteStore.php";

    //creates the instance of the class if not set
    if(!isset($interface))
        $interface=new SanctionGUI;

    //when a post is submited
    if($_SERVER[REQUEST_METHOD]=="POST")
    {
        if(isset($_POST[picked]))
            $interface->displayQuote($_POST[quoteId]);

        if(isset($_POST[update]))
        {
            $interface->updateQuote($_POST[quoteId]);
        }

        if(isset($_POST[discount]))
        {
            $interface->discount($_POST[quoteId],$_POST[type],$_POST[dollar],$_POST[percent]);
        }

        if(isset($_POST[yes]))
        {
            $interface->saction($_POST[quoteId]);
        }

        if(isset($_POST[no]))
        {
            $interface->end();
        }
    }
    else
    {
        $interface->index();
    }
?>
    </body>
</html>
