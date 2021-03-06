<?php
    //class which handles the interaction from the user
    class AdminManage
    {	
		var $SA;
		var $QUOTE;
		 /*******************************************************************
            FUNCTION:   CreateQuoteController::constructor
            ARGUMENTS:  none
            RETURNS:    none
            USAGE:      creates instances to SAstore and
                        quotestore 
        *******************************************************************/
    	public function __construct()
        {
            //creates instances of the other classes when controller is created
    		$this->SA = new SAstore;
            $this->QUOTE= new QuoteStore;
    	}
			
		/*******************************************************************
            FUNCTION:   findSA
            ARGUMENTS:  $name
            RETURNS:    A PDO statemtn containing all the sa names that match
            USAGE:      get a list of matching sa
        *******************************************************************/
        public function findSA($name)
        {	
			$info=$this->SA->findSA($name);
            return $info;
        }
		
		/*******************************************************************
            FUNCTION:   getSA
            ARGUMENTS:  $name
            RETURNS:    A row containing the sa info
            USAGE:      To request the sa info from the 
                       sastore for one customer
        *******************************************************************/
        public function getSA($name)
        {
			return $this->SA->getSA($name);
        }
		
		/*******************************************************************
            FUNCTION:   updateSA
            ARGUMENTS:  $name
                        $saId
                        $commision
                        $password
                        $address
            USAGE:      To update sa records in database
        *******************************************************************/
        public function updateSA($saId,$name,$password,$address,$commission)
        {
            return $this->SA->updateSA($saId,$name,$password,$address,$commission);
        }
		
		/*******************************************************************
            FUNCTION:   deleteSA
            ARGUMENTS:  $name
            USAGE:      To delete sa records in database
        *******************************************************************/
        public function deleteSA($name)
        {
            return $this->SA->deleteSA ($name);
        }
		
		/*******************************************************************
            FUNCTION:   getCustomerNames
            ARGUMENTS:  none
            USAGE:      List of customer names
        *******************************************************************/
        public function getCustomerNames()
        {
            return $this->QUOTE->getCustomerNames();
        }
		
		/*******************************************************************
            FUNCTION:   getSANames
            ARGUMENTS:  none
            USAGE:      List of SA names
        *******************************************************************/
        public function getSANames()
        {
            return $this->QUOTE->getSANames();
        }
		
		/*******************************************************************
            FUNCTION:   getQuotsStatus
            ARGUMENTS:  $Stype
            USAGE:      List of quots by a matching status
        *******************************************************************/
        public function getQuotsStatus($Stype)
        {
            return $this->QUOTE->getQuotsStatus($Stype);
        }
		
		/*******************************************************************
            FUNCTION:   getQuotsByCust
            ARGUMENTS:  $custId
            USAGE:      List of quots by a matching customer
        *******************************************************************/
        public function getQuotsByCust($custId)
        {
            return $this->QUOTE->getQuotsByCust($custId);
        }
		
		/*******************************************************************
            FUNCTION:   getQuotsBySA
            ARGUMENTS:  $assoc
            USAGE:      List of quots by a matching SA
        *******************************************************************/
        public function getQuotsBySA($assoc)
        {
            return $this->QUOTE->getQuotsBySA($assoc);
        }
		
		/*******************************************************************
            FUNCTION:   getFinalQuote
            ARGUMENTS:  $quoteId
            USAGE:      To request the sa info from the 
                       sastore for one customer
        *******************************************************************/
        public function getFinalQuote($quoteId)
        {
			return $this->QUOTE->getFinalQuote($quoteId);
        }
		
		/*******************************************************************
            FUNCTION:   getLineItems
            ARGUMENTS:  $quoteId
            USAGE:      Get Lins of the quote
        *******************************************************************/
        public function getLineItems($quoteId)
        {
            return $this->QUOTE->getLineItems($quoteId);
        }
		
		/*******************************************************************
            FUNCTION:   getDates
            ARGUMENTS:  $start, $end
            USAGE:      Gets quot in date range
        *******************************************************************/
        public function getDates($start,$end)
        {
            return $this->QUOTE->getDates($start,$end);
        }
	}
?>
