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
            echo "\t\t\t\t<tr><td>User Name:</td><td><input type='text' name='name'></td></tr>\r\n";
            echo "\t\t\t\t<tr><td>Password:</td><td><input type='password' name='password'></td></tr>\r\n";
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
        public function submitLogin($name,$password)
        {
            //encrypts submitted password
            $password=hash("sha256",$password);

            //gets encryoted saved password from the controller
            $testpass=$this->controller->getPass($name);

            //test if they match
            if($password==$testpass)
            {
                //gets a statment with all the customer names from the
                //controller
                $customerSTMT=$this->controller->getCustomerNames();

                //html to screen
                echo "\t\t<title>Choose Customer</title>\r\n";
                echo "\t</head>\r\n";
                echo "\t<body>\r\n";
                echo "\t\t<form method=post>\r\n";
                echo "\t\t\t<select name='id' required>\r\n";
                echo "\t\t\t\t<option disabled selected>Customer List</option>";
                foreach($customerSTMT as $row)
                {
                    $customerName=iconv("latin1","UTF-8",$row[name]);
                    echo "\t\t\t\t<option value=$row[id]>$customerName</option>\r\n";
                }
                echo "\t\t\t</select>\r\n";
                echo "\t\t\t<input type='hidden' name='name' value='$name'>";
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
        public function createQuote($custId,$salesAssociate)
        {
            //gets a row from the controller containing the customer
            $customer=$this->controller->getCustomerInfo($custId);

            //correct the input
            $customerName=iconv("latin1","UTF-8",$customer[name]);
            $customerAddress=iconv("latin1","UTF-8",$customer[street]);
            $customerCity=iconv("latin1","UTF-8",$customer[city]);

            //html to the screen
            echo "\t\t<title>Create Quote</title>\r\n";
            echo "\t</head>\r\n";
            echo "\t<body>\r\n";
            echo "\t\tCustomer: ".$customerName."<br>\r\n";
            echo "\t\tStreet: ".$customerAddress."<br>\r\n";
            echo "\t\tCity: ".$customerCity."<br>\r\n";
            echo "\t\tSales Associate: ".$salesAssociate."<br><br><br>\r\n";
            echo "\t\t<button onclick='addLine()'>Add Line</button>\r\n";
            echo "\t\t<form method=post>\r\n";
            echo "\t\t\t<table>\r\n";
            echo "\t\t\t\t<tr><th>Description</th><th>Price</th><th>Secret Note</th></tr>\r\n";
            echo "\t\t\t\t<tr><td><input type='text' size=50 name='desc0'></td><td><input type='text' size=10 name='price0'></td><td><input type='text' size=50 name='secret0'></td></tr>\r\n";
            echo "\t\t\t\t<tr><td id='line1'></td><td id='line2'></td><td id='line3'></td></tr>\r\n";
            echo "\t\t\t</table>\r\n";
            echo "\t\t\tEmail<br>\r\n";
            echo "\t\t\t<input type='email' name='customerEmail' required><br>\r\n";
            echo "\t\t\t<input type='hidden' name='customerName' value=".'"'.$customerName.'"'.">\r\n";
            echo "\t\t\t<input type='hidden' name='custId' value='$custId'>";
            echo "\t\t\t<input type='hidden' name='customerAddress' value=".'"'.$customerAddress.'"'.">";
            echo "\t\t\t<input type='hidden' name='customerCity' value=".'"'.$customerCity.'"'.">";
            echo "\t\t\t<input type='hidden' name='salesAssociate' value='$salesAssociate'>";
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
        public function finalizeQuote($customerName,$custId,$customerAddress,$customerCity,$customerEmail,$salesAssociate)
        {
            //html
            echo "\t\t<title>Finalizing Quote</title>\r\n";
            echo "\t</head>\r\n";
            echo "\t<body>\r\n";
            //check the return value from the controller
            if($this->controller->finalizeQuote($customerName,$custId,$customerAddress,$customerCity,$customerEmail,$salesAssociate))
                echo "\t\tQuote has been saved and finalized<br>\r\n";
            else
                echo "\t\tAn error has occured<br>\r\n";
            echo "\t\t<a href='createquote.php'>Return</a><br>\r\n";
        }
    }
?>
<!--javascript to add line items to the screen -->
<script>
    //starting row number
    var n=1;

    /****************************************************************
       FUNCTION:   addLine

       ARGUMENTS:  none

       RETURNS:    none

       USAGE:      adds a row to the screen for a new line item
    ****************************************************************/
    function addLine()
    {
        //arrays for each input
        var desc={};
        desc[n]=document.createElement("input");
        var dl=document.createElement("br");

        var price={};
        price[n]=document.createElement("input");
        var pl=document.createElement("br");

        var secret={};
        secret[n]=document.createElement("input");
	    var sl=document.createElement("br");

        //attributes for each element
        desc[n].type="text";
        desc[n].id=n;
        desc[n].size="50";
        desc[n].name="desc"+n;

        price[n].type="text";
        price[n].id=n;
        price[n].size="10";
        price[n].name="price"+n;


        secret[n].type="text";
        secret[n].id=n;
        secret[n].size="50";
        secret[n].name="secret"+n;

        //append the line to the table
        document.getElementById("line1").appendChild(desc[n]);
    	document.getElementById("line1").appendChild(dl);

        document.getElementById("line2").appendChild(price[n]);
        document.getElementById("line2").appendChild(pl);

        document.getElementById("line3").appendChild(secret[n]);
        document.getElementById("line3").appendChild(sl);

        //increase row count
        n++;
    }
</script>
