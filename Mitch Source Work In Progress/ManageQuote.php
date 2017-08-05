<?php
    class ManageQuote
    {
        public function __construct()
        {
            $this->quoteStore = new QuoteStore;
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

        public function calculatePrice($quoteId)
        {
            $row=$this->quoteStore->calculatePrice($quoteId);
            return $row[currentPrice];
        }

        public function calculateFinalPrice($quoteId)
        {
            $row=$this->quoteStore->calculateFinalPrice($quoteId);
            return $row[currentPrice];
        }
    }
?>