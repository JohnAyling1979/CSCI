<?php
    //class used to communicate with the sales associate database
    class SAstore
    {
        /*******************************************************************
            FUNCTION:   SAstore::connect()
            ARGUMENTS:  none
            RETURNS:    a PDO object
            USAGE:      to create a connection to a database
        *******************************************************************/
        private function connect()
        {
            $host="courses";
            $DB="z981329";
            $user="z981329";
            $password="1979Jul29";

            //creates the dsn for the PDO
            $dsn="mysql:dbname=".$DB.";host=".$host;
    
            //trys the connection
            try
            {
                $db=new PDO($dsn,$user,$password);
            }
            //if there are errors display error and exit
            catch(PDOException $e)
            {
                echo "Connection failed: Database can not be reached<br>".$e->getMessage();
                die();
            }
    
            //returns PDO object
            return $db;
        }

        /*******************************************************************
            FUNCTION:   SAstore::getSApass
            ARGUMENTS:  $name: Name of the associate
            RETURNS:    Sales Associate information as an array
            USAGE:      Gets the password from the database
        *******************************************************************/
        public function getSA($name)
        {
            //connects to database
            $db=$this->connect();

            //creates query
            $query="select * from SalesAssociate where name='$name'";

            //runs query
            $stmt=$db->query($query);
            //gets first row
            $row=$stmt->fetch();

            //returns the Sales Associate information
            return $row;            
        }

        /*******************************************************************
            FUNCTION:   SAstore::updateCommission
            ARGUMENTS:  $salesAssociate: Sales associate's name
                        $commission: commission vale
            RETURNS:    none
            USAGE:      To update the commission rate for the associate
        *******************************************************************/
        public function updateCommission($salesAssociate,$commission)
        {
            $DB=$this->connect();

            $query="select * from SalesAssociate where Name='$salesAssociate'";
            $stmt=$DB->query($query);
            $info=$stmt->fetch();

            $newCommission=$info[commission]+$commission;

            $query="update SalesAssociate set commission=$newCommission where Name='$salesAssociate'";
            $info=$DB->query($query);
        }        

        /*******************************************************************
            FUNCTION:   findSA
            ARGUMENTS:  $name: Name of the associate
            RETURNS:    name of Sales Associate in a list that match
            USAGE:      To be able to retreve a list of accocites
        *******************************************************************/
		public function findSA($name)
        {
			//connects to database
            $db=$this->connect();;
            //creates query
            $query="select * from SalesAssociate WHERE name LIKE '%" . $name . "%';";
			return $db->query($query);
        }

        /*******************************************************************
            FUNCTION:   updateSA
            ARGUMENTS:  $saId
						$name
						$password
						$address
						$commission
            USAGE:      Creats or updes a sa record
        *******************************************************************/
	public function updateSA($saId,$name,$password,$address,$commission)
    {
		//status of quote
        $isCreated=0;
			
		//connects to database
        $db=$this->connect();
		$password=hash("sha256",$password);	
		// id -1 indicates to create new Sales Associate in DB
		if ($saId == - 1) 
		{
			// Creat new Sales Associate
			$sql = "INSERT INTO SalesAssociate (name, password, address) VALUES (";
			$sql .= "'" . $name . "', ";
			$sql .= "'" . $password . "', ";
			$sql .= "'" . $address . "');";
		} 
		else 
		{
			if($password != "e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855")
			{
				// update Sales Associate that is alrady in database that password is reset
				$sql = "UPDATE SalesAssociate SET name = '$name', password = '$password', commission = '$commission', address = '$address' WHERE saId = '$saId';";
			}
			else
			{
				// update Sales Associate that is alrady in database that password is not reset
				$sql = "UPDATE SalesAssociate SET name = '$name', commission = '$commission', address = '$address' WHERE saId = '$saId';";
			}
		}
		if($db->exec($sql))
            {
                //change the status
                $isCreated=1;
			}
            return $isCreated;
	}

    /*******************************************************************
            FUNCTION:   deleteSA
            ARGUMENTS:  $name
            USAGE:      Delets SA records
    *******************************************************************/
    public function deleteSA($name)
    {
	    	$isCreated=0;
		//connects to database
      	       $db=$this->connect();
		// delete SalesAssociate
		$sql = "DELETE FROM SalesAssociate WHERE name = '$name' ";
            //return status
		if($db->exec($sql))
            {
                //change the status
                $isCreated=1;
			}
            return $isCreated;
	}
    }
?>
