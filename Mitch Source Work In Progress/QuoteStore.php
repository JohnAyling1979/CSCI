<?php
    //class used to communicate with the quote database
    class QuoteStore
    {
        /*******************************************************************
            FUNCTION:   QuoteStrore::finalizeQuote
            ARGUMENTS:  none
            RETURNS:    a bool value for wether a quote was saved
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

        public function getFinalizedQuote()
        {
            //connect to the database
            $db = connect("courses","z981329","z981329","1979Jul29");

            // Retrieve Quotes that are marked as Finalized
            $sql = "SELECT quoteId FROM Quote WHERE isFinalized = 1;";
            $query = $db->query($sql);

            // return the results
            return $query->fetchAll();
            $db = null;
        }

        public function addLineItems()
        {
            //connect to the database
            $db = connect("courses","z981329","z981329","1979Jul29");

            // insert line items into the quote
            $sql = "INSERT INTO LineItem (quoteId, description, price) VALUES ('$_POST[quoteId]', '$_POST[addDescription]', '$_POST[addPrice]');";
            $db->exec($sql);
            $db = null;
        }

        public function editLineItems()
        {
            //connect to the database
            $db = connect("courses","z981329","z981329","1979Jul29");

            // insert line items into the quote
            $sql = "UPDATE LineItem SET quoteId='$_POST[quoteId]',description='$_POST[editDescription]',price='$_POST[editPrice]' WHERE lineId='$_POST[lineID]';";
            $db->exec($sql);
            $db = null;
        }
    }
?>