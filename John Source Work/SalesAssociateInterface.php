<?php
    //class which handles the interaction from the user
    class SalesAssociateInterface
    {
        /*******************************************************************
            FUNCTION:   SalesAssociateInterface::index
            ARGUMENTS:  none
            RETURNS:    none
            USAGE:      Default screen before any submits 
        *******************************************************************/
        public function index()
        {
            //html to screen
            echo "<title>Create Quote</title>";
            echo "</head>";
            echo "<body>";
            echo "<h1>Create Quote System login</h1>";
            echo "<form method=post>";
            echo "<table>";
            echo "<tr><td>User Name:</td><td><input type='text' name='user'></td></tr>";
            echo "<tr><td>Password:</td><td><input type='password' name='pass'></td></tr>";
            echo "</table>";
            echo "<button type=submit name='login'>Login</button>";
            echo "</form>";
        }

        /*******************************************************************
            FUNCTION:   SalesAssociateInterface::submitLogin
            ARGUMENTS:  $controller: controller instance
                        $SA: SAstore instance
                        $DBI: LegacyDatabase instance
            RETURNS:    none
            USAGE:      To login and display the customer's names
        *******************************************************************/
        public function submitLogin($controller,$SA,$DBI,$pass)
        {
            //encrypts submitted password
            $pass=hash("sha256",$pass);

            //gets encryoted saved password from the controller
            $testpass=$controller->getSA($SA);

            //test if they match
            if($pass==$testpass)
            {
                //gets a statment with all the customer names from the
                //controller
                $customerSTMT=$controller->getCustomerNames($DBI);

                //html to screen
                echo "<title>Choose Customer</title></head>";
                echo "<body>";
                echo "<form method=post>";
                echo "<select name='cust'>";
                foreach($customerSTMT as $row)
                {
                    $customer=iconv("latin1","UTF-8",$row[1]);
                    echo "<option value=$row[0]>$customer</option>";
                }
                echo"</select>";
                echo "<button type=submit name='create'>Create Quote</button>";
                echo "</form>";
            }
            else
            {
                //displays login failed
                echo "<title>Log in fail</title></head>";
                echo "<body>";
                echo "password does not match<br>";
                echo "Press back arrow to retry";
            }
        }

        /*******************************************************************
            FUNCTION:   SalesAssociateInterface::createQuote
            ARGUMENTS:  $controller: controller instance
                        $DBI: LegacyDatabase instance
                        $id: unique id for the customer
            RETURNS:    none
            USAGE:      gets the informaction for the customer and displays
                        it to the screen to begin the making the quote
        *******************************************************************/
        public function createQuote($controller,$DBI,$id)
        {
            //gets a row from the controller containing the customer
            $customer=$controller->getCustomerInfo($DBI,$id);

            //correct the input
            $_SESSION[customerName]=iconv("latin1","UTF-8",$customer[0]);
            $_SESSION[customerAdd]=iconv("latin1","UTF-8",$customer[1]);
            $_SESSION[customerCity]=iconv("latin1","UTF-8",$customer[2]);

            //html to the screen
            echo "<title>$_SESSION[customerName] Quote</title></head>";
            echo "<body>";
            echo "Customer: ".$_SESSION[customerName]."<br>";
            echo "Street: ".$_SESSION[customerAdd]."<br>";
            echo "City: ".$_SESSION[customerCity]."<br>";
            echo "Sales Associate: ".$_SESSION[user]."<br><br><br>";
            echo "<button onclick='addLine()'>Add Line</button>";
            echo "<form method=post>";
            echo "<table>";
            echo "<tr><th>Description</th><th>Price</th><th>Secret Note</th></tr>";
            echo "<tr><td><input type='text' size=50 name='desc0'></td><td><input type='text' size=10 name='price0'></td><td><input type='text' size=50 name='secret0'></td></tr>";
            echo "<tr><td id='line1'></td><td id='line2'></td><td id='line3'></td></tr>";
            echo "</table>";
            echo "Email<br><input type='email' name='email' required><br>";
            echo "<button type=submit name='final'>Finalize</button>";
            echo "</form>";
        }

        /*******************************************************************
            FUNCTION:   SalesAssociateInterface::finalizeQuote
            ARGUMENTS:  $controller: controller instance
                        $quote: QuoteStore instance
            RETURNS:    none
            USAGE:      displays wether a quote was saved or if an erro
                        occured
        *******************************************************************/
        public function finalizeQuote($controller,$quote)
        {
            //html
            echo "<title>Finalizing Quote</title></head>";
            echo "<body>";
            //check the return value from the controller
            if($controller->finalizeQuote($quote))
                echo "Quote has been saved and finalized<br>";
            else
                echo "An error has occured<br>";
            echo "<a href='http://students.cs.niu.edu/~z981329/CSCI467/createquote.php'>Return</a><br>";
        }
    }
?>
