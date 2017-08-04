<?php
    //used to communicate to the sales associate database
    class SAstore
    {
        /*******************************************************************
            FUNCTION:   SAstore::connect
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
    }
?>
