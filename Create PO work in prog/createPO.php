<!DOCTYPE html>
<!--
Driver page for the create PO interface
-->
<html>
    <head>
        <meta charset="utf-8">
        <style>
            td
            {
                text-align:center;
            }
        </style>
        
<?php
    //needed files
    require "CreatePurchaseOrderGUI.php";
    require "ManagePurchaseOrder.php";
    require "PurchaseOrderGateway.php";
    require "QuoteStore.php";
    require "SAStore.php";

    //creates instances of the classes
    if(!isset($interface))
        $interface=new CreatePurchaseOrderGUI;

    if($_SERVER[REQUEST_METHOD]=="POST")
    {
        if(isset($_POST[picked]))
        {
            $interface->displayQuote($_POST[quoteId]);
        }

        if(isset($_POST[update]))
        {
            $interface->createPurchaseOrder($_POST[quoteId],$_POST[amount],$_POST[percent]);
        }
    }
    else
    {
        $interface->chooseQuote();
    }  
?>
    </body>
</html>
