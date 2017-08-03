<?php
    class ManagePurchaseOrder
    {
        public function getSanctionedQuotes()
        {
            return $_SESSION['quote']->getSanctionedQuotes();
        }
    }
?>
