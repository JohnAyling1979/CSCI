<?php
    //class used to talk to the legacy database which has the
    //customer information
    class LegacyDatabaseInterface
    {
        /*******************************************************************
            FUNCTION:   LegacyDatabaseInterfaceconnect()
            ARGUMENTS:  none
            RETURNS:    a PDO object
            USAGE:      to create a connection to a database
        *******************************************************************/
        private function connect()
        {
            $host="blitz";
            $DB="csci467";
            $user="student";
            $password="student";

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
            FUNCTION:   LegacyDatabaseInterface::getCustomerNames
            ARGUMENTS:  none
            RETURNS:    a PDO statement containing all the customer's names
            USAGE:      to get the names from the database
        *******************************************************************/
        public function getCustomerNames()
        {
            $db=$this->connect();
            $query="select id,name from customers order by name";

            return $db->query($query);
        }

        /*******************************************************************
            FUNCTION:   LegacyDatabaseInterface::getCustomerInfo
            ARGUMENTS:  $id: Id number of the choosen customer
            RETURNS:    a row containing the customers information
            USAGE:      to get the saved information from the database
        *******************************************************************/
        public function getCustomerInfo($id)
        {
            $db=$this->connect();
            $query="select name,street,city from customers where id=$id";

            $stmt=$db->query($query);
            return $stmt->fetch();
        }
    }
?>
