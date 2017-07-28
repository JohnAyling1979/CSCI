<?php
    //class use to communicate
    class STstore
    {
        //gets the password from the SalesAssociate database
        public function getSA($name)
        {
            //connects to database
            $db=connect("courses","z981329","1979Jul29");

            //removes SQL injection
            $name=protect($name);
            //creates query
            $query="select password from SalesAssociate where name='$name'";
            //runs query
            $stmt=$db->query($query);
            //gets first row
            $row=$stmt->fetch();

            //returns the encrypted password
            return $row[password];            
        }
    }
?>
