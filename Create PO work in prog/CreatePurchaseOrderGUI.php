<?php
    class CreatePurchaseOrderGUI
    {
        public function chooseQuote()
        {
            $list=$_SESSION['controller']->getSanctionedQuotes();
            echo "<title>SanctionedQuotes</title>";
            echo "</head>";
            echo "<body>";
            echo "<form method=POST>";
            echo "<select name='quoteId'>";
            foreach($list as $row)
                echo "<option value=$row[quoteId]>$row[quoteId]-$row[customerName]</option>";
            echo "</select>";
            echo "<input type='submit' name='picked' value='choose'>";
            echo "</form>";
        }

        public function displayQuote($quoteId)
        {
            echo $quoteId;
        }
    }
?>
