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
		
		 //search records from the SalesAssociate database
		public function findSA($name)
        {
			//connects to database
            $db=$this->connect();;
            //creates query
            $query="select * from SalesAssociate WHERE name LIKE '%" . $name . "%';";
            //runs query
            $stmt=$db->query($query);
            
			$saList = array ();
		
			if ($stmt->num_rows > 0) 
			{
				while ( $row = $stmt->fetch_assoc () ) 
				{
					$saList [$row ['saId']] = new SalesAssociate ( $row );
				}
			}
			return $saList;
        }

    //gets info from the SalesAssociate database
    public function getSA($saId)
        {
            //connects to database
            $db=$this->connect();
            //creates query
            $query="select * from SalesAssociate where saId = " .$saId . ";";
            //runs query
            $stmt=$db->query($query);
            //gets first row
            $row=$stmt->fetch();
            //returns the Sales Associate information
            return new Associate ($row);
        }

    //updates SalesAssociate database
    public function updateSA($sa)
    {
		//connects to database
        $db=$this->connect();
			
		// id -1 indicates to create new Sales Associate in DB
		if ($sa->saId == - 1) 
		{
			// Creat new Sales Associate
			$sql = "INSERT INTO SalesAssociate (name, password, address) VALUES (";
			$sql .= "'" . $sa->name . "', ";
			$sql .= "'" . $sa->password . "', ";
			$sql .= "'" . $sa->address . "');";
		} 
		else 
		{
			// update Sales Associate that is alrady in database
			$sql = "UPDATE SalesAssociate SET name = '" . $sa->name . "', ";
			$sql .= "password = '" . $sa->password . "', ";
			$sql .= "commission = '" . $sa->commission . "', ";
			$sql .= "address = '" . $sa->address . "' WHERE saId = " . $sa->saId . ";";
		}
		if ($db->query ( $sql ) === TRUE) 
		{
			return "Updated";
		}
	}

    //delets the record from the SalesAssociate database
    public function deleteSA($saId)
    {
		//connects to database
        $db=$this->connect();
		// delete SalesAssociate
		$sql = "DELETE FROM SalesAssociate WHERE id = " . $saId . ";";
		$db->exec($sql);
		if ($db->query ( $sql ) === TRUE)
		{
			return "Deleated";
		}
	}
}

class Associate 
{
	var $saId;
	var $name;
	var $address;
	var $password;
	var $commission;
	// create Associate from array
	function __construct($row) {
		$this->saId = $row ['saId'];
		$this->name = $row ['name'];
		$this->address = $row ['address'];
		$this->password = $row ['password'];
		$this->commission = $row ['commission'];
	}
}
?>
