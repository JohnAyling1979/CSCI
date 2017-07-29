<?php
    //class which handles the interaction from the user
    class SalesAssociateInterface
    {
        //called when user submits login information
        public function submitLogin($controller,$ST,$DBI,$pass)
        {
            //encrypts password
            $pass=hash("sha256",$pass);
            //gets encryoted saved password
            $testpass=$controller->getSA($ST);

            //test if they match
            if($pass==$testpass)
            {
                return $controller->getCustomerNames($DBI);
            }
            else
                echo "<title>Log in fail</title></head>";
                echo "<body>";
                echo "password does not match<br>";
                echo "Press back arrow to retry";
        }

        //called when associate chooses a customer
        public function chooseCustomer($controller,$DBI,$id)
        {
            return $controller->getCustomerInfo($DBI,$id);
        }

        //finalizes and saves the quote
        public function finalizeQuote($controller,$quote)
        {
            $controller->finalizeQuote($quote);
        }
    }
?>
