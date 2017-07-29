<?php     session_start(); ?>
<!DOCTYPE html>
<html>
    <head><meta charset="utf-8">
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
                $_SESSION[USER]=$_POST[user];
                echo "<title>Choose Customer</title></head>";
                echo "<body>";
                echo "<form method=post>";
                echo "<select name='cust'>";
                foreach($customerSTMT as $row)
                {
                    $customer=iconv("latin1","UTF-8",$row[1]);
                    echo "<option value=$row[0]>$customer</option>";
                }
                echo"</select>";
                echo "<button type=submit name='create'>Create Quote</button>";
                echo "</form>";
            }
        }
        if(isset($_POST[create]))
        {
            $customerSTMT=$interface->chooseCustomer($controller,$DBI,$_POST[cust]);
            $customer=$customerSTMT->fetch();
            $_SESSION[customerName]=iconv("latin1","UTF-8",$customer[0]);
            $_SESSION[customerAdd]=iconv("latin1","UTF-8",$customer[1]);
            $_SESSION[customerCity]=iconv("latin1","UTF-8",$customer[2]);
            echo "<title>$_SESSION[customerName] Quote</title></head>";
            echo "<body>";
            echo "Customer: ".$_SESSION[customerName]."<br>";
            echo "Street: ".$_SESSION[customerAdd]."<br>";
            echo "City: ".$_SESSION[customerCity]."<br>";
            echo "Email: <input type='email' name='email'><br>";
            echo "Sales Associate: ".$_SESSION[USER]."<br><br><br>";
            echo "<button onclick='addLine()'>Add Line</button>";
            echo "<form method=post>";
            echo "<table style='width:100%'>";
            echo "<tr><th>Description</th><th>Price</th><th>Secret Note</th></tr>";
            echo "<tr><td><input type='text' size=50 name='desc0'></td><td><input type='text' size=10 name='price0'></td><td><input type='text' size=50 name='secret0'></td></tr>";
            echo "<tr><td id='line1'></td><td id='line2'></td><td id='line3'></td></tr>";
            echo "</table>";
            echo "<button type=submit name='final'>Finalize</button>";
            echo "</form>";
        }
        if(isset($_POST['final']))
        {
            echo "Quote made";
        }
    }
    else
    {
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
    }
?>
    </body>
</html>
<script>
    var n=1;
    function addLine()
    {
        var input1={};
        input1[n]=document.createElement("input");
        var input2={};
        input2[n]=document.createElement("input");
        var input3={};
        input3[n]=document.createElement("input");

        var nl=document.createElement("br");

        input1[n].type="text";
        input1[n].id=n;
        input1[n].size="50";
        input1[n].name="desc".n;

        input2[n].type="text";
        input2[n].id=n;
        input2[n].size="10";
        input2[n].name="price".n;


        input3[n].type="text";
        input3[n].id=n;
        input3[n].size="50";
        input3[n].name="secret".n;

        document.getElementById("line1").appendChild(input1[n]);
        document.getElementById("line2").appendChild(input2[n]);
        document.getElementById("line3").appendChild(input3[n]);
        n++;        
    }
</script>

