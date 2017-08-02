<?php
    //class use to communicate with the sales Associate table;
    class SAstore
    {
        /*******************************************************************
            FUNCTION:   SAstore::getSApass
            ARGUMENTS:  $name: Name of the associate
            RETURNS:    Sales Associate information as an array
            USAGE:      Gets the password from the database
        *******************************************************************/
        public function getSA($name)
        {
            //connects to database
            $db=connect("courses","z981329","z981329","1979Jul29");

            //creates query
            $query="select password from SalesAssociate where name='$name'";

            //runs query
            $stmt=$db->query($query);
            //gets first row
            $row=$stmt->fetch();

            //returns the Sales Associate information
            return $row;            
        }
    }
?>
