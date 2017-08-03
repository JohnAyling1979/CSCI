<?php
    class CreatePurchaseOrderGUI
    {
        public function displayQuotes()
        {
            $list=$_SESSION['controller']->getSanctionedQuotes();
            echo "<title>SanctionedQuotes</title>";
            echo "</head>";
            echo "<body>";
            echo "<form>";
            echo "<select>";
            foreach($list as $row)
                echo "<option value=$row[quoteId]>$row[quoteID]-$row[customerName]</option>";
            echo "</select>";
            echo "</form>";
        }

    }
?>
