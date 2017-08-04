<?php
    //class to commuticate between the other classes
    class CreateQuoteController
    {
        //so the controller can call the legacyDatebase,quotestore,and SAstore
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
            //creates instances of the other classes when controller is created
    		$this->SA = new SAstore;
    		$this->DBI = new LegacyDatabaseInterface;
            $this->quote= new QuoteStore;
    	}

        /*******************************************************************
            FUNCTION:   CreateQuoteController::getPass
            ARGUMENTS:  $name: Name of the associate
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
            ARGUMENTS:  $id: the id number of the customer for the info to
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
            ARGUMENTS:  none
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
            ARGUMENTS:  $customerName: Name of the customer
                        $custId: unique customer #
                        $customerAdd: customer address
                        $customerCity: customer city
                        $email: customer email
                        $user: sales associate name
            RETURNS:    A bool that tells wether a quote was saved
            USAGE:      To request the customer's names from the 
                        legacyDatabaseInterface
        *******************************************************************/
        public function finalizeQuote($customerName,$custId,$customerAdd,$customerCity,$email,$user)
        {
            return $this->quote->finalizeQuote($customerName,$custId,$customerAdd,$customerCity,$email,$user);
        }
    }
?>
