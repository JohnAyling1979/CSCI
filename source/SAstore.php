<?php
    //class use to communicate
    class STstore
    {
        //gets the password from the SalesAssociate database
        public function getSA()
        {
            //connects to database
            $db=connect("courses","z981329","z981329","1979Jul29");

            //creates query
            $query="select password from SalesAssociate where name='$_SESSION[user]'";
            //runs query
            $stmt=$db->query($query);
            //gets first row
            $row=$stmt->fetch();

            //returns the encrypted password
            return $row[password];            
        }
    }
?>
