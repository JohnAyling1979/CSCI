<?php
    //class used to communicate with the quote database
    class QuoteStore
    {
        /*******************************************************************
            FUNCTION:   QuoteStore::connect()
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
            FUNCTION:   QuoteStrore::finalizeQuote
            ARGUMENTS:  none
            RETURNS:    a bool value for wether a quote was saved
            USAGE:      To save a quote to the database
        *******************************************************************/
        public function finalizeQuote()
        {
            //status of quote
            $isCreated=0;

            //connect to the database
            $db=$this->connect();

            //insert statment
            $into="insert into Quote(customerName,custId,customerAddress,customerCity,customerEmail,isFinalized,salesAssociate)
                   values('$_SESSION[customerName]','$_SESSION[custId]','$_SESSION[customerAdd]','$_SESSION[customerCity]','$_POST[email]',1,'$_SESSION[user]')";
 
            //execute the statement and check if the row was added
            if($db->exec($into)>0)
            {
                //change the status
                $isCreated=1;

                //get id number of the quote
                $quote=$db->lastInsertId();

                //set the first line item variable
                $n=0;
                $desc="desc".$n;
                $price="price".$n;
                $secret="secret".$n;
                $currentPrice=0;
                //while there are lines
                while(isset($_POST[$desc]))
                {
                    //checks if the row is empty
                    if($_POST[$desc]!="" || $_POST[$price]!="" || $_POST[$secret]!="")
                    {
                        //insert statement
                        $into="insert into LineItem(quoteId,description,price,secretNote)
                               values($quote,'$_POST[$desc]','$_POST[$price]','$_POST[$secret]')";

                        //execute the statement
                        $db->exec($into);
                        $currentPrice=$currentPrice+$_POST[$price];
                    }
                    //move to next line
                    $n=$n+1;
                    $desc="desc".$n;
                    $price="price".$n;
                    $secret="secret".$n;
                }
            }

            $update="update Quote set currentPrice=$currentPrice where quoteId=$quote";
            $db->query($update);
            //return status
            return $isCreated;
        }
    }
?>
