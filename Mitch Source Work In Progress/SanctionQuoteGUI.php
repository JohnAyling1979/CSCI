<?php
    // The SacntionQuoteGUI class provides user interaction
    class SanctionQuoteGUI
    {
        public function displayQuote($controller, $quoteStore)
        {
            // display HTML page
            print ('<title>Sanction a Quote</title>
                    </head>
                    <body>
                    <h2>Sanction a Quote</h2>
            ');
        
            $quotesByID = $controller->getFinalizedQuote($quoteStore);

            // display a dropdown box with a default selection
            print ('<form method=post>
                    Select a finalized Quote 
                    <select name="quoteId">
                    <option value="" disabled selected>Quote by ID</option>
            ');

            // diplay quotes by ID in the drop down box
            foreach ($quotesByID as $row)
            {
                echo "<option value='".$row["quoteId"]. "'>" .$row["quoteId"]."</option>";
            }
        
            // display submit button
            print ('</select>
                    <input type="submit" name="viewQuote" value="Submit">
                    </form>
                    <br><br>
            ');

            // retrieves user selection from dropdown
            $_POST["quoteId"];

            // save the user selection to a session variable
            $_SESSION["quoteId"] = $_POST["quoteId"];

            // connect to the database
            $db=connect("courses","z981329","z981329","1979Jul29");

            // uses the selected ID number to query the quote database for customer info
            $qVal = $_POST["quoteId"];
    	    $sqlA = "SELECT * FROM Quote WHERE quoteId = '$qVal';";
    	    $resultA = $db->query($sqlA);

            // retrieve line items from quote database based on the quote ID
            $sqlB = "SELECT * FROM LineItem WHERE quoteId = '$qVal';";
    	    $resultB = $db->query($sqlB);

            // displays quote information to the user based on quote ID number
    	    if (isset($_POST["quoteId"]))
            {
			    while(($rowA = $resultA->fetch()) != NULL)
                {
                    echo "<h3>Quote Information</h3><hr>";
                    echo "<b>Sales Associate: </b>" .$rowA["salesAssociate"]. "<br>";
                    echo "<b>Quote ID: </b>" .$rowA["quoteId"]. "<br><br>";
                    echo "<h3>Customer Information</h3><hr>";
       		        echo "<b>Customer Name: </b>" .$rowA["customerName"]. "<br>";
       		        echo "<b>Customer Address: </b>" .$rowA["customerAddress"]. "<br>";
                    echo "<b>Customer City: </b>" .$rowA["customerCity"]. "<br>";
                    echo "<b>Customer Email: </b>" .$rowA["customerEmail"]. "<br><br>";
                    echo "<h3>Customer Items</h3><hr>";
                    echo "<table border=0 width=75%><tr>";
                    echo "<th align=left>Line ID</th>";
       			    echo "<th align=left>Description</th>";
       			    echo "<th align=left>Price</th>";
                    echo "<th align=left>Secret Notes</th></tr>";

                    while(($rowB = $resultB->fetch()) != NULL)
                    {
                        echo "<tr><td>".$rowB["lineId"]."</td>";
                        echo "<td>".$rowB["description"]."</td>";
                        echo "<td>".$rowB["price"]."</td>";
                        echo "<td>".$rowB["secretNote"]."</td></tr>";
                    } // end while for resultB
                    echo "</table>";
       		    } // end while for resultA    
		    } // end if

            // end connection to the database
            $db = null;

        } // end function

        public function addLineItems()
        {
            // display the add line item edit functions
            if (isset($_SESSION['quoteId']))
            {
                print ('<br><h3>Quote Editing Functions</h3><hr>
                        <h4>Add Line Items</h4>
                        <form method=post>
                        <span style="white-space:nowrap">
                        <input type="text" name="addDescription" size=50 placeholder="Item Description">
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="text" name="addPrice" placeholder="Price"><br><br>
                        <input type="submit" name="submitLineItems" value="Add Line Items">
                        <input type="reset">
                        </span>
                        </form>
                ');
            }
        }

        public function editLineItems()
        {
            // display the add line item edit functions
            if (isset($_SESSION['quoteId']))
            {
                print ('<form method=post>
                        <h4>Edit Line Items</h4>
                        <span style="white-space:nowrap">
                        <input type="text" name="editID" size=5 placeholder="Item ID">
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="text" name="editDescription" size=50 placeholder="New Item Description">
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="text" name="editPrice" placeholder="New Price"><br><br>
                        <input type="submit" name="editLineItems" value="Edit Line Items">
                        <input type="reset">
                        </span>
                        </form>
                ');
                echo "<br><br> Session ID is Quote Id: ";
                echo $_SESSION['quoteId'];
                echo "<br><br> Post ID is Quote Id: ";
                echo $_SESSION['quoteId'];
            }
        }
    } // end class
?>