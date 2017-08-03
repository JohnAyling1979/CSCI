<?php
    class ManageQuote
    {
        // retrieves the finalized quote from the Quote Database
        public function getFinalizedQuote($quoteStore)
        {
            return $quoteStore->getFinalizedQuote();
        }

        // updates the sanctioned quote to the Quote Database
        public function updateQuote($status)
        {
            return $status->updateQuote();
        }
    }
?>