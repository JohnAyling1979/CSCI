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
    	$sql = "SELECT * FROM Quote WHERE quoteId = '$qVal';";
    	$result = $db->query($sql);

        // displays quote information to the user based on quote ID number
    	if (isset($_POST["quoteId"]))
        {
			while(($row = $result->fetch()) != NULL)
            {
                echo "<b>Sales Associate: </b>";
                echo $row["salesAssociate"];
                echo "<br><br>";
                echo "<b>Quote ID: </b>";
                echo $row["quoteId"];
                echo "<br><br>";
       		    echo "<b>Customer Name: </b>";
                echo $row["customerName"];
                echo "<br>";
       		    echo "<b>Customer Address: </b>";
                echo $row["customerAddress"];
                echo "<br>";
                echo "<b>Customer City: </b>";
                echo $row["customerCity"];
                echo "<br>";
                echo "<b>Customer Email: </b>";
                echo $row["customerEmail"];
                echo "<br>";
       		}
		}

    ?>

</form>
</body>
</HTML>