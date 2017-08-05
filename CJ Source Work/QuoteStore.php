<?php
    //class used to communicate with the quote database
    class QuoteStore
    {
        /*******************************************************************
            FUNCTION:   SAstore::connect()
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
            FUNCTION:   getQuotsLine
            ARGUMENTS:  none	
            RETURNS:    all the lines of a quote
            USAGE:      Retreave the line of the quots
        *******************************************************************/
		public function getQuotsLine($quoteId)
        {
			//connects to database
            $db=$this->connect();
            //creates query
            $query="select * from LineItem where quoteId = '$quoteId';";
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