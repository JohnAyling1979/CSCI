<?php
    //class to commuticate between the other classes
    class CreateQuoteController
    {
        /*******************************************************************
            FUNCTION:   CreateQuoteController::getPass
            ARGUMENTS:  $SA: contains the SAstore instance
                        $name: Name of the associate
            RETURNS:    encrypted password
            USAGE:      To request the password from the SAstore
        *******************************************************************/
        public function getPass($SA,$name)
        {
            $info=$SA->getSA($name);
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
        public function getCustomerInfo($DBI,$id)
        {
            return $DBI->getCustomerInfo($id);
        }


        /*******************************************************************
            FUNCTION:   CreateQuoteController::getCustomerNames
            ARGUMENTS:  $DBI: contains the LegacyDatabaseInterface instance
            RETURNS:    A PDO statemtn containing all the customer's names
            USAGE:      To request the customer's names from the 
                        legacyDatabaseInterface
        *******************************************************************/
        public function getCustomerNames($DBI)
        {
            return $DBI->getCustomerNames();
        }

        /*******************************************************************
            FUNCTION:   CreateQuoteController::finalizeQuote
            ARGUMENTS:  $quote: The QuoteStore instance
            RETURNS:    A bool that tells wether a quote was saved
            USAGE:      To request the customer's names from the 
                        legacyDatabaseInterface
        *******************************************************************/
        public function finalizeQuote($quote)
        {
            return $quote->finalizeQuote();
        }
    }
?>
