<?php
    //class to commuticate between the other classes
    class CreateQuoteController
    {
    	var $SA;
    	var $DBI;
        var $quote;

        /*******************************************************************
            FUNCTION:   CreateQuoteController::constructor
            ARGUMENTS:  none
            RETURNS:    none
            USAGE:      creates instances to SAstore,LegacyDatabase and
                        quotestore 
        *******************************************************************/
    	public function __construct()
        {
    		$this->SA = new SAstore;
    		$this->DBI = new LegacyDatabaseInterface;
            $this->quote= new QuoteStore;
    	}

        /*******************************************************************
            FUNCTION:   CreateQuoteController::getPass
            ARGUMENTS:  $SA: contains the SAstore instance
                        $name: Name of the associate
            RETURNS:    encrypted password
            USAGE:      To request the password from the SAstore
        *******************************************************************/
        public function getPass($name)
        {
            $info=$this->SA->getSA($name);
            return $info[password];
        }

        /*******************************************************************
            FUNCTION:   CreateQuoteController::getCustomerInfo
            ARGUMENTS:  $DBI: contains the LegacyDatabaseInterface instance
                        $id: the id number of the customer for the info to
                             find
            RETURNS:    A row containing the customer info
            USAGE:      To request the customer info from the 
                        legacyDatabaseInterface for one customer
        *******************************************************************/
        public function getCustomerInfo($id)
        {
            return $this->DBI->getCustomerInfo($id);
        }


        /*******************************************************************
            FUNCTION:   CreateQuoteController::getCustomerNames
            ARGUMENTS:  $DBI: contains the LegacyDatabaseInterface instance
            RETURNS:    A PDO statemtn containing all the customer's names
            USAGE:      To request the customer's names from the 
                        legacyDatabaseInterface
        *******************************************************************/
        public function getCustomerNames()
        {
            return $this->DBI->getCustomerNames();
        }

        /*******************************************************************
            FUNCTION:   CreateQuoteController::finalizeQuote
            ARGUMENTS:  $quote: The QuoteStore instance
            RETURNS:    A bool that tells wether a quote was saved
            USAGE:      To request the customer's names from the 
                        legacyDatabaseInterface
        *******************************************************************/
        public function finalizeQuote()
        {
            return $this->quote->finalizeQuote();
        }
    }
?>
