<?php
    class PurchaseOrderGateway
    {


        public function getDateAndRate($data)
        {
            $url = 'http://blitz.cs.niu.edu/PurchaseOrder/';

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

            $context  = stream_context_create($options);
            $result = file_get_contents($url, false, $context);

            return json_decode($result);
        }
    }
?>
