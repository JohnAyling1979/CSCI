<?php
    // The SacntionQuoteGUI class provides user interaction
    class SanctionQuoteGUI
    {
        // constructor of a new instance of the QuoteStore class
        public function __construct()
        {
            $this->controller = new ManageQuote;
        }
        /*******************************************************************
            FUNCTION:   QuoteStore::displayQuote
            ARGUMENTS:  none
            PURPOSE:    Displays all quotes marked as finalized in the
                        database. The user selects the quote via dropdown
                        menu
        *******************************************************************/
        public function displayQuote()
        {
            // display HTML page
            print ('<title>Sanction a Quote</title>
                    </head>
                    <body>
                    <h2>Sanction a Quote</h2>
            ');
        
            // fetch the results from the controller
            $quotesByID = $this->controller->getFinalizedQuote($quoteStore);

            // display a dropdown box with a default selection
            print ('<form method=post>
                    Select a finalized Quote 
                    <select name="quoteId">
                    <option value="" disabled selected>Quote by ID and Customer Name</option>
            ');

            // diplay quotes by ID in the drop down box
            foreach ($quotesByID as $row)
            {
                echo "<option value='".$row["quoteId"]. "'>" .$row["quoteId"]. " - " .$row["customerName"]."</option>";
            }
        
            // display submit button
            print ('</select>
                    <input type="submit" name="viewQuote" value="Submit">
                    </form>
                    <br><br>
            ');
        } // end function

        /*******************************************************************
            FUNCTION:   QuoteStore::viewQuote
            ARGUMENTS:  controller, quoteStore
            PURPOSE:    Displays all information pertaining to the quote.
                        This includes the customer information, sales
                        associate, and all line items that were entered
                        during quote creation
        *******************************************************************/
        public function viewQuote()
        {
            // uses the selected ID number to query the quote database for customer info
    	    $resultA = $this->controller->getQuote($_SESSION[quoteId]);

            // retrieve line items from quote database based on the quote ID
    	    $resultB = $this->controller->getLineItems($_SESSION[quoteId]);

            // displays quote information to the user based on quote ID number
    	    if (isset($_SESSION["quoteId"]))
            {
                // display the customer and sales associate information
                echo "<h3>Quote Information</h3><hr>";
                echo "<b>Sales Associate: </b>" .$resultA["salesAssociate"]. "<br>";
                echo "<b>Quote ID: </b>" .$resultA["quoteId"]. "<br><br>";
                echo "<h3>Customer Information</h3><hr>";
       		    echo "<b>Customer Name: </b>" .$resultA["customerName"]. "<br>";
       		    echo "<b>Customer Address: </b>" .$resultA["customerAddress"]. "<br>";
                echo "<b>Customer City: </b>" .$resultA["customerCity"]. "<br>";
                echo "<b>Customer Email: </b>" .$resultA["customerEmail"]. "<br><br>";
                echo "<h3>Customer Items</h3><hr>";
                echo "<table border=0 width=75%><tr>";
       			echo "<th align=left>Description</th>";
       			echo "<th align=left>Price</th>";
                echo "<th align=left>Secret Notes</th></tr>";

                    // display the line items of the quote
                    while($rowB = $resultB->fetch())
                    {
                        echo "<tr><td>".$rowB["description"]."</td>";
                        echo "<td>".$rowB["price"]."</td>";
                        echo "<td>".$rowB["secretNote"]."</td></tr>";
                    } // end while for resultB
                    echo "</table>";
		    } // end if
        } // end function

       /*******************************************************************
            FUNCTION:   QuoteStore::calculatePrice
            ARGUMENTS:  controller, quoteId
            PURPOSE:    Displays the current price of the quote.
        *******************************************************************/
        public function calculatePrice()
        {
            // retreive the current price from the quote store
            $price = $this->controller->calculatePrice($_SESSION[quoteId]);

            // display the current price of the quote
            echo "<br><b>Current Total: </b>$" .$price;

        } // end function

        /*******************************************************************
            FUNCTION:   QuoteStore::addLineItems
            ARGUMENTS:  none
            PURPOSE:    Allows the user to add line items to the quote.
                        This includes a description and a price for the
                        item.
        *******************************************************************/
        public function callAddLineItem($quoteId,$addDescription,$addPrice)
        {
            $this->controller->addLineItems($quoteId,$addDescription,$addPrice);
        }

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
                        <input type="hidden" name="type" value="Add Line Items">
                        <input type="submit" name="submit" value="Add Line Items">
                        <input type="reset">
                        </span>
                        </form>
                ');
            } // end if
        } // end function

        /*******************************************************************
            FUNCTION:   QuoteStore::editLineItems
            ARGUMENTS:  none
            PURPOSE:    Allows the user to make changes to current line
                        items. This includes changes to the description
                        and the price. User selects the line item via a
                        drop down box
        *******************************************************************/
        public function callEditLineItem($quoteId,$lineId,$addDescription,$addPrice)
        {
            $this->controller->editLineItems($quoteId,$lineId,$addDescription,$addPrice);
        }
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

                // retrieve line items from quote database based on the quote ID
    	        $result = $this->controller->getLineItems($_SESSION['quoteId']);

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
                        <input type="hidden" name="type" value="Edit Line Items">
                        <input type="submit" name="submit" value="Edit Line Items">
                        <input type="reset">
                        </span>
                        </form>
                ');
            } // end if

            // end connection to the database
            $db = null;
        } // end function

        /*******************************************************************
            FUNCTION:   QuoteStore::removeLineItems
            ARGUMENTS:  none
            PURPOSE:    This allows the user to remove selected line items
                        from the quote. The user selects the line item via
                        a drop down box
        *******************************************************************/
        public function callRemoveLineItem($quoteId,$lineId)
        {
            $this->controller->removeLineItems($quoteId,$lineId);
        }
        public function removeLineItems()
        {
            // display the remove item edit functions
            if (isset($_SESSION['quoteId']))
            {
                print ('<h4>Remove Line Items</h4>
                        <form method=post>
                        <span style="white-space:nowrap">
                        <select name="lineId">
                        <option value="" disabled selected>Select an Item</option>
                ');

                // retrieve line items from quote database based on the quote ID
    	        $result = $this->controller->getLineItems($_SESSION[quoteId]);

                // diplay line items by ID in the drop down box
                foreach ($result as $row)
                {
                    echo "<option value='".$row["lineId"]. "'>" .$row["description"]."</option>";
                } // end foreach
        
                // display submit button
                print ('</select>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="hidden" name="type" value="Remove Line Items">
                        <input type="submit" name="submit" value="Remove Line Item">
                        </form>
                ');
            } // end if

            // end connection to the database
            $db = null;
        } // end function

        /*******************************************************************
            FUNCTION:   QuoteStore::addSecretNote
            ARGUMENTS:  none
            PURPOSE:    Allows the user to add a secret note to an item 
                        that does not have a note attached to it.
                        The user selects the item via a drop down box.
        *******************************************************************/
        public function callAddSecretNote($lineId,$secretNote)
        {
            $this->controller->addSecretNote($lineId,$secretNote);
        }
        public function addSecretNote()
        {
            // display the add secret note edit functions
            if (isset($_SESSION['quoteId']))
            {
                print ('<h4>Add Secret Note to an Item</h4>
                        <form method=post>
                        <span style="white-space:nowrap">
                        <select name="lineId">
                        <option value="" disabled selected>Select an Item</option>
                ');

                // retrieve line items from quote database based on the quote ID and if there is not current secret note on the line item
    	        $result = $this->controller->viewEmptySecretNote($_SESSION[quoteId]);

                // diplay line items by ID in the drop down box
                foreach ($result as $row)
                {
                    echo "<option value='".$row["lineId"]. "'>" .$row["description"]."</option>";
                } // end foreach
        
                // display a submit button
                print ('</select>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="text" name="secretNote" size=50 placeholder="New Secret Note">
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="hidden" name="type" value="Add Secret Note">
                        <input type="submit" name="submit" value="Add Secret Note">
                        <input type="reset">
                        </span>
                        </form>
                ');
            } // end if

            // end connection to the database
            $db = null;
        } // end function

        /*******************************************************************
            FUNCTION:   QuoteStore::editSecretNote
            ARGUMENTS:  none
            PURPOSE:    Allows the user to edit secret notes on only items
                        that currently have a secret note attached.
                        The user selects the item via a drop down box.
        *******************************************************************/
        public function callEditSecretNote($lineId,$secretNote)
        {
            $this->controller->editSecretNote($lineId,$secretNote);
        }
        public function editSecretNote()
        {
            // display the edit secret note edit functions
            if (isset($_SESSION['quoteId']))
            {
                print ('<h4>Edit a Secret Note on an Item</h4>
                        <form method=post>
                        <span style="white-space:nowrap">
                        <select name="lineId">
                        <option value="" disabled selected>Select an Item with a Secret Note to edit</option>
                ');

                // retrieve line items from quote database based on the quote ID and if a secret note already exists on a line item
    	        $result = $this->controller->viewAttachedSecretNote($_SESSION[quoteId]);

                // diplay line items by ID in the drop down box
                foreach ($result as $row)
                {
                    echo "<option value='".$row["lineId"]. "'>".$row["description"]." - ".$row["secretNote"]."</option>";
                } // end foreach
        
                // display submit button
                print ('</select>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="text" name="secretNote" size=50 placeholder="Edit Secret Note">
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="hidden" name="type" value="Edit Secret Note">
                        <input type="submit" name="submit" value="Edit Secret Note">
                        <input type="reset">
                        </span>
                        </form>
                ');
            } // end if
        } // end function

       /*******************************************************************
            FUNCTION:   QuoteStore::calaculateDiscounts
            ARGUMENTS:  none
            PURPOSE:    Allows the user to add a discount in either a 
                        percentage or dollar amount.
        *******************************************************************/
        public function callCalculateDiscount($quoteId, $amount,$percentage)
        {
            $this->controller->calculateDiscounts($quoteId, $amount,$percentage);
        }
        public function calculateDiscounts()
        {
            // display the discount functions
            if (isset($_SESSION['quoteId']))
            {
                print ('<br><h3>Apply Quote Discounts</h3><hr>
                        <h4>Discounts</h4>
                        <form method=post>
                        <span style="white-space:nowrap">
                        Enter Discount as an Amount <input type="text" name="amount" min="0" max="9999999999">
                        <br><br>
                        Enter Discount as a Percetage <input type="text" name="percentage" min="0" max="100"><br><br>
                        <input type="hidden" name="type" value="Apply Discount">
                        <input type="submit" name="submit" value="Apply Discount">
                        <input type="reset">
                        </span>
                        </form>
                ');
            } // end if
        } // end function

       /*******************************************************************
            FUNCTION:   QuoteStore::calculateFinalPrice
            ARGUMENTS:  controller, quoteId
            PURPOSE:    Displays the current price in the discounts
                        area of the window.
        *******************************************************************/
        public function calculateFinalPrice()
        {
            // retrieve the current price from the database
            $price = $this->controller->calculateFinalPrice($_SESSION[quoteId]);

            // display the current price of the selected quote
            echo "<br><b>Current Total before Discounts: </b>$" .$price;
        }

       /*******************************************************************
            FUNCTION:   QuoteStore::updateQuote
            ARGUMENTS:  none
            PURPOSE:    Allows the user to mark a quote as sanctioned.
                        Upon submission, the user will be prompted that an
                        email confirmation has been sent to the customer
        *******************************************************************/
        public function callUpDateQuote($quoteId)
        {
            $this->controller->updateQuote($quoteId);
        }
        public function updateQuote()
        {
            // display the Sanction Quote submit button
            print ('<br><h3>Quote Sanctioning</h3><hr><br>
                    <form method=post  onsubmit="emailSent()">
                    <input type="hidden" name="type" value="Mark Sanctioned">
                    <input type="submit" name="end" value="Mark quote as Sanctioned">
                    </form>
                ');
        } // end function
    }
?>