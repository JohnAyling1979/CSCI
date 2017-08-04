<?php
    class ManageQuote
    {
        public function __construct()
        {
            $this->quoteStore = new QuoteStore;
        }
        // retrieves the finalized quote from the Quote Database
        public function getFinalizedQuote($quoteId)
        {
            return $this->quoteStore->getFinalizedQuote($quoteId);
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
    }
?>
