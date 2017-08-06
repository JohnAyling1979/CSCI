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

            $update="update Quote set currentPrice=$currentPrice where quoteId=$quoteId";
            $db->query($update);
            //return status
            return $isCreated;
        }

        /*******************************************************************
            FUNCTION:   QuoteStore::getSanctionedQuotes
            ARGUMENTS:  none
            RETURNS:    a PDO statment containing the sactioned quotes
            USAGE:      to find all the sactioned quotes
        *******************************************************************/
        public function getSanctionedQuotes()
        {
            $DB=$this->connect();
            $query="select quoteId,customerName from Quote where isSanctioned";

            return $DB->query($query);
        }

        /*******************************************************************
            FUNCTION:   QuoteStore::getQuote
            ARGUMENTS:  $quoteId: unique id of the quote
            RETURNS:    an array containing the quote information
            USAGE:      to get the information of a quote
        *******************************************************************/
        public function getQuote($quoteId)
        {
            $DB=$this->connect();
            $query="select * from Quote where quoteId=$quoteId";

            $stmt=$DB->query($query);

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
            $DB=$this->connect();
            $query="select * from LineItem where quoteId=$quoteId";
            
            return $DB->query($query);
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
            $DB=$this->connect();

            $query="update Quote set currentPrice=$price where quoteId=$quoteId";
            $DB->query($query);

            $query="update Quote set isSanctioned=0 where quoteId=$quoteId";
            $DB->query($query);

            $query="update Quote set isPO=1 where quoteId=$quoteId";
            $DB->query($query);
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
            $DB=$this->connect();

            $query="update Quote set processingDate='$processDay' where quoteId=$quoteId";
            $DB->query($query);

            $query="update Quote set commission=$commission where quoteId=$quoteId";
            $DB->query($query);
        }

        public function updateQuote()
        {
        }

        public function findQuote()
        {
        }

        public function addLineItems()
        {
        }

        public function removeLineItems()
        {
        }

        public function discountPercentage()
        {
        }

        public function discountAmount()
        {
        }

        public function addSecretNote()
        {
        }

        public function getFinizedQuote()
        {
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
            $db=$this->connect();;
            //creates query
            $query="select * from Quote group by custId;";
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
			$one="1";
			//connects to database
            $db=$this->connect();;
            //creates query
            $query="select * from Quote where " . $Stype . " = '$one';";
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
			//connects to database
            $db=$this->connect();;
            //creates query
            $query="select * from Quote where custId = '$custId';";
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
			//connects to database
            $db=$this->connect();;
            //creates query
            $query="select * from Quote where salesAssociate LIKE  '$assoc';";
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
            //connects to database
            $db=$this->connect();
            //creates query
            $query="select * from Quote where quoteId = '$quoteId';";
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
			//connects to database
            $db=$this->connect();;
			$new_start = date('Y/n/j', strtotime($start));
			$new_end = date('Y/n/j', strtotime($end));
			
            //creates query
			$query="select * from Quote where isPO and STR_TO_DATE(processingDate,'%Y/%m/%d') > STR_TO_DATE('$new_start','%Y/%m/%d') and STR_TO_DATE(processingDate,'%Y/%m/%d') < STR_TO_DATE('$new_end','%Y/%m/%d');";
			return $db->query($query);
        }
    }
?>
