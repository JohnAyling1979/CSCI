<?php
	//include store classes
	include 'SAstore.php';
	include 'QuoteStore.php';

    //class which handles the interaction from the user
    class AdminManage
    {	
		var $Sstore;
		var $Qstore;
		//creates instances of the classes
		function __construct()
		{
			$this->Sstore = new SAstore ();
			$this->Qstore = new QuoteStore ();
		}
			
		//called when admin wants to search for associate 
        public function findSA($name)
        {
			return $this->Sstore->findSA($name);
        }
		
		//called when admin want to retreave an associate
        public function getSA($saId)
        {
            return $this->Sstore->getSA($saId);
        }
		
		//called when admin chooses to update associate
        public function updateSA($sa)
        {
            return $this->Sstore->updateSA ($sa);
        }
		
		//called when admin chooses to deleat an associate
        public function deleteSA($saId)
        {
            return $this->Sstore->deleteSA ($saId);
        }
		
		//called to retreive a quote
        public function findQuote($quote)
        {
            return $this->Qstore->finalizeQuote($quote);
        }
		
		//called when admin chooses a quote to view
        public function getQuote($quote)
        {
            return $this->Qstore->getCustomerInfo($quote);
        }
	}
	?>