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
        public function finalizeQuote($customerName,$custId,$customerAdd,$customerCity,$email,$user)
        {
            //status of quote
            $isCreated=0;

            //connect to the database
            $db=$this->connect();

            //insert statment
            $into=$db->prepare("insert into Quote(customerName,custId,customerAddress,customerCity,customerEmail,isFinalized,salesAssociate)
                   values(:customerName,:custId,:customerAdd,:customerCity,:email,1,:user)");

            $into->bindParam(":customerName",$customerName);
            $into->bindParam(":custId",$custId);
            $into->bindParam(":customerAdd",$customerAdd);
            $into->bindParam(":customerCity",$customerCity);
            $into->bindParam(":email",$email);
            $into->bindParam(":user",$user);

            //execute the statement and check if the row was added
            if($into->execute())
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
                $currentPrice=0;
                //while there are lines
                while(isset($_POST[$desc]))
                {
                    //checks if the row is empty
                    if($_POST[$desc]!="" || $_POST[$price]!="" || $_POST[$secret]!="")
                    {
                        //insert statement
                        $into="insert into LineItem(quoteId,description,price,secretNote)
                               values($quote,'$_POST[$desc]','$_POST[$price]','$_POST[$secret]')";

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

            $update="update Quote set currentPrice=$currentPrice where quoteId=$quote";
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
    }
?>
