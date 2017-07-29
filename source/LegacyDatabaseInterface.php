<?php
    //class used to talk to the legacy database which has the
    //customer information
    class LegacyDatabaseInterface
    {
        //requests all the customer information
        public function getCustomerNames()
        {
            $db=connect("blitz","csci467","student","student");
            $query="select id,name from customers order by name";

            return $db->query($query);
        }

        public function getCustomerInfo($id)
        {
            $db=connect("blitz","csci467","student","student");
            $query="select name,street,city from customers where id=$id";

            return $db->query($query);
        }
    }
?>
