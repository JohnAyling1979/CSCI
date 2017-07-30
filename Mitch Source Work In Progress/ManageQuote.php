<?php

    include "QuoteStore.php";

    class ManageQuote
    {
        // associate the variable with a container
        var $quoteStore;

        // use a constructor to create a new object
        function __construct()
        {
            $this->qStore = new QuoteStore ();
        }

        // retrieves the finalized quote from the Quote Database
        public function getFinalizedQuote($finalizeQuote)
        {
            return $this->$qStore->getFinalizedQuote ($finalizeQuote);
        }

        // updates the sanctioned quote to the Quote Database
        public function updateQuote($quoteSanctioned)
        {
            return $this->$qStore->updateQuote ($quoteSanctioned);
        }
    }
?>