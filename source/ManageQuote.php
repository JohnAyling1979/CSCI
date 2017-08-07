<?php
    class ManageQuote
    {
        // constructor of a new instance of the QuoteStore class
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

        // displays the current price of the quote
        public function calculatePrice($quoteId)
        {
            $row=$this->quoteStore->calculatePrice($quoteId);
            return $row[currentPrice];
        }

        // displays the current price in the discount field
        public function calculateFinalPrice($quoteId)
        {
            $row=$this->quoteStore->calculateFinalPrice($quoteId);
            return $row[currentPrice];
        }
    }
?>