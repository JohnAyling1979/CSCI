<?php
    //class used to communicate to the outside proccess system
    class PurchaseOrderGateway
    {
        /*******************************************************************
            FUNCTION:   PurchaseOrderGateway::getDateAndRate
            ARGUMENTS:  $data: and array contianing order, Associate, custId,
                        and total amount
            RETURNS:    a php object which contains the date and rate
            USAGE:      To send the PO info to the processor and get the date
                        and commistion rate
        *******************************************************************/
        public function getDateAndRate($data)
        {
            //PO system address
            $url = 'http://blitz.cs.niu.edu/PurchaseOrder/';

            //array to hold the data
            $options = array
            (
                'http' => array
                (
                    'header' => array
                    (
                        'Content-type: application/json'
           ,            'Accept: application/json'
                    ),
                    'method'  => 'POST',
                    'content' => json_encode($data)
                )
            );

            //create the connection and get the result
            $context  = stream_context_create($options);
            $result = file_get_contents($url, false, $context);

            //returns the decoded data
            return json_decode($result);
        }
    }
?>
