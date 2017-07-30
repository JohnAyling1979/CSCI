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
        $quotesByID = $quoteList->getQuote();

        echo "Select a finalized Quote: ";
        echo '<select name="quoteId">';
        echo '<option value="" disabled selected>Select a Quote</option>';

        foreach ($quotesByID as $quoteList)
        {
            echo "<option value='".$quoteList["quoteId"] . "'>" . $quoteList["quoteId"]."</option>";
        }
        
        echo "</select>";
    ?>
    <input type="submit" value="Submit">
    <br><br>

    <?php

        $_POST["quoteId"];
        $db=connect("courses","z981329","z981329","1979Jul29");

        $qVal = $_POST["quoteId"];
    	$sql = "SELECT * FROM Quote WHERE quoteId = '$qVal';";
    	$result = $db->query($sql);

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