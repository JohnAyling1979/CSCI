<?php
    class ManageQuote
    {
        // retrieves the finalized quote from the Quote Database
        public function getFinalizedQuote($quoteList)
        {
            return $quoteList->getFinalizedQuote();
        }

        // updates the sanctioned quote to the Quote Database
        public function updateQuote($isSanctioned)
        {
            return $isSanctioned->updateQuote();
        }
    }
?>