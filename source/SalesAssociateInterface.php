<?php
    //class which handles the interaction from the user
    class SalesAssociateInterface
    {
        //so the interface can call the controller
    	var $controller;

        /*******************************************************************
            FUNCTION:   SalesAssociateInterface::constructor
            ARGUMENTS:  none
            RETURNS:    none
            USAGE:      creates an instance to the controller
        *******************************************************************/
    	public function __construct()
        {
            //creates the controller when the interface is created
    		$this->controller = new CreateQuoteController;
    	}

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
            ARGUMENTS:  $pass: submited password
                        $name: submited name
            RETURNS:    none
            USAGE:      To login and display the customer's names
        *******************************************************************/
        public function submitLogin($pass,$name)
        {
            //encrypts submitted password
            $pass=hash("sha256",$pass);

            //gets encryoted saved password from the controller
            $testpass=$this->controller->getPass($name);

            //test if they match
            if($pass==$testpass)
            {
                //gets a statment with all the customer names from the
                //controller
                $customerSTMT=$this->controller->getCustomerNames();

                //html to screen
                echo "\t\t<title>Choose Customer</title>\r\n";
                echo "\t</head>\r\n";
                echo "\t<body>\r\n";
                echo "\t\t<form method=post>\r\n";
                echo "\t\t\t<select name='cust' required>\r\n";
                echo "\t\t\t\t<option disabled selected>Customer List</option>";
                foreach($customerSTMT as $row)
                {
                    $customer=iconv("latin1","UTF-8",$row[1]);
                    echo "\t\t\t\t<option value=$row[id]>$customer</option>\r\n";
                }
                echo "\t\t\t</select>\r\n";
                echo "\t\t\t<input type='hidden' name='user' value='$name'>";
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
            ARGUMENTS:  $id: unique id for the customer
            RETURNS:    none
            USAGE:      gets the informaction for the customer and displays
                        it to the screen to begin the making the quote
        *******************************************************************/
        public function createQuote($id)
        {
            //gets a row from the controller containing the customer
            $customer=$this->controller->getCustomerInfo($id);

            //correct the input
            $customerName=iconv("latin1","UTF-8",$customer[name]);
            $customerAdd=iconv("latin1","UTF-8",$customer[street]);
            $customerCity=iconv("latin1","UTF-8",$customer[city]);

            //html to the screen
            echo "\t\t<title>Create Quote</title>\r\n";
            echo "\t</head>\r\n";
            echo "\t<body>\r\n";
            echo "\t\tCustomer: ".$customerName."<br>\r\n";
            echo "\t\tStreet: ".$customerAdd."<br>\r\n";
            echo "\t\tCity: ".$customerCity."<br>\r\n";
            echo "\t\tSales Associate: ".$_POST[user]."<br><br><br>\r\n";
            echo "\t\t<button onclick='addLine()'>Add Line</button>\r\n";
            echo "\t\t<form method=post>\r\n";
            echo "\t\t\t<table>\r\n";
            echo "\t\t\t\t<tr><th>Description</th><th>Price</th><th>Secret Note</th></tr>\r\n";
            echo "\t\t\t\t<tr><td><input type='text' size=50 name='desc0'></td><td><input type='text' size=10 name='price0'></td><td><input type='text' size=50 name='secret0'></td></tr>\r\n";
            echo "\t\t\t\t<tr><td id='line1'></td><td id='line2'></td><td id='line3'></td></tr>\r\n";
            echo "\t\t\t</table>\r\n";
            echo "\t\t\tEmail<br>\r\n";
            echo "\t\t\t<input type='email' name='email' required><br>\r\n";
            echo "\t\t\t<input type='hidden' name='customerName' value='$customerName'>";
            echo "\t\t\t<input type='hidden' name='custId' value='$id'>";
            echo "\t\t\t<input type='hidden' name='customerAdd' value='$customerAdd'>";
            echo "\t\t\t<input type='hidden' name='customerCity' value='$customerCity'>";
            echo "\t\t\t<input type='hidden' name='user' value='$_POST[user]'>";
            echo "\t\t\t<button type=submit name='final'>Finalize</button>\r\n";
            echo "\t\t</form>\r\n";
        }

        /*******************************************************************
            FUNCTION:   SalesAssociateInterface::finalizeQuote
            ARGUMENTS:  $customerName: Name of the customer
                        $custId: unique customer #
                        $customerAdd: customer address
                        $customerCity: customer city
                        $email: customer email
                        $user: sales associate name
            RETURNS:    none
            USAGE:      displays wether a quote was saved or if an erro
                        occured
        *******************************************************************/
        public function finalizeQuote($customerName,$custId,$customerAdd,$customerCity,$email,$user)
        {
            //html
            echo "\t\t<title>Finalizing Quote</title>\r\n";
            echo "\t</head>\r\n";
            echo "\t<body>\r\n";
            //check the return value from the controller
            if($this->controller->finalizeQuote($customerName,$custId,$customerAdd,$customerCity,$email,$user))
                echo "\t\tQuote has been saved and finalized<br>\r\n";
            else
                echo "\t\tAn error has occured<br>\r\n";
            echo "\t\t<a href='createquote.php'>Return</a><br>\r\n";
        }
    }
?>
