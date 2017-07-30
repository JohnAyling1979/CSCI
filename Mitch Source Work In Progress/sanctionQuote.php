<?php 
session_start();
require "QuoteStore.php";
require "dbconnect.php";
?>

<!DOCTYPE html>
<HTML>

<head>
<title>Sanction a Quote</title>
</head>

<body>
    <form action="sanctionQuote.php" method="POST">
    <h2>Sanction a Quote</h2>

	<?php
        $quoteList = new QuoteStore;
        $quotesByID = $quoteList->getFinalizedQuote();

        // display a dropdown box with a default selection
        echo "Select a finalized Quote: ";
        echo '<select name="quoteId">';
        echo '<option value="" disabled selected>Quote by ID</option>';

        // diplsy quotes by ID in the drop down box
        foreach ($quotesByID as $quoteList)
        {
            echo "<option value='".$quoteList["quoteId"] . "'>" . $quoteList["quoteId"]."</option>";
        }
        
        echo "</select>";
    ?>
    <input type="submit" value="Submit">
    <br><br>

    <?php
        // retrieves user selection from dropdown
        $_POST["quoteId"];
        $db=connect("courses","z981329","z981329","1979Jul29");

        // uses the selected ID number to query the quote database
        $qVal = $_POST["quoteId"];
    	$sqlA = "SELECT * FROM Quote WHERE quoteId = '$qVal';";
    	$resultA = $db->query($sqlA);

        // retrieve line items from quote database
        $sqlB = "SELECT * FROM LineItem WHERE quoteId = '$qVal';";
    	$resultB = $db->query($sqlB);

        // displays quote information to the user based on quote ID number
    	if (isset($_POST["quoteId"]))
        {
			while(($rowA = $resultA->fetch()) != NULL)
            {
                echo "<h3>Quote Information</h3>";
                echo "<hr>";
                echo "<b>Sales Associate: </b>";
                echo $rowA["salesAssociate"];
                echo "<br>";
                echo "<b>Quote ID: </b>";
                echo $rowA["quoteId"];
                echo "<br><br>";
                echo "<h3>Customer Information</h3>";
                echo "<hr>";
       		    echo "<b>Customer Name: </b>";
                echo $rowA["customerName"];
                echo "<br>";
       		    echo "<b>Customer Address: </b>";
                echo $rowA["customerAddress"];
                echo "<br>";
                echo "<b>Customer City: </b>";
                echo $rowA["customerCity"];
                echo "<br>";
                echo "<b>Customer Email: </b>";
                echo $rowA["customerEmail"];
                echo "<br><br>";
                echo "<h3>Customer Items</h3>";
                echo "<hr>";
                echo "<table border=0 width=75%>";
                echo "<tr>";
       			echo "<th align=left>Description</th>";
       			echo "<th align=left>Price</th>";
                echo "<th align=left>Secret Notes</th>";
       			echo "</tr>";

                while(($rowB = $resultB->fetch()) != NULL)
                {
                    echo "<tr>";
                    echo "<td>";
                    echo $rowB["description"];
                    echo "</td>";
                    echo "<td>";
                    echo $rowB["price"];
                    echo "</td>";
                    echo "<td>";
                    echo $rowB["secretNote"];
                    echo "</td>";
                    echo "</tr>";
                }
       		}
		}

    ?>

</form>
</body>
</HTML>