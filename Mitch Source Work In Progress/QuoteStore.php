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
            $sql = "SELECT quoteId, customerName FROM Quote WHERE isFinalized = 1;";
            $query = $db->query($sql);

            // return the results
            return $query->fetchAll();
            $db = null;
        }

        public function calculatePrice()
        {
            //connect to the database
            $db = connect("courses","z981329","z981329","1979Jul29");

            // calculate the price of the items of the quote
            $sql = $db->query("SELECT SUM(price) FROM LineItem WHERE quoteId = '$SESSION($quoteId)';");
            
            while ($total = $sql->fetch(PDO::FETCH_ASSOC))
            {
                $totalPrice += $total[0];
            }

            return $totalPrice;

            // disconnect from the database
            $db = null;
        }

        public function addLineItems($quoteId,$description,$price)
        {
            //connect to the database
            $db = connect("courses","z981329","z981329","1979Jul29");

            // insert line items into the quote
            $sql = "INSERT INTO LineItem (quoteId, description, price) VALUES ('$quoteId', '$description', '$price');";
            $db->exec($sql);

            // disconnect from the database
            $db = null;
        }

        public function editLineItems($quoteId,$lineId,$description,$price)
        {
            //connect to the database
            $db = connect("courses","z981329","z981329","1979Jul29");

            // update only the description
            if ($description)
            {
                $sql = "UPDATE LineItem SET quoteId='$quoteId', description='$description' WHERE lineId='$lineId';";
                $db->exec($sql);
            }

            // update only the price
            if ($price)
            {
                $sql = "UPDATE LineItem SET quoteId='$quoteId', price='$price' WHERE lineId='$lineId';";
                $db->exec($sql);
            }

            // update both the description and the price
            if ($description && $price)
            {
                $sql = "UPDATE LineItem SET quoteId='$quoteId', description='$description', price='$price' WHERE lineId='$lineId';";
                $db->exec($sql);
            }

            // disconnect from the database
            $db = null;
        }

        public function removeLineItems($lineId)
        {
            //connect to the database
            $db = connect("courses","z981329","z981329","1979Jul29");

            // delete the line item from the quote
            $sql = "DELETE FROM LineItem WHERE lineId='$lineId';";
            $db->exec($sql);

            // disconnect from the database
            $db = null;
        }

        public function addSecretNote($lineId,$secretNote)
        {
            //connect to the database
            $db = connect("courses","z981329","z981329","1979Jul29");

            // update the secret note based on the item ID
            $sql = "UPDATE LineItem SET secretNote='$secretNote' WHERE lineId='$lineId';";
            //$sql = "INSERT INTO LineItem (quoteId, secretNote) VALUES ('$quoteId', '$secretNote');";
            $db->exec($sql);

            // disconnect from the database
            $db = null;
        }

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

        public function updateQuote($quoteId)
        {
            //connect to the database
            $db = connect("courses","z981329","z981329","1979Jul29");
            
            // update the sanction status of the quote to yes
            $sql = "UPDATE Quote SET isSanctioned=1, isFinalized=0 WHERE quoteId='$quoteId';";
            $db->exec($sql);

            // disconnect from the database
            $db = null;
        }
    }
?>