<?php     session_start(); ?>
<!DOCTYPE html>
<!--
Driver page for the create PO interface
-->
<html>
    <head>
        <meta charset="utf-8">
<?php
    //needed files
    require "CreatePurchaseOrderGUI.php";
    require "ManagePurchaseOrder.php";
    require "PurchaseOrderGateway.php";
    require "QuoteStore.php";
    require "SAstore.php";

    //creates instances of the classes
    $_SESSION['interface']=new CreatePurchaseOrderGUI;
    $_SESSION['controller']=new CreateQuoteController;
    $_SESSION['POGateway']=new PurchaseOrderGateway;
    $_SESSION['quote']=new QuoteStore;
    $_SESSION['SA']=new SAstore;
>?

    </body>
</html>
