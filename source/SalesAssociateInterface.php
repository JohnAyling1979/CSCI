<?php
    //class which handles the interaction from the user
    class SalesAssociateInterface
    {
        //called when user submits login information
        public function submitLogin($controller,$ST,$name,$pass)
        {
            //encrypts password
            $pass=hash("sha256",$pass);
            //gets encryoted saved password
            $testpass=$controller->getSA($ST,$name);

            //test if they match
            if($pass==$testpass)
                echo "password ok";
            else
                echo "password does not match";
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
