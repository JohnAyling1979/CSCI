<?php
    //class which handles the interaction from the user
    class AdminGUI
    {
		var $controller;
		
		/*******************************************************************
            FUNCTION:   SalesAssociateInterface::constructor
            ARGUMENTS:  none
            RETURNS:    none
            USAGE:      creates an instance to the controller
        *******************************************************************/
		public function __construct()
        {
    		$this->controller = new AdminManage;
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
            echo "<title>Admin System</title>";
            echo "</head>";
            echo "<body>";
            echo "<h1>Select what you want manage</h1>";
			echo "<form method=post>\n";
			echo "<button type=submit name='associate'>Sales Associate</button>\n";
			echo "<button type=submit name='quote'>View Quote</button>\n";
			echo "<form>\n";
        }
		
		 /*******************************************************************
            FUNCTION:   SalesAssociateInterface::manageSA
            ARGUMENTS:  none
            RETURNS:    none
            USAGE:      admin selects how they wanto to mange a Sales Associate
        *******************************************************************/ 
        public function manageSA()
        {
			//html to screen
            echo "<title>Manage Sales Associate</title>";
            echo "</head>";
            echo "<body>";
            echo "<h1>Please select how you want to manage a sales associate</h1>";
			echo "<form method=post>\n";
			echo "<button type=submit name='edit'>edit</button>\n";
			echo "<button type=submit name='create'>create</button>\n";
			echo "<button type=submit name='dSA'>delete</button>\n";
			echo "<form>\n";
        }
		
		/*******************************************************************
            FUNCTION:   SalesAssociateInterface::editSearch
            ARGUMENTS:  none
            RETURNS:    none
            USAGE:      admin search varable to search for Sales Associate
        *******************************************************************/ 
        public function editSearch()
        {	
			echo "<h1>Please select sales associate to edit</h1>";
            echo "<form method=POST>";
			echo "<input type=text name=name required>";
			echo "<button type=submit name='eSearch'>Find</button>\n";
			echo "</form>";
        }
		
		/*******************************************************************
            FUNCTION:   SalesAssociateInterface::editList
            ARGUMENTS:  none
            RETURNS:    none
            USAGE:      admin search varable to search for Sales Associate
        *******************************************************************/
        public function editList($name)
        {
			//gets a statment with Sales Associate names that match from the
            //controller
            $saSTMT=$this->controller->findSA($name);
			
			echo "</head>";
            echo "<body>";
            echo "<title>Manage Sales Associate</title>";
            echo "</head>";
            echo "<body>";
			echo "<h3>Select Sales Associate to edit</h3>";
			echo "<form method=post>\n";
			echo "\t\t\t<select name='saName'>\r\n";
                foreach($saSTMT as $row)
                {
                    //$associate=iconv("latin1","UTF-8",$row[1]);
                    //echo "<option value=$row[saId]>$associate</option>\r\n";
					echo "<option value='$row[name]'>$row[name]</option>\r\n";
                }
                echo "\t\t\t</select>\r\n";
			echo "<button type=submit name='eFind'>Find</button>";
			echo "</form>";
        }
		
		/*******************************************************************
            FUNCTION:   SalesAssociateInterface::editSA
            ARGUMENTS:  $saId
            RETURNS:    none
            USAGE:      admin sedit Sales Associate infromation
        *******************************************************************/
        public function editSA($saName)
        {
            //gets a row from the controller containing the customer
            $associate=$this->controller->getSA($saName);

            //html to the screen
            echo "\t\t<title>Edit Sales Associate</title>\r\n";
            echo "\t</head>\r\n";
            echo "\t<body>\r\n";
			echo "\t\t<form method=post>\r\n";
            echo "\t\t\tName<br>\r\n";
            echo "\t\t\t<input type='text' name='name' value='$associate[name]'><br>\r\n";
            echo "\t\t\tPassword<br>\r\n";
			echo "\t\t\t<input type='password' name='password'><br>";
            echo "\t\t\tAddress<br>\r\n";
			echo "\t\t\t<input type='text' name='address' value='$associate[address]'><br>";
			echo "\t\t\tCommission<br>\r\n";
			echo "\t\t\t<input type='text' name='commission' value='$associate[commission]'>";
            echo "\t\t\t<input type='hidden' name='saId' value='$associate[saId]'><br>";
            echo "\t\t\t<button type=submit name='editUpdate'>Update</button>\r\n";
            echo "\t\t</form>\r\n";
        }
		
		/*******************************************************************
            FUNCTION:   SalesAssociateInterface::creatSA
            ARGUMENTS:  none
            RETURNS:    none
            USAGE:      admin cresats Associate record
        *******************************************************************/
        public function creatSA()
        {
            //html to the screen
            echo "\t\t<title>Edit Sales Associate</title>\r\n";
            echo "\t</head>\r\n";
            echo "\t<body>\r\n";
			echo "\t\t<form method=post>\r\n";
			echo "\t\t\t<input type='hidden' name='saId' value='-1'><br>\r\n";
            echo "\t\t\tName<br>\r\n";
            echo "\t\t\t<input type='text' name='name'><br>\r\n";
            echo "\t\t\tPassword<br>\r\n";
			echo "\t\t\t<input type='password' name='password'<br>\r\n";
            echo "<br>\t\t\tAddress<br>\r\n";
			echo "\t\t\t<input type='text' name='address'><br>";
            echo "\t\t\t<button type=submit name='screat'>Update</button>\r\n";
            echo "\t\t</form>\r\n";;
        }
		
		/*******************************************************************
            FUNCTION:   SalesAssociateInterface::deleteSearch
            ARGUMENTS:  none
            RETURNS:    none
            USAGE:      admin search varable to search for Sales Associate
        *******************************************************************/ 
        public function deleteSearch()
        {
			echo "</head>";
            echo "<body>";
			echo "<h1>Please select sales associate to Delete</h1>";
            echo "<form method=POST>";
			echo "<input type=text name=name required>";
			echo "<button type=submit name='Dsearch'>Find</button>\n";
			echo "</form>";
        }
        
		
		/*******************************************************************
            FUNCTION:   SalesAssociateInterface::editList
            ARGUMENTS:  none
            RETURNS:    none
            USAGE:      admin search varable to search for Sales Associate
        *******************************************************************/
        public function deleteList($name)
        {
            //gets a statment with Sales Associate names that match from the
            //controller
            $saSTMT=$this->controller->findSA($name);
				
            echo "<title>Delete Sales Associate</title>";
            echo "</head>";
            echo "<body>";
			echo "<form method=post>\n";
			echo "\t\t\t<select name='Dsa'>\r\n";
                foreach($saSTMT as $row)
                {
                    $associate=iconv("latin1","UTF-8",$row[1]);
                    echo "\t\t\t\t<option value=$row[saId]>$associate</option>\r\n";
                }
                echo "\t\t\t</select>\r\n";
			echo "<button type=submit name='Dfind'>Find</button>";
			echo "</form>";
        }
		
		/*******************************************************************
            FUNCTION:   SalesAssociateInterface::submitDelete
            ARGUMENTS:  $saId
            RETURNS:    none
            USAGE:      admin confers this is the Sales Associate to delete
        *******************************************************************/
        public function submitDelete($saId)
        {
            //gets a row from the controller containing the sa
            $customer=$this->controller->getSA($saId);
            //html to the screen
            echo "\t\t<title>Conferm Delete</title>\r\n";
            echo "\t</head>\r\n";
            echo "\t<body>\r\n";
			echo "\t\t<form method=post>\r\n";
            echo "\t\t\tName<br>\r\n";
            echo "\t\t\t<input type='text' name='name' value='$customer[name]'><br>\r\n";
            echo "\t\t\Password<br>\r\n";
			echo "\t\t\t<input type='password' name='password'";
            echo "\t\t\Address<br>\r\n";
			echo "\t\t\t<input type='text' name='address' value='$customer[address]'>";
			echo "\t\t\tCommission<br>\r\n";
			echo "\t\t\t<input type='text' name='commission' value='$customer[commission]'>";
            echo "\t\t\t<input type='hidden' name='asId' value='$customer[saId]'>";
            echo "\t\t\t<button type=submit name='sdelete'>Update</button>\r\n";
            echo "\t\t</form>\r\n";
			
        }
		
		/*******************************************************************
            FUNCTION:   SalesAssociateInterface::updateSA
            ARGUMENTS:  $saId,$name,$password,$address,$commission
            RETURNS:    none
            USAGE:      updates or creats user
        *******************************************************************/
		public function updateSA($saId,$name,$password,$address,$commission)
        {	
			echo "\t\t<title>Updating</title>\r\n";
            echo "\t</head>\r\n";
            echo "\t<body>\r\n";
            //check the return value from the controller
            if($this->controller->updateSA($saId,$name,$password,$address,$commission))
                echo "\t\t Sales Associate updated\<br>\r\n";
            else
                echo "\t\tAn error has occured<br>\r\n";
            echo "\t\t<a href='admin.php'>Return</a><br>\r\n";
        }
		
		/*******************************************************************
            FUNCTION:   SalesAssociateInterface::Deleteing
            ARGUMENTS:  $saId
            RETURNS:    none
            USAGE:      deleats user
        *******************************************************************/
		public function Deleteing($saId)
        {
			echo "\t\t<title>Deleteing</title>\r\n";
            echo "\t</head>\r\n";
            echo "\t<body>\r\n";
            //check the return value from the controller
            if($this->controller->updateSA($saId))
                echo "\t\tSales Associate deleated<br>\r\n";
            else
                echo "\t\tAn error has occured<br>\r\n";
            echo "\t\t<a href='admin.php'>Return</a><br>\r\n";
        }
		
		/*******************************************************************
            FUNCTION:   SalesAssociateInterface::quoteOption
            ARGUMENTS:  none
            RETURNS:    none
            USAGE:      Admin selects how they want to view quots
        *******************************************************************/
		public function quoteOption()
        {
			echo "\t\t<title>View Quote</title>\r\n";
            echo "\t</head>\r\n";
            echo "\t<body>\r\n";
            echo "<h1>Please select how you want to view a quote</h1>";
			echo "<form method=post>\n";
			echo "<button type=submit name='status'>Status</button>\n";
			echo "<button type=submit name='date'>Date Range</button>\n";
			echo "<button type=submit name='QuoteAssociate'>Sales Associate</button>\n";
			echo "<button type=submit name='customer'>Customer</button>\n";
			echo "<form>\n";
        }
		
		/*******************************************************************
            FUNCTION:   SalesAssociateInterface::Qstatus
            ARGUMENTS:  none
            RETURNS:    none
            USAGE:      Admin selects how they want to view tatus of quots
        *******************************************************************/
		public function Qstatus()
        {
			echo "\t\t<title>View Quote</title>\r\n";
            echo "\t</head>\r\n";
            echo "\t<body>\r\n";
            echo "<h1>Please select how you want to view a quote</h1>";
			echo "<form method=post>\n";
			echo "<select name=Stype>";
				echo "<option value='isFinalized'>Finalized</option>";
				echo "<option value='isSanctioned'>Sanctioned</option>";
				echo "<option value='isPO'>Ordered</option>";
			echo "</select>";
			echo "<button type=submit name='statusSUB'>Find</button>\n";
			echo "<form>\n";
            
        }
		
		/*******************************************************************
            FUNCTION:   SalesAssociateInterface::Qdate
            ARGUMENTS:  none
            RETURNS:    none
            USAGE:      Admin selects date rance to view quots from
        *******************************************************************/
		public function Qdate()
        {
			echo "\t\t<title>View Quote</title>\r\n";
            echo "\t</head>\r\n";
            echo "\t<body>\r\n";
            echo "<h1>Please select how you want to view a quote</h1>";
			echo "<form method=post>\n";
			echo "Start Date";
			echo "<input type='date' name='start'>";
			echo "End Date";
			echo "<input type='date' name='start'>";
			echo "<button type=submit name='dateSUB'>Find</button>\n";
			echo "<form>\n";;
            
        }
		
		/*******************************************************************
            FUNCTION:   SalesAssociateInterface::Qassociate
            ARGUMENTS:  none
            RETURNS:    none
            USAGE:      Admin selects associate to view quots from
        *******************************************************************/
		public function Qassociate()
        {
            //gets a statment with all the customer names from the
                //controller
                $associateSTMT=$this->controller->getSANames();
                //html to screen
                echo "\t\t<title>Choose Customer</title>\r\n";
                echo "\t</head>\r\n";
                echo "\t<body>\r\n";
                echo "\t\t<form method=post>\r\n";
                echo "\t\t\t<select name='assoc'>\r\n";
                foreach($associateSTMT as $row)
                {
                    $associate=iconv("latin1","UTF-8",$row[1]);
                    echo "\t\t\t\t<option value=$row[id]>$associate</option>\r\n";
                }
                echo "\t\t\t</select>\r\n";
                echo "\t\t\t<button type=submit name='associateSUB'>Search</button>\r\n";
                echo "\t\t</form>\r\n";
            
        }
		
		/*******************************************************************
            FUNCTION:   SalesAssociateInterface::Qassociate
            ARGUMENTS:  none
            RETURNS:    none
            USAGE:      Admin selects customer to view quots from
        *******************************************************************/
		public function Qcustomer($saId)
        {
				//gets a statment with all the associate names from the
                //controller
                $customerSTMT=$this->controller->getCustomerNames();
                //html to screen
                echo "\t\t<title>Choose associate</title>\r\n";
                echo "\t</head>\r\n";
                echo "\t<body>\r\n";
                echo "\t\t<form method=post>\r\n";
                echo "\t\t\t<select name='cust'>\r\n";
                foreach($customerSTMT as $row)
                {
                    $customer=iconv("latin1","UTF-8",$row[1]);
                    echo "\t\t\t\t<option value=$row[id]>$customer</option>\r\n";
                }
                echo "\t\t\t</select>\r\n";
                echo "\t\t\t<button type=submit name='customerSUB'>Search</button>\r\n";
                echo "\t\t</form>\r\n";
            
        }
		
		public function QStatusList($Stype)
        {
			$associateSTMT=$this->controller->getStausQuote($Stype);
			
			echo "\t\t<title>Select a quote to view</title>\r\n";
            echo "\t</head>\r\n";
            echo "\t<body>\r\n";
			echo "<form method=post>\n";
			echo "\t\t\t<select name='Qid'>\r\n";
                foreach($associateSTMT as $row)
                {
                    $associate=iconv("latin1","UTF-8",$row[1]);
                    echo "\t\t\t\t<option value=$row[saId]>$associate</option>\r\n";
                }
                echo "\t\t\t</select>\r\n";
			echo "<button type=submit name='QSlist'>Show</button>";
			echo "</form>";
        }
		
		public function QCustList($saId)
        {
			echo "\t\t<title>Deleteing</title>\r\n";
            echo "\t</head>\r\n";
            echo "\t<body>\r\n";
            
        }
		
		public function QAssoList($saId)
        {
			echo "\t\t<title>Deleteing</title>\r\n";
            echo "\t</head>\r\n";
            echo "\t<body>\r\n";
            
        }
		
		public function QDateList($saId)
        {
			echo "\t\t<title>Deleteing</title>\r\n";
            echo "\t</head>\r\n";
            echo "\t<body>\r\n";
            
        }
		
	}
	?>
