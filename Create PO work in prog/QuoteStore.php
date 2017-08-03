<?php
    //class used to communicate with the quote database
    class QuoteStore
    {
        /*******************************************************************
            FUNCTION:   connect()
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

        public function getSanctionedQuotes()
        {
            $DB=$this->connect();
            $query="select quoteId,customerName from Quote where isSanctioned";

            return $DB->query($query);
        }

        public function getQuote($quoteId)
        {
            $DB=$this->connect();
            $query="select * from Quote where quoteId=$quoteId";

            $stmt=$DB->query($query);

            return $stmt->fetch();

        }

        public function getLineItems($quoteId)
        {
            $DB=$this->connect();
            $query="select * from LineItem where quoteId=$quoteId";
            
            return $DB->query($query);
        }

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

        public function setDateAndCommission($quoteId,$processDay,$commission)
        {
            $DB=$this->connect();

            $query="update Quote set processingDate='$processDay' where quoteId=$quoteId";
            $DB->query($query);

            $query="update Quote set commission=$commission where quoteId=$quoteId";
            $DB->query($query);
        }
    }
?>
