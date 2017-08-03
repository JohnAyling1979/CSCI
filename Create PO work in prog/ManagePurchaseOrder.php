<?php
    class ManagePurchaseOrder
    {
        var $POGateway;
        var $quote;
        var $SA;

        public function __construct()
        {
            $this->POGateway=new PurchaseOrderGateway;
            $this->quote=new QuoteStore;
            $this->SA=new SAstore;

        }

        public function getSanctionedQuotes()
        {
            return $this->quote->getSanctionedQuotes();
        }

        public function getQuote($quoteId)
        {
            return $this->quote->getQuote($quoteId);
        }

        public function getLineItems($quoteId)
        {
            return $this->quote->getLineItems($quoteId);
        }

        public function createPurchaseOrder($quoteId,$price)
        {
            $this->quote->createPurchaseOrder($quoteId,$price);
            $quote=$this->quote->getQuote($quoteId);
            $data=array
            (
                'order' => $quote[quoteId], 
				'associate' => $quote[salesAssociate],
				'custid' => $quote[custId], 
				'amount' => $quote[currentPrice]
            );
            $info=$this->POGateway->getDateAndRate($data);
            $commission=$quote[currentPrice]*($info->commission/100);
            $this->quote->setDateAndCommission($quoteId,$info->processDay,$commission);
            $this->SA->updateCommission($quote[salesAssociate],$commission);
        }
    }
?>
