<?php
    //class which handles the interaction from the user
    class AdminGUI
    {
		var $controller;
		
		/*******************************************************************
            FUNCTION:   AdminGUI::constructor
            ARGUMENTS:  none
            RETURNS:    none
            USAGE:      creates an instance to the controller
        *******************************************************************/
		public function __construct()
        {
    		$this->controller = new AdminManage;
    	}
		
		 /*******************************************************************
            FUNCTION:   AdminGUI::index
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
            FUNCTION:   AdminGUI::manageSA
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
			echo "<button type=submit name='edit'>View or Edit</button>\n";
			echo "<button type=submit name='create'>create</button>\n";
			echo "<button type=submit name='dSA'>delete</button>\n";
			echo "<form>\n";
        }
		
		/*******************************************************************
            FUNCTION:   AdminGUI::editSearch
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
            FUNCTION:   AdminGUI::editList
            ARGUMENTS:  $name
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
			echo "<h3>Select Sales Associate to manage</h3>";
			echo "<form method=post>\n";
			echo "\t\t\t<select name='saName'>\r\n";
                foreach($saSTMT as $row)
                {
					echo "<option value='$row[name]'>$row[name]</option>\r\n";
                }
                echo "\t\t\t</select>\r\n";
			echo "<button type=submit name='eFind'>Find</button>";
			echo "</form>";
        }
		
		/*******************************************************************
            FUNCTION:   AdminGUI::editSA
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
			echo "\t\tSales Associate ID<br>\r\n";
			echo "\t\t\t<input type='text' readonly name='saId' value='$associate[saId]'><br>";
            echo "\t\t\tName<br>\r\n";
            echo "\t\t\t<input type='text' name='name' required value='$associate[name]'><br>\r\n";
            echo "\t\t\tPassword<br>\r\n";
			echo "\t\t\t<input type='password' name='password'><br>";
            echo "\t\t\tAddress<br>\r\n";
			echo "\t\t\t<input type='text' name='address' required value='$associate[address]'><br>";
			echo "\t\t\tCommission<br>\r\n";
			echo "\t\t\t<input type='text' name='commission' required value='$associate[commission]'>";
            echo "\t\t\t<br><button type=submit name='editUpdate'>Update</button>\r\n";
            echo "\t\t</form>\r\n";
			echo "\t\t<br><br><br><br><a href='admin.php'>Return without saving</a><br>\r\n";
        }
		
		/*******************************************************************
            FUNCTION:   AdminGUI::creatSA
            ARGUMENTS:  $creatSA
            RETURNS:    none
            USAGE:      admin cresats Associate record
        *******************************************************************/
        public function creatSA()
        {
            //html to the screen
            echo "\t\t<title>Create Sales Associate</title>\r\n";
            echo "\t</head>\r\n";
            echo "\t<body>\r\n";
			echo "\t\t<form method=post>\r\n";
			echo "\t\t\t<input type='hidden' name='saId' value='-1'><br>\r\n";
            echo "\t\t\tName<br>\r\n";
            echo "\t\t\t<input type='text' name='name' required><br>\r\n";
            echo "\t\t\tPassword<br>\r\n";
			echo "\t\t\t<input type='password' name='password' required><br>\r\n";
            echo "\t\t\tAddress<br>\r\n";
			echo "\t\t\t<input type='text' name='address' required><br>";
            echo "\t\t\t<button type=submit name='screat'>Create</button>\r\n";
            echo "\t\t</form>\r\n";;
        }
		
		/*******************************************************************
            FUNCTION:   AdminGUI::deleteSearch
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
            FUNCTION:   AdminGUI::editList
            ARGUMENTS:  $name
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
			echo "<h1>Please select sales associate to delete</h1>";
			echo "<form method=post>\n";
			echo "\t\t\t<select name='Dsa'>\r\n";
                foreach($saSTMT as $row)
                {
                    echo "<option value='$row[name]'>$row[name]</option>\r\n";
                }
                echo "\t\t\t</select>\r\n";
			echo "<button type=submit name='Dfind'>Find</button>";
			echo "</form>";
        }
		
		/*******************************************************************
            FUNCTION:   AdminGUI::submitDelete
            ARGUMENTS:  $Dsa
            RETURNS:    none
            USAGE:      admin confers this is the Sales Associate to delete
        *******************************************************************/
        public function submitDelete($Dsa)
        {
            //gets a row from the controller containing the sa
            $associate=$this->controller->getSA($Dsa);
            //html to the screen
            echo "\t\t<title>Conferm Delete</title>\r\n";
            echo "\t</head>\r\n";
            echo "\t<body>\r\n";
			echo "\t\t<form method=post>\r\n";
            echo "\t\t\tName<br>\r\n";
            echo "\t\t\t<input type='text' readonly name='name' value='$associate[name]'><br>\r\n";
            echo "\t\t\tAddress<br>\r\n";
			echo "\t\t\t<input type='text' readonly name='address' value='$associate[address]'><br>";
            echo "\t\t\t<button type=submit name='DELEATNOW'>Delete</button>\r\n";
            echo "\t\t</form>\r\n";
			
        }
		
		/*******************************************************************
            FUNCTION:   AdminGUI::updateSA
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
                echo "\t\t Sales Associate Updated<br>\r\n";
            else
                echo "\t\t An error has accored<br>\r\n";
            echo "\t\t<a href='admin.php'>Return</a><br>\r\n";
        }
		
		/*******************************************************************
            FUNCTION:   AdminGUI::Deleteing
            ARGUMENTS:  $name
            RETURNS:    none
            USAGE:      deleats user
        *******************************************************************/
		public function Deleteing($name)
        {
			echo "\t\t<title>Deleteing</title>\r\n";
            echo "\t</head>\r\n";
            echo "\t<body>\r\n";
            //check the return value from the controller
            if($this->controller->deleteSA($name))		
				echo "\t\tSales Associate Deleted<br>\r\n";
			else
				echo "\t\tAn error has occurred  in deleting<br>\r\n";
            echo "\t\t<a href='admin.php'>Return</a><br>\r\n";
        }
		
		/*******************************************************************
            FUNCTION:   AdminGUI::quoteOption
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
            FUNCTION:   AdminGUI::Qstatus
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
            FUNCTION:   AdminGUI::Qdate
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
			echo "<input type='date' name='start' required>";
			echo "End Date";
			echo "<input type='date' name='end' required>";
			echo "<button type=submit name='dateSUB'>Find</button>\n";
			echo "<form>\n";;
            
        }
		
		/*******************************************************************
            FUNCTION:   AdminGUI::Qassociate
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
				echo "<h1>Please select a sales associate to view quots by</h1>";
                echo "\t\t<form method=post>\r\n";
                echo "\t\t\t<select name='assoc'>\r\n";
                foreach($associateSTMT as $row)
                {
                    $associate=iconv("latin1","UTF-8",$row[salesAssociate]);
                    echo "\t\t\t\t<option value=$row[salesAssociate]>$associate</option>\r\n";
                }
                echo "\t\t\t</select>\r\n";
                echo "\t\t\t<button type=submit name='associateSUB'>Search</button>\r\n";
                echo "\t\t</form>\r\n";
            
        }
		
		/*******************************************************************
            FUNCTION:   AdminGUI::Qcustomer
            ARGUMENTS:  none
            RETURNS:    none
            USAGE:      Admin selects customer to view quots from
        *******************************************************************/
		public function Qcustomer()
        {
				//gets a statment with all the associate names from the
                //controller
                $customerSTMT=$this->controller->getCustomerNames();
                //html to screen
                echo "\t\t<title>Choose associate</title>\r\n";
                echo "\t</head>\r\n";
                echo "\t<body>\r\n";
				echo "<h1>Please select a customer to view quots by</h1>";
                echo "\t\t<form method=post>\r\n";
                echo "\t\t\t<select name='cust'>\r\n";
                foreach($customerSTMT as $row)
                {
                    $customer=iconv("latin1","UTF-8",$row[1]);
                    echo "\t\t\t\t<option value=$row[custId]>$customer</option>\r\n";
                }
                echo "\t\t\t</select>\r\n";
                echo "\t\t\t<button type=submit name='customerSUB'>Search</button>\r\n";
                echo "\t\t</form>\r\n";
            
        }
		
		/*******************************************************************
            FUNCTION:   AdminGUI::QStatusList
            ARGUMENTS:  $Stype
            RETURNS:    none
            USAGE:      List of quots that are that status
        *******************************************************************/
		public function QStatusList($Stype)
        {
			$associateSTMT=$this->controller->getQuotsStatus($Stype);
			
			echo "\t\t<title>Select a quote to view</title>\r\n";
            echo "\t</head>\r\n";
            echo "\t<body>\r\n";
			echo "<h1>Please select a quote to view</h1>";
			echo "<form method=post>\n";
				echo "<select name=quoteId>";
                foreach($associateSTMT as $row)
                {
					echo "<option value='$row[quoteId]'>$row[quoteId] - $row[customerName] </option>\r\n";
                }
                echo "\t\t\t</select>\r\n";
				echo "<td><button type=submit name='VIEWQUOTE'>View Quote</button></td>";
			echo "</form>";
        }
		
		/*******************************************************************
            FUNCTION:   AdminGUI::QCustList
            ARGUMENTS:  $cust
            RETURNS:    none
            USAGE:      List of quots thare equal to a customer
        *******************************************************************/
		public function QCustList($cust)
        {
			$associateSTMT=$this->controller->getQuotsByCust($cust);
			
			echo "\t\t<title>Select a quote to view</title>\r\n";
            echo "\t</head>\r\n";
            echo "\t<body>\r\n";
			echo "<h1>Please select a quote to view</h1>";
			echo "<form method=post>\n";
				echo "<select name=quoteId>";
                foreach($associateSTMT as $row)
                {
					echo "<option value='$row[quoteId]'>$row[quoteId] - $row[customerName] </option>\r\n";
                }
                echo "\t\t\t</select>\r\n";
				echo "<td><button type=submit name='VIEWQUOTE'>View Quote</button></td>";
			echo "</form>";
            
        }
		
		/*******************************************************************
            FUNCTION:   AdminGUI::QAssoList
            ARGUMENTS:  $assoc
            RETURNS:    none
            USAGE:      List of quots thare equal to a SA
        *******************************************************************/
		public function QAssoList($assoc)
        {
			$line = $assoc. "%";
			$listSTMT=$this->controller->getQuotsBySA($line);
			echo "\t\t<title>Select a quote to view</title>\r\n";
            echo "\t</head>\r\n";
            echo "\t<body>\r\n";
			echo "<h1>Please select a quote to view</h1>";
			echo "<form method=post>\n";
				echo "<select name=quoteId>";
                foreach($listSTMT as $row)
                {
					echo "<option value='$row[quoteId]'>$row[quoteId] - $row[customerName] </option>\r\n";
                }
                echo "\t\t\t</select>\r\n";
				echo "<td><button type=submit name='VIEWQUOTE'>View Quote</button></td>";
			echo "</form>";
            
        }
		
		/*******************************************************************
            FUNCTION:   AdminGUI::QDateList
            ARGUMENTS:  $start,$end
            RETURNS:    none
            USAGE:      List of quots thare in a date range
        *******************************************************************/
		public function QDateList($start,$end)
        {	
			$associateSTMT=$this->controller->getDates($start,$end);
			echo "\t\t<title>Select a quote to view</title>\r\n";
            echo "\t</head>\r\n";
            echo "\t<body>\r\n";
			echo "<h1>Please select a quote to view</h1>";
			echo "<form method=post>\n";
				echo "<select name=quoteId>";
                foreach($associateSTMT as $row)
                {
					echo "<option value='$row[quoteId]'>$row[quoteId] - $row[customerName] </option>\r\n";
                }
                echo "\t\t\t</select>\r\n";
				echo "<td><button type=submit name='VIEWQUOTE'>View Quote</button></td>";
			echo "</form>";
            
        }
		
		/*******************************************************************
            FUNCTION:   AdminGUI::QuoteView
            ARGUMENTS:  $quoteId
            RETURNS:    none
            USAGE:      List of quots thare in a date range
        *******************************************************************/
		public function QuoteView($quoteId)
        {
			$test=$this->controller->getFinalQuote($quoteId);
			
			echo "\t\t<title>quote to view</title>\r\n";
            echo "\t</head>\r\n";
            echo "\t<body>\r\n";
			foreach($test as $QuoteSTMT)
			{
				echo "\t\t<b>Quote ID:</b> ".$QuoteSTMT[quoteId]."<br>\r\n";
				echo "\t\t<b>Customer Name:</b> ".$QuoteSTMT[customerName]."<br>\r\n";
				echo "\t\t<b>Customer Address:</b> ".$QuoteSTMT[customerAddress]."<br>\r\n";
				echo "\t\t<b>Customer City:</b> ".$QuoteSTMT[customerCity]."<br>\r\n";
				echo "\t\t<b>Customer Email:</b> ".$QuoteSTMT[customerEmail]."<br>\r\n";
				echo "\t\t<b>Processing Date:</b> ".$QuoteSTMT[processingDate]."<br>\r\n";
				echo "\t\t<b>Commission:</b> ".$QuoteSTMT[commission]."<br>\r\n";
				echo "\t\t<b>Sales Associate:</b> ".$QuoteSTMT[salesAssociate]."<br>\r\n";
				echo "\t\t<b>Price:</b> ".$QuoteSTMT[currentPrice]."<br>\r\n";
				if ($QuoteSTMT[isFinalized] == "1")
				{
					echo "\t\t<b>Status:</b> Finalized <br>\r\n";
				}
				elseif  ($QuoteSTMT[isSanctioned] == "1")
				{
					echo "\t\t<b>Status:</b> Sanctioned <br>\r\n";
				}
				elseif  ($QuoteSTMT[isPO] == "1")
				{
					echo "\t\t<b>Status:</b> PO Created<br>\r\n";
				}
			}
			  
			  echo "<table>";
			  echo "<tr>";
					echo "<th>\t\t description\r\n</th>";
					echo "<th>\t\t price\r\n</th>";
					echo "<th>\t\t secretNote\r\n</th>";
					echo "</tr>";
			  $LineSTMT=$this->controller->getLineItems($quoteId);
                foreach($LineSTMT as $rows)
                {
					echo "<tr>";
					echo "<td>\t\t ".$rows[description]."\r\n</td>";
					echo "<td>\t\t ".$rows[price]."\r\n</td>";
					echo "<td>\t\t ".$rows[secretNote]."\r\n</td>";
					echo "</tr>";
                }
			  echo "</table>";
			  
			  
			  echo "\t\t<br><br><br><br><a href='admin.php'>Return</a><br>\r\n";
        }
		
	}
?>
