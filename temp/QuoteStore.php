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
		
		//used to find a quote
        public function findQuote()
        {
			//connects to database
            $db=$this->connect();
            //creates query
            $query="select * from quote WHERE name LIKE '%" . $name . "%';";
            //runs query
            $stmt=$db->query($query);
            
			$saList = array ();
		
			if ($stmt->num_rows > 0) 
			{
				while ( $row = $stmt->fetch_assoc () ) 
				{
					$saList [$row ['quoteId']] = new quote ( $row );
				}
			} 
			else 
			{
				trace ( "0 quote records found" );
			}
			return $saList;
			$db = null;
        }
        //use to retreave the quote by quoteId from search
        public function getQuote($quoteId)
        {
			//connects to database
            $db=$this->connect();
            // Retrieve Quotes that are marked as Finalized
            $sql = "SELECT * FROM Quote WHERE quoteId = " . $quoteId . ";";
            //runs query
            $stmt=$db->query($query);
            //gets first row
            $row=$stmt->fetch();
            //returns the quote
            return $row;
			// disconnect from the database
            $db = null;
		}
    }
?>