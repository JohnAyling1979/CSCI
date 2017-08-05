<?php
//class use to communicate
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
            FUNCTION:   SAstore::getSA
            ARGUMENTS:  $name: Name of the associate
            RETURNS:    Sales Associate information as an array
            USAGE:      To be able to edit or delete
        *******************************************************************/
    public function getSA($name)
        {
            //connects to database
            $db=$this->connect();
            //creates query
            $query="select * from SalesAssociate where name = '$name' ";
            $stmt=$db->query($query);
            return $stmt->fetch();
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
			// update Sales Associate that is alrady in database
			$sql = "UPDATE SalesAssociate SET name = '" . $name . "', ";
			$sql .= "password = '" . $password . "', ";
			$sql .= "commission = '" . $commission . "', ";
			$sql .= "address = '" . $address . "' WHERE saId = " . $saId . ";";
		}
		$db->exec($sql);
		$db->query($update);
		return $isCreated;
	}

    /*******************************************************************
            FUNCTION:   deleteSA
            ARGUMENTS:  $saId
            USAGE:      Delets SA records
    *******************************************************************/
    public function deleteSA($name)
    {
		//connects to database
        $db=$this->connect();
		// delete SalesAssociate
		$sql = "DELETE FROM SalesAssociate WHERE name = '$name' ";
		$db->exec($sql);
		$db->query($update);
            //return status
            return $isCreated;
	}
	
	/*******************************************************************
			FUNCTION:   getSANames
            ARGUMENTS:  none
            RETURNS:    name of Sales Associate in a list
            USAGE:      To be able to retreve a list of SA
    *******************************************************************/
		public function getSANames()
        {
			//connects to database
            $db=$this->connect();;
            //creates query
            $query="select * from SalesAssociate;";
			return $db->query($query);
		}
}
?>
