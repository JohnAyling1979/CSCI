<?php
    //class which handles the interaction from the user
    class SalesAssociateInterface
    {
        //called when user submits login information
        public function submitLogin()
        {
            echo "login";
        }

        //called when associate chooses a customer
        public function chooseCustomer()
        {
            echo "Customer";
        }

        //called to add lines to the current quote
        public function addLine()
        {
            echo "add";
        }

        //finalizes and saves the quote
        public function finalizeQuote()
        {
            echo "Final";
        }
    }
?>
