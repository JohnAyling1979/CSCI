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
                    <option value="" disabled selected>Quote by Customer Name</option>
            ');

            // diplay quotes by ID in the drop down box
            foreach ($quotesByID as $row)
            {
                echo "<option value='".$row["quoteId"]. "'>" .$row["customerName"]."</option>";
            }
        
            // display submit button
            print ('</select>
                    <input type="submit" name="viewQuote" value="Submit">
                    </form>
                    <br><br>
            ');
        } // end function

        public function viewQuote($controller, $quoteStore)
        {
            // save the user selection to a session variable
            $_SESSION["quoteId"] = $_POST["quoteId"];

            // connect to the database
            $db=connect("courses","z981329","z981329","1979Jul29");

            // uses the selected ID number to query the quote database for customer info
    	    $sqlA = "SELECT * FROM Quote WHERE quoteId = '$_SESSION[quoteId]';";
    	    $resultA = $db->query($sqlA);

            // retrieve line items from quote database based on the quote ID
            $sqlB = "SELECT * FROM LineItem WHERE quoteId = '$_SESSION[quoteId]';";
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
                        <input type="text" name="addPrice" placeholder="Price">&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="submit" name="submitLineItems" value="Add Line Items">
                        <input type="reset">
                        </span>
                        </form>
                ');
            } // end if
        } // end function

        public function editLineItems()
        {
            // display the edit line item edit functions
            if (isset($_SESSION['quoteId']))
            {
                print ('<h4>Edit Line Items</h4>
                        <form method=post>
                        <span style="white-space:nowrap">
                        <select name="lineId">
                        <option value="" disabled selected>Select an Item</option>
                ');

                // connect to the database
                $db=connect("courses","z981329","z981329","1979Jul29");

                // retrieve line items from quote database based on the quote ID
                $sql = "SELECT lineId, description FROM LineItem WHERE quoteId = '$_SESSION[quoteId]';";
    	        $result = $db->query($sql);

                // diplay quotes by ID in the drop down box
                foreach ($result as $row)
                {
                    echo "<option value='".$row["lineId"]. "'>" .$row["description"]."</option>";
                } // end foreach
        
                // display submit button
                print ('</select>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="text" name="editDescription" size=50 placeholder="New Item Description">
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="text" name="editPrice" placeholder="New Price">&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="submit" name="editLineItems" value="Edit Line Items">
                        <input type="reset">
                        </span>
                        </form>
                ');
            } // end if
            // end connection to the database
            $db = null;
        } // end function

        public function removeLineItems()
        {
            // display the add line item edit functions
            if (isset($_SESSION['quoteId']))
            {
                print ('<h4>Remove Line Items</h4>
                        <form method=post>
                        <span style="white-space:nowrap">
                        <select name="lineId">
                        <option value="" disabled selected>Select an Item</option>
                ');

                // connect to the database
                $db=connect("courses","z981329","z981329","1979Jul29");

                // retrieve line items from quote database based on the quote ID
                $sql = "SELECT lineId, description FROM LineItem WHERE quoteId = '$_SESSION[quoteId]';";
    	        $result = $db->query($sql);

                // diplay quotes by ID in the drop down box
                foreach ($result as $row)
                {
                    echo "<option value='".$row["lineId"]. "'>" .$row["description"]."</option>";
                } // end foreach
        
                // display submit button
                print ('</select>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="submit" name="removeLineItems" value="Remove Line Item">
                        </form>
                ');
            } // end if
            // end connection to the database
            $db = null;
        } // end function

        public function addSecretNote()
        {
            // display the add line item edit functions
            if (isset($_SESSION['quoteId']))
            {
                print ('<h4>Add Secret Note to an Item</h4>
                        <form method=post>
                        <span style="white-space:nowrap">
                        <select name="lineId">
                        <option value="" disabled selected>Select an Item</option>
                ');

                // connect to the database
                $db=connect("courses","z981329","z981329","1979Jul29");

                // retrieve line items from quote database based on the quote ID
                $sql = "SELECT lineId, description FROM LineItem WHERE quoteId = '$_SESSION[quoteId]' AND secretNote IS NULL;";
    	        $result = $db->query($sql);

                // diplay quotes by ID in the drop down box
                foreach ($result as $row)
                {
                    echo "<option value='".$row["lineId"]. "'>" .$row["description"]."</option>";
                } // end foreach
        
                print ('</select>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="text" name="addSecretNote" size=50 placeholder="New Secret Note">
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="submit" name="submitSecretNote" value="Add Secret Note">
                        <input type="reset">
                        </span>
                        </form>
                ');
            } // end if
            // end connection to the database
            $db = null;
        } // end function

        public function editSecretNote()
        {
            // display the edit line item edit functions
            if (isset($_SESSION['quoteId']))
            {
                print ('<h4>Edit a Secret Note on an Item</h4>
                        <form method=post>
                        <span style="white-space:nowrap">
                        <select name="lineId">
                        <option value="" disabled selected>Select a Secret Note</option>
                ');

                // connect to the database
                $db=connect("courses","z981329","z981329","1979Jul29");

                // retrieve line items from quote database based on the quote ID and if a secret note exists
                $sql = "SELECT lineId, secretNote FROM LineItem WHERE quoteId = '$_SESSION[quoteId]' AND secretNote IS NOT NULL;";
    	        $result = $db->query($sql);

                // diplay quotes by ID in the drop down box
                foreach ($result as $row)
                {
                    echo "<option value='".$row["lineId"]. "'>" .$row["secretNote"]."</option>";
                } // end foreach
        
                // display submit button
                print ('</select>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="text" name="editSecretNote" size=50 placeholder="Edit Secret Note">
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="submit" name="submitSecretNoteEdit" value="Edit Secret Note">
                        <input type="reset">
                        </span>
                        </form>
                ');
            }
            // end connection to the database
            $db = null;
        } // end function
    } // end class
?>