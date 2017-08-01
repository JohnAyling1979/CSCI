<?php
session_start();
	//include store classes
	include 'SAstore.php';
	include 'QuoteStore.php';

    //class which handles the interaction from the user
    class AdminManage
    {	
		//called when admin wants to search for associate 
        public function findSA($name)
        {
			return $quote->finalizeQuote();
        }
		
		//called when admin want to retreave an associate
        public function getSA($saId)
        {
            return $quote->finalizeQuote();
        }
		
		//called when admin chooses to update associate
        public function updateSA($sa)
        {
            return $quote->finalizeQuote();
        }
		
		//called when admin chooses to deleat an associate
        public function deleteSA($saId)
        {
            return $quote->finalizeQuote();
        }
		
		//called to retreive a quote
        public function findQuote($controller,$DBI,$id)
        {
            return $quote->finalizeQuote();
        }
		
		//called when admin chooses a quote to view
        public function getQuote($controller,$DBI,$id)
        {
            return $controller->getCustomerInfo();
        }
	}
	?>