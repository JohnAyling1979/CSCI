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
		return $DB->query($sql);
	}
	
	/*
	    public function updateSA($new,$id,$name,$pass,$comm,$add)
        {
            $DB=$this->connect();
            //if a new password
            if($pass!="")
            {
                //hash it
                $pass=hash("sha256",$pass);
                //if it's not new SA
                //update the current
                if(!$new)
                {
                    $into="update SalesAssociate set password='$pass; where saId='$id'"; 
                    $DB->query($into);
                }
            }

            //if it is new it is an insert
            //else it will be an update
            if($new)
                $into="insert into SalesAssociate(name,password,commission,address) values('$name','$pass','$comm','$add')";
            else
                $into="update SalesAssociate set name='$name',commission=$comm,address='$add' where saId='$id'";

           return $DB->query($into);
        }
		*/


    /*******************************************************************
            FUNCTION:   deleteSA
            ARGUMENTS:  $saId
            USAGE:      Delets SA records
        *******************************************************************/
    public function deleteSA($saId)
    {
		//connects to database
        $db=$this->connect();
		// delete SalesAssociate
		$sql = "DELETE FROM SalesAssociate WHERE id = " . $saId . ";";
		$db->exec($sql);
		$db->query($update);
            //return status
            return $isCreated;
	}
}
?>
