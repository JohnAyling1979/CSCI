<?php
    //class which handles the interaction from the user
    class AdminManage
    {	
		var $SA;
		//var $quote;
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
            //$this->quote= new QuoteStore;
    	}
			
		/*******************************************************************
            FUNCTION:   findSA
            ARGUMENTS:  $search from editSearch and delete search
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
            ARGUMENTS:  $saId from editSearch and delete search
            RETURNS:    A row containing the sa info
            USAGE:      To request the sa info from the 
                       sastore for one customer
        *******************************************************************/
        public function getSA($saId)
        {
            //$info=$this->SA->findSA($name);
			return $this->SA->getSA($saId);
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
            ARGUMENTS:  $saId
            USAGE:      To delete sa records in database
        *******************************************************************/
        public function deleteSA($saId)
        {
            return $this->SA->deleteSA ($saId);
        }
	}
?>
