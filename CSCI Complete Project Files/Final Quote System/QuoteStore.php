<?php
    //class used to communicate with the quote database
    class QuoteStore
    {
        /*******************************************************************
            FUNCTION:   QuoteStore::connect()
            ARGUMENTS:  none
            RETURNS:    a PDO object
            USAGE:      to create a connection to a database
        *******************************************************************/
        private function connect()
        {
            $host="courses";
            $DB="z981329";
            $user="z981329";
            $password="1979Jul29";

            //creates the dsn for the PDO
            $dsn="mysql:dbname=".$DB.";host=".$host;
    
            //trys the connection
            try
            {
                $db=new PDO($dsn,$user,$password);
            }
            //if there are errors display error and exit
            catch(PDOException $e)
            {
                echo "Connection failed: Database can not be reached<br>".$e->getMessage();
                die();
            }
    
            //returns PDO object
            return $db;
        }
        
        /*******************************************************************
            FUNCTION:   QuoteStrore::finalizeQuote
            ARGUMENTS:  $customerName: Name of the customer
                        $custId: unique customer #
                        $customerAdd: customer address
                        $customerCity: customer city
                        $email: customer email
                        $user: sales associate name
            RETURNS:    a bool value for wether a quote was saved
            USAGE:      To save a quote to the database
        *******************************************************************/
        public function finalizeQuote($customerName,$custId,$customerAddress,$customerCity,$customerEmail,$salesAssociate)
        {
            //status of quote
            $isCreated=0;

            //connect to the database
            $db=$this->connect();

            //insert statment
            $into='insert into Quote(customerName,custId,customerAddress,customerCity,customerEmail,isFinalized,salesAssociate)
                   values("'.$customerName.'","'.$custId.'","'.$customerAddress.'","'.$customerCity.'","'.$customerEmail.'","1","'.$salesAssociate.'")';

            //execute the statement and check if the row was added
            if($db->exec($into)>0)
            {
                //change the status
                $isCreated=1;

                //get id number of the quote
                $quoteId=$db->lastInsertId();

                //set the first line item variable
                $n=0;
                $desc="desc".$n;
                $price="price".$n;
                $secret="secret".$n;
                $currentPrice=0;
                //while there are lines
                while(isset($_POST[$desc]))
                {
                    //checks if the row is empty
                    if($_POST[$desc]!="" || $_POST[$price]!="" || $_POST[$secret]!="")
                    {
                        //insert statement
                        $into='insert into LineItem(quoteId,description,price,secretNote)
                               values("'.$quoteId.'","'.$_POST[$desc].'","'.$_POST[$price].'","'.$_POST[$secret].'")';
                        //execute the statement
                        $db->exec($into);
                        $currentPrice=$currentPrice+$_POST[$price];
                    }
                    //move to next line
                    $n=$n+1;
                    $desc="desc".$n;
                    $price="price".$n;
                    $secret="secret".$n;
                }
            }

            // set the current price of the quote
            $update="update Quote set currentPrice=$currentPrice where quoteId=$quoteId";
            $db->query($update);
            
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
            $db = $this->connect();

            // Retrieve Quotes that are marked as Finalized
            $sql = "SELECT quoteId, customerName FROM Quote WHERE isFinalized = 1;";
            $query = $db->query($sql);

            // return the results
            return $query->fetchAll();
        }

        /*******************************************************************
            FUNCTION:   QuoteStore::getSanctionedQuotes
            ARGUMENTS:  none
            RETURNS:    a PDO statment containing the sactioned quotes
            USAGE:      to find all the sactioned quotes
        *******************************************************************/
        public function getSanctionedQuotes()
        {
            //connect to the database
            $db=$this->connect();

            // select the quoteId and customerName that are marked as sanctioned
            $query="SELECT quoteId, customerName FROM Quote WHERE isSanctioned";

            // return the results of the query
            return $db->query($query);
        }

        /*******************************************************************
            FUNCTION:   QuoteStore::getQuote
            ARGUMENTS:  $quoteId: unique id of the quote
            RETURNS:    an array containing the quote information
            USAGE:      to get the information of a quote
        *******************************************************************/
        public function getQuote($quoteId)
        {
            // connect to the database
            $db=$this->connect();

            // select all quote information based on the quoteId
            $query="SELECT * FROM Quote WHERE quoteId=$quoteId";

            // store the query results
            $stmt=$db->query($query);

            // fetch and return the results
            return $stmt->fetch();
        }
        
        /*******************************************************************
            FUNCTION:   QuoteStore::getLineItems()
            ARGUMENTS:  $quoteId: unique id of the quote
            RETURNS:    a pdo statement contain all the line items
            USAGE:      to get the line items attached to the quote
        *******************************************************************/
        public function getLineItems($quoteId)
        {
            // connect to the database
            $db=$this->connect();

            // select all of the line items from a quote based on it's id
            $query="SELECT * FROM LineItem WHERE quoteId=$quoteId";

            // return the results
            return $db->query($query);
        }

        /*******************************************************************
            FUNCTION:   QuoteStore::createPurchaseOrder
            ARGUMENTS:  $quoteId: unique id of the quote
                        $price: new discounted price
            RETURNS:    none
            USAGE:      to update the cost of the quote an change it to a PO
        *******************************************************************/
        public function createPurchaseOrder($quoteId,$price)
        {
            // connect to the database
            $db=$this->connect();

            // update the price of the quote based on the quoteId
            $query="UPDATE Quote SET currentPrice=$price WHERE quoteId=$quoteId";
            $db->query($query);

            // cahnge a sanctioned quote status to a 0
            $query="UPDATE Quote SET isSanctioned=0 WHERE quoteId=$quoteId";
            $db->query($query);

            // chnage the quote to a purchase order
            $query="UPDATE Quote SET isPO=1 WHERE quoteId=$quoteId";
            $db->query($query);
        }

        /*******************************************************************
            FUNCTION:   QuoteStore::setDateAndCommission
            ARGUMENTS:  $quoteId: unique id of the quote
                        $processDay: process day for the quote
                        $commission: commission value
            RETURNS:    none
            USAGE:      to set the proccess date and commission
        *******************************************************************/
        public function setDateAndCommission($quoteId,$processDay,$commission)
        {
            // connect to the database
            $db=$this->connect();

            // set the processing date of the purchase order
            $query="UPDATE Quote SET processingDate='$processDay' WHERE quoteId=$quoteId";
            $db->query($query);

            // set the commission for the quote
            $query="UPDATE Quote SET commission=$commission WHERE quoteId=$quoteId";
            $db->query($query);
        }
        
        /*******************************************************************
            FUNCTION:   getCustomerNames
            ARGUMENTS:  none
            RETURNS:    name of customers in a list
            USAGE:      To be able to retreve a list of Customers
        *******************************************************************/
		public function getCustomerNames()
        {
			//connects to database
            $db=$this->connect();
            
            //creates query grouped by customer id
            $query="SELECT * FROM Quote GROUP BY custId;";

            // return the results of the query
			return $db->query($query);
        }

		/*******************************************************************
            FUNCTION:   getQuotsStatus
            ARGUMENTS:  none	
            RETURNS:    all the quots by a given status
            USAGE:      To be able to search for quots by a given status
        *******************************************************************/
		public function getQuotsStatus($Stype)
        {
            // set the variable "one" equal to 1
			$one="1";

			//connect to the database
            $db=$this->connect();

            //Select all quotes that have a Sales Type of 1
            $query="SELECT * FROM Quote WHERE " . $Stype . " = '$one';";

            // return the results
			return $db->query($query);
        }
		
		/*******************************************************************
            FUNCTION:   getQuotsByCust
            ARGUMENTS:  none	
            RETURNS:    all the quots by a given status
            USAGE:      To be able to search for quots by a given status
        *******************************************************************/
		public function getQuotsByCust($custId)
        {
			//connect to the database
            $db=$this->connect();

            //select all quotes by customer Id
            $query="SELECT * FROM Quote WHERE custId = '$custId';";

            // return the results
			return $db->query($query);
        }
		
		/*******************************************************************
            FUNCTION:   getQuotsBySA
            ARGUMENTS:  none	
            RETURNS:    all the quots by a given status
            USAGE:      To be able to search for quots by a given status
        *******************************************************************/
		public function getQuotsBySA($assoc)
        {
			//connect to the database
            $db=$this->connect();

            //select all of the sales associates that are like "assoc"
            $query="SELECT * FROM Quote WHERE salesAssociate LIKE  '$assoc';";

            // return the results
			return $db->query($query);
        }
		
		/*******************************************************************
            FUNCTION:   SAstore::getFinalQuote
            ARGUMENTS:  $name: Name of the associate
            RETURNS:    1 quote
            USAGE:      to view a quote
        *******************************************************************/
		
		public function getFinalQuote($quoteId)
        {
            //connect to the database
            $db=$this->connect();

            //select all quotes by quote ID
            $query="SELECT * FROM Quote WHERE quoteId = '$quoteId';";

            // return the results
            return $db->query($query);
        }
        
        /*******************************************************************
            FUNCTION:   getDates
            ARGUMENTS:  none	
            RETURNS:    all quots in date range
            USAGE:      Get quots in a date range
        *******************************************************************/
		public function getDates($start,$end)
        {
			//connect to the database
            $db=$this->connect();

            // set the date range
			$new_start = date('Y/n/j', strtotime($start));
			$new_end = date('Y/n/j', strtotime($end));
			
            //select a quote that falls within the start and end date range
			$query="SELECT * FROM Quote WHERE isPO AND STR_TO_DATE(processingDate,'%Y/%m/%d') > STR_TO_DATE('$new_start','%Y/%m/%d') AND STR_TO_DATE(processingDate,'%Y/%m/%d') < STR_TO_DATE('$new_end','%Y/%m/%d');";
            
			return $db->query($query);
        }
		/*******************************************************************
			FUNCTION:   getSANames
            ARGUMENTS:  none
            RETURNS:    name of Sales Associate in a list
            USAGE:      To be able to retreve a list of SA
        *******************************************************************/
		public function getSANames()
        {
			//connect to the database
            $db=$this->connect();

            //select a sales associate by quote id
            $query="SELECT* FROM Quote GROUP BY salesAssociate;";

            // return the results
			return $db->query($query);
		}

        /*******************************************************************
            FUNCTION:   QuoteStore::calculatePrice
            ARGUMENTS:  quoteId
            RETURNS:    SQL query of quotes marked as finalized
            USAGE:      Displays all finalized quotes
        *******************************************************************/
        public function calculatePrice($quoteId)
        {
            //connect to the database
            $db = $this->connect();

            // Retrieve the currentPrice of the selected quote
            $sql = "SELECT currentPrice FROM Quote WHERE quoteId = '$quoteId';";
            $query = $db->query($sql);
            
            // return the results
            return $query->fetch();
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
            $db = $this->connect();

            // insert line items into the quote
            $sql1 = "INSERT INTO LineItem (quoteId, description, price) VALUES ('$quoteId', '$description', '$price');";
            $db->exec($sql1);

            // add price of the line item to the current price
            $sql2 = "UPDATE Quote SET currentPrice = (currentPrice + '$price') WHERE quoteId='$quoteId';";
            $db->exec($sql2);
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
            $db = $this->connect();

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
        }

        /*******************************************************************
            FUNCTION:   QuoteStore::removeLineItems
            ARGUMENTS:  quoteId, lineId
            RETURNS:    none
            USAGE:      Removes a line item from the selected quote
        *******************************************************************/
        public function removeLineItems($quoteId, $lineId)
        {
            //connect to the database
            $db = $this->connect();

            // update the current price of the quote, less line item price
            $sql2 = "UPDATE Quote SET currentPrice = currentPrice - (SELECT price FROM LineItem WHERE lineId='$lineId');";
            $db->exec($sql2);

            // delete the line item from the quote
            $sql3 = "DELETE FROM LineItem WHERE lineId='$lineId';";
            $db->exec($sql3);
        }

        /*******************************************************************
            FUNCTION:   QuoteStore::viewEmptySecretNote
            ARGUMENTS:  lineId, secretNote
            RETURNS:    none
            USAGE:      Adds a secret note to line items do not have a
                        secret note attached
        *******************************************************************/
        public function viewEmptySecretNote($quoteId)
        {
            //connect to the database
            $db = $this->connect();

            // select any line item from the quote that does not have a secret note attached
            $query="SELECT lineId, description FROM LineItem WHERE quoteId = '$quoteId' AND secretNote = '';";
            
            // return the results
            return $db->query($query);
        }

        /*******************************************************************
            FUNCTION:   QuoteStore::viewAttachedSecretNote
            ARGUMENTS:  lineId, secretNote
            RETURNS:    none
            USAGE:      Adds a secret note to line items do not have a
                        secret note attached
        *******************************************************************/
        public function viewAttachedSecretNote($quoteId)
        {
            //connect to the database
            $db = $this->connect();

            // select any line item from the quote that currently has a secret note attached
            $query="SELECT lineId, description, secretNote FROM LineItem WHERE quoteId = '$quoteId' AND secretNote != '';";;
            
            // return the results
            return $db->query($query);
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
            $db = $this->connect();

            // update the secret note based on the item ID
            $sql = "UPDATE LineItem SET secretNote='$secretNote' WHERE lineId='$lineId';";
            $db->exec($sql);
        }

        /*******************************************************************
            FUNCTION:   QuoteStore::editSecretNote
            ARGUMENTS:  quoteId, lineId, secretNote
            RETURNS:    none
            USAGE:      Edits a secret note to line items that have a
                        secret note already attached
        *******************************************************************/
        public function editSecretNote($lineId,$secretNote)
        {
            //connect to the database
            $db = $this->connect();

            // update the secret note based on the item ID
            $sql = "UPDATE LineItem SET secretNote='$secretNote' WHERE lineId='$lineId';";
            $db->exec($sql);
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
            $db = $this->connect();

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
            $db = $this->connect();

            // Retrieve the currentPrice of the selected quote
            $sql = "SELECT currentPrice FROM Quote WHERE quoteId = '$quoteId';";
            $query = $db->query($sql);
            
            // return the results
            return $query->fetch();
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
            $db = $this->connect();
            
            // update the sanction status of the quote to sanctioned
            $sql = "UPDATE Quote SET isSanctioned=1, isFinalized=0 WHERE quoteId='$quoteId';";
            $db->exec($sql);
        }		
    }
?>
