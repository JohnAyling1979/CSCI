<?php
    //class to commuticate between the other classes
    class CreateQuoteController
    {
        //gets the password from the Ststore
        public function getSA($ST,$name)
        {
            return $ST->getSA($name);
        }

        //gets the customer information from the legacy database
        public function getCustomerInfo()
        {
        }

        //sends quote to the quote store
        public function finalizeQuote()
        {
        }
    }
?>
