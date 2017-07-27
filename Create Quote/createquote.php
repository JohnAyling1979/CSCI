<?php
    //starts session
    session_start();

    //SalesAssociateInterface class
    require "SalesAssociateInterface.php";

    //creates instance of the class
    $interface=new SalesAssociateInterface;


    if($_SERVER[REQUEST_METHOD]=="POST")
        $interface->submitLogin();
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
