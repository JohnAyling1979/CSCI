<?php
    //class use to communicate
    class STstore
    {
        //search records from the SalesAssociate database
        public function findSA($name)
        {
			$db=connect("courses","z981329","z981329","1979Jul29");
            $query="select * from SalesAssociate WHERE name LIKE '%" . $name . "%';";
            return $db->query($query);
        }

        //gets info from the SalesAssociate database
        public function getSA($saId)
        {
            //connect to the database
            $db=connect("courses","z981329","z981329","1979Jul29");
            // Retrieve Quotes that are marked as Finalized
            $sql = "SELECT * FROM SalesAssociate WHERE saId = " . $said . ";";
            $row = $db->query($sql);
            // return the results
            return new Employee ( $row );
        }

        //updates SalesAssociate database
        public function updateSA($sa)
        {
			//connect to the database
            $db=connect("courses","z981329","z981329","1979Jul29");
			
			// id -1 indicates to create new employee in DB
		if ($sa->id == - 1) {
			// Creat new Sales Associate
			$sql = "INSERT INTO SalesAssociate (name, password, address) VALUES (";
			$sql .= "'" . $sa->name . "', ";
			$sql .= "'" . $sa->password . "', ";
			$sql .= "'" . $sa->address . "');";
		} else {
			// update Sales Associate that is alrady in database
			$sql = "UPDATE SalesAssociate SET name = '" . $sa->name . "', ";
			$sql .= "password = '" . $sa->password . "', ";
			$sql .= "commission = '" . $sa->commission . "', ";
			$sql .= "address = '" . $sa->address . "' WHERE saId = " . $sa->saId . ";";
		}
		}

        //delets the record from the SalesAssociate database
        public function deleteSA($saId)
        {
			//connect to the database
            $db=connect("courses","z981329","z981329","1979Jul29");

			 //delete statment
            $into="DELETE FROM SalesAssociate where saId = '$_POST[$saId]'";
 
            //return status
            return $deleated;
        }

    }
?>
