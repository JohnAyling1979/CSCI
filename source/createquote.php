<?php
    //needed classes
    require "dbconnect.php";
    require "SalesAssociateInterface.php";
    require "CreateQuoteController.php";
    require "LegacyDatabaseInterface.php";
    require "QuoteStore.php";
    require "SAstore.php";

    //creates instances of the classes
    $interface=new SalesAssociateInterface;
    $controller=new CreateQuoteController;
    $DBI=new LegacyDatabaseInterface;
    $quote=new QuoteStore;
    $ST=new STstore;


    if($_SERVER[REQUEST_METHOD]=="POST")
    {
        if(isset($_POST[login]))
        {
            $customerSTMT=$interface->submitLogin($controller,$ST,$DBI,$_POST[user],$_POST[pass]);
            if($customerSTMT!=NULL)
            {
                echo "<html>";
                echo "<form method=post>";
                echo "<select name='cust'>";
                foreach($customerSTMT as $row)
                {
                    echo "<option value='$row[0]'>$row[0]</option>";
                }
                echo"</select>";
                echo "<button type=submit name='create'>Create Quote</button>";
                echo "</form>";
                echo "</html>";
            }
        }
        if(isset($_POST[create]))
        {
            echo "<html>";
            echo "new ".$_POST[cust]." quote";
            echo "</html>";
        }
    }
    else
    {
        echo "<html>";
        echo "<head>";
        echo "<title>Create Quote</title>";
        echo "</head>";
        echo "<body>";
        echo "<h1>Create Quote System login</h1>";
        echo "<form method=post>";
        echo "<table>";
        echo "<tr><td>User Name:</td><td><input type='text' name='user'></td></tr>";
        echo "<tr><td>Password:</td><td><input type='password' name='pass'></td></tr>";
        echo "</table>";
        echo "<button type=submit name='login'>Login</button>";
        echo "</form>";
        echo "</body>";
        echo "</html>";
    }
?>
