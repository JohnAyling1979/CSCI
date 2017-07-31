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
            echo "\t\t<title>Create Quote</title>\r\n";
            echo "\t</head>\r\n";
            echo "\t<body>\r\n";
            echo "\t\t<h1>Create Quote System login</h1>\r\n";
            echo "\t\t<form method=post>\r\n";
            echo "\t\t\t<table>\r\n";
            echo "\t\t\t\t<tr><td>User Name:</td><td><input type='text' name='user'></td></tr>\r\n";
            echo "\t\t\t\t<tr><td>Password:</td><td><input type='password' name='pass'></td></tr>\r\n";
            echo "\t\t\t</table>\r\n";
            echo "\t\t\t<button type=submit name='login'>Login</button>\r\n";
            echo "\t\t</form>\r\n";
        }

        /*******************************************************************
            FUNCTION:   SalesAssociateInterface::submitLogin
            ARGUMENTS:  $controller: controller instance
                        $SA: SAstore instance
                        $DBI: LegacyDatabase instance
            RETURNS:    none
            USAGE:      To login and display the customer's names
        *******************************************************************/
        public function submitLogin($controller,$SA,$DBI,$pass,$name)
        {
            //encrypts submitted password
            $pass=hash("sha256",$pass);

            //gets encryoted saved password from the controller
            $testpass=$controller->getPass($SA,$name);

            //test if they match
            if($pass==$testpass)
            {
                //gets a statment with all the customer names from the
                //controller
                $customerSTMT=$controller->getCustomerNames($DBI);

                //html to screen
                echo "\t\t<title>Choose Customer</title>\r\n";
                echo "\t</head>\r\n";
                echo "\t<body>\r\n";
                echo "\t\t<form method=post>\r\n";
                echo "\t\t\t<select name='cust'>\r\n";
                foreach($customerSTMT as $row)
                {
                    $customer=iconv("latin1","UTF-8",$row[1]);
                    echo "\t\t\t\t<option value=$row[id]>$customer</option>\r\n";
                }
                echo"\t\t\t</select>\r\n";
                echo "\t\t\t<button type=submit name='create'>Create Quote</button>\r\n";
                echo "\t\t</form>\r\n";
            }
            else
            {
                //displays login failed
                echo "\t\t<title>Log in fail</title>\r\n";
                echo "\t</head>\r\n";
                echo "\t<body>\r\n";
                echo "\t\tpassword does not match<br>\r\n";
                echo "\t\tPress back arrow to retry\r\n";
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
            $_SESSION[custId]=$id;
            //gets a row from the controller containing the customer
            $customer=$controller->getCustomerInfo($DBI,$id);

            //correct the input
            $_SESSION[customerName]=iconv("latin1","UTF-8",$customer[name]);
            $_SESSION[customerAdd]=iconv("latin1","UTF-8",$customer[street]);
            $_SESSION[customerCity]=iconv("latin1","UTF-8",$customer[city]);

            //html to the screen
            echo "\t\t<title>$_SESSION[customerName] Quote</title>\r\n";
            echo "\t</head>\r\n";
            echo "\t<body>\r\n";
            echo "\t\tCustomer: ".$_SESSION[customerName]."<br>\r\n";
            echo "\t\tStreet: ".$_SESSION[customerAdd]."<br>\r\n";
            echo "\t\tCity: ".$_SESSION[customerCity]."<br>\r\n";
            echo "\t\tSales Associate: ".$_SESSION[user]."<br><br><br>\r\n";
            echo "\t\t<button onclick='addLine()'>Add Line</button>\r\n";
            echo "\t\t<form method=post>\r\n";
            echo "\t\t\t<table>\r\n";
            echo "\t\t\t\t<tr><th>Description</th><th>Price</th><th>Secret Note</th></tr>\r\n";
            echo "\t\t\t\t<tr><td><input type='text' size=50 name='desc0'></td><td><input type='text' size=10 name='price0'></td><td><input type='text' size=50 name='secret0'></td></tr>\r\n";
            echo "\t\t\t\t<tr><td id='line1'></td><td id='line2'></td><td id='line3'></td></tr>\r\n";
            echo "\t\t\t</table>\r\n";
            echo "\t\t\tEmail<br>\r\n";
            echo "\t\t\t<input type='email' name='email' required><br>\r\n";
            echo "\t\t\t<button type=submit name='final'>Finalize</button>\r\n";
            echo "\t\t</form>\r\n";
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
            echo "\t\t<title>Finalizing Quote</title>\r\n";
            echo "\t</head>\r\n";
            echo "\t<body>\r\n";
            //check the return value from the controller
            if($controller->finalizeQuote($quote))
                echo "\t\tQuote has been saved and finalized<br>\r\n";
            else
                echo "\t\tAn error has occured<br>\r\n";
            echo "\t\t<a href='http://students.cs.niu.edu/~z981329/CSCI467/createquote.php'>Return</a><br>\r\n";
        }
    }
?>
