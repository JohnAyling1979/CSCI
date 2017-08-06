<?php
    //middle man to pass info between the boundary classes
    class ManagePurchaseOrder
    {
        //wiil hold instances of POGateway,Quore store, and Sales associate interface
        var $POGateway;
        var $quote;
        var $SA;

        /*******************************************************************
            FUNCTION:   ManagePurchaseOrder::__construct
            ARGUMENTS:  none
            RETURNS:    none
            USAGE:      To create an instance of the three interface when the
                        controller is created
        *******************************************************************/
        public function __construct()
        {
            $this->POGateway=new PurchaseOrderGateway;
            $this->quote=new QuoteStore;
            $this->SA=new SAstore;

        }

        /*******************************************************************
            FUNCTION:   ManagePurchaseOrder::getSanctionedQuotes
            ARGUMENTS:  none
            RETURNS:    A pdo statment containing all the sactioned quotes
            USAGE:      Calls to the quote interface to get the sactioned
                        quotes
        *******************************************************************/
        public function getSanctionedQuotes()
        {
            return $this->quote->getSanctionedQuotes();
        }

        /*******************************************************************
            FUNCTION:   ManagePurchaseOrder::getQuote
            ARGUMENTS:  $quoteId: unique id of the quote
            RETURNS:    an array containing all the quote information
            USAGE:      Calls to the quote interface to get the information
                        of one quote
        *******************************************************************/
        public function getQuote($quoteId)
        {
            return $this->quote->getQuote($quoteId);
        }

        /*******************************************************************
            FUNCTION:   ManagePurchaseOrder::getLineItems
            ARGUMENTS:  $quoteId: unique id of the quote
            RETURNS:    a pdo statement containing all the lines for a quote
            USAGE:      Calls to the quote interface to get the lines associated
                        to the quote
        *******************************************************************/
        public function getLineItems($quoteId)
        {
            return $this->quote->getLineItems($quoteId);
        }

        /*******************************************************************
            FUNCTION:   ManagePurchaseOrder::createPurchaseOrder
            ARGUMENTS:  $quoteId: unique id of the quote
                        $price: current total price for the quote
            RETURNS:    none
            USAGE:      communicates to the PO system,quote, and sales associate
                        to update the quote to a PO
        *******************************************************************/
        public function createPurchaseOrder($quoteId,$price)
        {
            //creates the PO
            $this->quote->createPurchaseOrder($quoteId,$price);
            //gets the PO information
            $quote=$this->quote->getQuote($quoteId);
            //get the Sales Associate ID
            $sa=$this->SA->getSa($quote[salesAssociate]);

            //prepares the data for the PO system
            //unique order #
            $data=array
            (
                'order' => $quote[quoteId]."-".$quote[custId]."-".$sa[saId], 
				'associate' => $sa[saId],
				'custid' => $quote[custId], 
				'amount' => $quote[currentPrice]
            );

            //gets the return value
            $info=$this->POGateway->getDateAndRate($data);

            if(!isset($info->errors))
            {
                //calculate the commission
                $commission=$quote[currentPrice]*($info->commission/100);

                //update the the commission to the PO and sales associate
                $this->quote->setDateAndCommission($quoteId,$info->processDay,$commission);
                $this->SA->updateCommission($quote[salesAssociate],$commission);
            }

            return $info;
        }
    }
?>
