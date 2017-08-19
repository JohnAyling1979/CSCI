<?php
    class ManageQuote
    {
        // constructor of a new instance of the QuoteStore class
        public function __construct()
        {
            $this->quoteStore = new QuoteStore;
        }

        // retrieves the finalized quote from the Quote Database
        public function getQuote($quoteId)
        {
            return $this->quoteStore->getQuote($quoteId);
        }

        // retrieves the finalized quote from the Quote Database
        public function getLineItems($quoteId)
        {
            return $this->quoteStore->getLineItems($quoteId);
        }

        // retrieves the finalized quote from the Quote Database
        public function addLineItems($quoteId,$description,$price)
        {
            return $this->quoteStore->addLineItems($quoteId,$description,$price);
        }

        // retrieves the finalized quote from the Quote Database
        public function editLineItems($quoteId,$lineId,$description,$price)
        {
            return $this->quoteStore->editLineItems($quoteId,$lineId,$description,$price);
        }

        // retrieves the finalized quote from the Quote Database
        public function removeLineItems($quoteId, $lineId)
        {
            return $this->quoteStore->removeLineItems($quoteId, $lineId);
        }

        // retrieves the finalized quote from the Quote Database
        public function viewEmptySecretNote($quoteId)
        {
            return $this->quoteStore->viewEmptySecretNote($quoteId);
        }

        // retrieves the finalized quote from the Quote Database
        public function viewAttachedSecretNote($quoteId)
        {
            return $this->quoteStore->viewAttachedSecretNote($quoteId);
        }

        // retrieves the finalized quote from the Quote Database
        public function addSecretNote($lineId,$secretNote)
        {
            return $this->quoteStore->addSecretNote($lineId,$secretNote);
        }

        // retrieves the finalized quote from the Quote Database
        public function editSecretNote($lineId,$secretNote)
        {
            return $this->quoteStore->editSecretNote($lineId,$secretNote);
        }

        // retrieves the finalized quote from the Quote Database
        public function getFinalizedQuote()
        {
            return $this->quoteStore->getFinalizedQuote();
        }

        // updates the sanctioned quote to the Quote Database
        public function updateQuote($quoteId)
        {
            return $this->quoteStore->updateQuote($quoteId);
        }

        // displays the current price of the quote
        public function calculatePrice($quoteId)
        {
            $row=$this->quoteStore->calculatePrice($quoteId);
            return $row[currentPrice];
        }
        
        // displays the current price of the quote
        public function calculateDiscounts($quoteId, $amount,$percentage)
        {
            $this->quoteStore->calculateDiscounts($quoteId, $amount,$percentage);
        }

        // displays the current price in the discount field
        public function calculateFinalPrice($quoteId)
        {
            $row=$this->quoteStore->calculateFinalPrice($quoteId);
            return $row[currentPrice];
        }
    }
?>