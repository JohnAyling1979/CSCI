<?php
    //class used to communicate with the quote database
    class QuoteStore
    {
        /*******************************************************************
            FUNCTION:   QuoteStore::finalizeQuote
            ARGUMENTS:  none
            RETURNS:    a bool value for whether a quote was saved
            USAGE:      To save a quote to the database
        *******************************************************************/
        public function finalizeQuote()
        {
            //status of quote
            $isCreated=0;

            //connect to the database
            $db=connect("courses","z981329","z981329","1979Jul29");

            //insert statment
            $into="insert into Quote(customerName,customerAddress,customerCity,customerEmail,isFinalized,salesAssociate)
                   values('$_SESSION[customerName]','$_SESSION[customerAdd]','$_SESSION[customerCity]','$_POST[email]',1,'$_SESSION[user]')";
 
            //execute the statement and check if the row was added
            if($db->exec($into)>0)
            {
                //change the status
                $isCreated=1;

                //get id number of the quote
                $quote=$db->lastInsertId();

                //set the first line item variable
                $n=0;
                $desc="desc".$n;
                $price="price".$n;
                $secret="secret".$n;

                //while there are lines
                while(isset($_POST[$desc]))
                {
                    //insert statement
                    $into="insert into LineItem(quoteId,description,price,secretNote)
                           values($quote,'$_POST[$desc]','$_POST[$price]','$_POST[$secret]')";

                    //execute the statement
                    $db->exec($into);

                    //move to next line
                    $n=$n+1;
                    $desc="desc".$n;
                    $price="price".$n;
                    $secret="secret".$n;
                }
            }
            //return status
            return $isCreated;
        }

        /*******************************************************************
            FUNCTION:   QuoteStore::getFinalizeQuote
            ARGUMENTS:  none
            RETURNS:    SQL query of quotes marked as finalized
            USAGE:      Displays all finalized quotes
        *******************************************************************/
        public function getFinalizedQuote()
        {
            //connect to the database
            $db = connect("courses","z981329","z981329","1979Jul29");

            // Retrieve Quotes that are marked as Finalized
            $sql = "SELECT quoteId, customerName FROM Quote WHERE isFinalized = 1;";
            $query = $db->query($sql);

            // return the results
            return $query->fetchAll();

            // disconnect from the database
            $db = null;
        }

        /*******************************************************************
            FUNCTION:   QuoteStore::calculatePrice
            ARGUMENTS:  none
            RETURNS:    SQL query of quotes marked as finalized
            USAGE:      Displays all finalized quotes
        *******************************************************************/
        public function calculatePrice($quoteId)
        {
            //connect to the database
            $db = connect("courses","z981329","z981329","1979Jul29");

            // Retrieve the currentPrice of the selected quote
            $sql = "SELECT currentPrice FROM Quote WHERE quoteId = '$quoteId';";
            $query = $db->query($sql);
            
            // return the results
            return $query->fetch();

            // disconnect from the database
            $db = null;
        }

        /*******************************************************************
            FUNCTION:   QuoteStore::addLineItems
            ARGUMENTS:  quoteId, description, price
            RETURNS:    none
            USAGE:      Inserts new line items with prices and descriptions
                        into the selected quote
        *******************************************************************/
        public function addLineItems($quoteId,$description,$price)
        {
            //connect to the database
            $db = connect("courses","z981329","z981329","1979Jul29");

            // insert line items into the quote
            $sql1 = "INSERT INTO LineItem (quoteId, description, price) VALUES ('$quoteId', '$description', '$price');";
            $db->exec($sql1);

            // add price of the line item to the current price
            $sql2 = "UPDATE Quote SET currentPrice = (currentPrice + '$price') WHERE quoteId='$quoteId';";
            $db->exec($sql2);

            // disconnect from the database
            $db = null;
        }

        /*******************************************************************
            FUNCTION:   QuoteStore::editLineItems
            ARGUMENTS:  quoteId, lineId, description, price
            RETURNS:    none
            USAGE:      Updates the description and price of a line item in
                        the selected quote
        *******************************************************************/
        public function editLineItems($quoteId,$lineId,$description,$price)
        {
            //connect to the database
            $db = connect("courses","z981329","z981329","1979Jul29");

            // update only the description
            if ($description)
            {
                $sql1 = "UPDATE LineItem SET quoteId='$quoteId', description='$description' WHERE lineId='$lineId';";
                $db->exec($sql1);
            }

            if ($price)
            {
                // subtract the old price of the selected line item from the current price of the quote
                $sql2 = "UPDATE Quote SET currentPrice = currentPrice - (SELECT price FROM LineItem WHERE lineId='$lineId');";
                $db->exec($sql2);

                // update the line item description and price
                $sql3 = "UPDATE LineItem SET quoteId='$quoteId', price='$price' WHERE lineId='$lineId';";
                $db->exec($sql3);

                // add the new price of the selected line item to the current price of the quote
                $sql4 = "UPDATE Quote SET currentPrice = currentPrice + (SELECT price FROM LineItem WHERE lineId='$lineId');";
                $db->exec($sql4);
            }

            // disconnect from the database
            $db = null;
        }

        /*******************************************************************
            FUNCTION:   QuoteStore::removeLineItems
            ARGUMENTS:  lineId
            RETURNS:    none
            USAGE:      Removes a line item from the selected quote
        *******************************************************************/
        public function removeLineItems($quoteId, $lineId)
        {
            //connect to the database
            $db = connect("courses","z981329","z981329","1979Jul29");

            // update the current price of the quote, less line item price
            $sql2 = "UPDATE Quote SET currentPrice = currentPrice - (SELECT price FROM LineItem WHERE lineId='$lineId');";
            $db->exec($sql2);

            // delete the line item from the quote
            $sql3 = "DELETE FROM LineItem WHERE lineId='$lineId';";
            $db->exec($sql3);

            // disconnect from the database
            $db = null;
        }

        /*******************************************************************
            FUNCTION:   QuoteStore::addSecretNote
            ARGUMENTS:  lineId, secretNote
            RETURNS:    none
            USAGE:      Adds a secret note to line items do not have a
                        secret note attached
        *******************************************************************/
        public function addSecretNote($lineId,$secretNote)
        {
            //connect to the database
            $db = connect("courses","z981329","z981329","1979Jul29");

            // update the secret note based on the item ID
            $sql = "UPDATE LineItem SET secretNote='$secretNote' WHERE lineId='$lineId';";
            $db->exec($sql);

            // disconnect from the database
            $db = null;
        }

        /*******************************************************************
            FUNCTION:   QuoteStore::editSecretNote
            ARGUMENTS:  lineId, secretNote
            RETURNS:    none
            USAGE:      Edits a secret note to line items that have a
                        secret note already attached
        *******************************************************************/
        public function editSecretNote($quoteId,$lineId,$secretNote)
        {
            //connect to the database
            $db = connect("courses","z981329","z981329","1979Jul29");

            // update the secret note based on the item ID
            $sql = "UPDATE LineItem SET quoteId='$quoteId', secretNote='$secretNote' WHERE lineId='$lineId';";
            $db->exec($sql);

            // disconnect from the database
            $db = null;
        }

        /*******************************************************************
            FUNCTION:   QuoteStore::calculateDiscounts
            ARGUMENTS:  quoteId, amount, percentage
            RETURNS:    none
            USAGE:      Calculates a discount as either a dollar amount or
                        as a percentage
        *******************************************************************/
        public function calculateDiscounts($quoteId,$amount,$percentage)
        {
            //connect to the database
            $db = connect("courses","z981329","z981329","1979Jul29");

            // if a dollar amount was entered, calculate the discount as a dollar amount
            if ($amount)
            {
                $sql = "UPDATE Quote SET currentPrice = (currentPrice - '$amount') WHERE quoteId='$quoteId';";
                $db->exec($sql);
            }

            // else a percentage was entered, calculate the discount as a percentage
            else
            {
                $sql = "UPDATE Quote SET currentPrice = (currentPrice - ((currentPrice * '$percentage') / 100)) WHERE quoteId='$quoteId';";
                $db->exec($sql);
            }

            // disconnect from the database
            $db = null;
        }

        /*******************************************************************
            FUNCTION:   QuoteStore::calculateFinalPrice
            ARGUMENTS:  quoteId
            RETURNS:    currentPrice
            USAGE:      Displays the current quote price in the discount
                        quote area
        *******************************************************************/
        public function calculateFinalPrice($quoteId)
        {
            //connect to the database
            $db = connect("courses","z981329","z981329","1979Jul29");

            // Retrieve the currentPrice of the selected quote
            $sql = "SELECT currentPrice FROM Quote WHERE quoteId = '$quoteId';";
            $query = $db->query($sql);
            
            // return the results
            return $query->fetch();

            // disconnect from the database
            $db = null;
        }

        /*******************************************************************
            FUNCTION:   QuoteStore::updateQuote
            ARGUMENTS:  quoteId
            RETURNS:    none
            USAGE:      Sets the quote as sanction by a boolean value
        *******************************************************************/
        public function updateQuote($quoteId)
        {
            //connect to the database
            $db = connect("courses","z981329","z981329","1979Jul29");
            
            // update the sanction status of the quote to sanctioned
            $sql = "UPDATE Quote SET isSanctioned=1, isFinalized=0 WHERE quoteId='$quoteId';";
            $db->exec($sql);

            // disconnect from the database
            $db = null;
        }
    }
?>