<?php
    //class used to talk to the legacy database which has the
    //customer information
    class LegacyDatabaseInterface
    {
        //requests all the customer information
        public function getCustomerInfo()
        {
            $db=connect("blitz","csci467","student","student");
            $query="select name from customers";

            return $db->query($query);
        }
    }
?>
