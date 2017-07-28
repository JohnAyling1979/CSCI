<?php
    //starts session
    session_start();

    //needed classes
    require "dbconnect.php";
    require "SalesAssociateInterface.php";
    require "CreateQuoteController.php";
    require "LegacyDatabaseInterface.php";
    require "QuoteStore.php";
    require "STstore.php";

    //creates instances of the classes
    $interface=new SalesAssociateInterface;
    $controller=new CreateQuoteController;
    $DBI=new LegacyDatabaseInterface;
    $quote=new QuoteStore;
    $ST=new STstore;


    if($_SERVER[REQUEST_METHOD]=="POST")
    {
        $interface->submitLogin($controller,$ST,$_POST[user],$_POST[pass]);
    }
?>
<html>
    <head>
        <title>Create Quote</title>
    </head>
    <body>
        <h1>Create Quote System login</h1>
        <form method=post>
            <table>
                <tr><td>User Name:</td><td><input type="text" name="user"></td></tr>
                <tr><td>Password:</td><td><input type="password" name="pass"></td></tr>
            </table>
            <button type=submit>Login</button>
        </form>
    </body>
</html>
