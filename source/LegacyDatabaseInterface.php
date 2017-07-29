<?php
    //class used to talk to the legacy database which has the
    //customer information
    class LegacyDatabaseInterface
    {
        /*******************************************************************
            FUNCTION:   LegacyDatabaseInterface::getCustomerNames
            ARGUMENTS:  none
            RETURNS:    a PDO statement containing all the customer's names
            USAGE:      to get the names from the database
        *******************************************************************/
        public function getCustomerNames()
        {
            $db=connect("blitz","csci467","student","student");
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
            $db=connect("blitz","csci467","student","student");
            $query="select name,street,city from customers where id=$id";

            $stmt=$db->query($query);
            return $stmt->fetch();
        }
    }
?>
