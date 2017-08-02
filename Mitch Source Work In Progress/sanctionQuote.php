<?php session_start();?>

<!-- SanctionQuoteGUI Driver Page -->

<!DOCTYPE html>
<HTML>
<head>
    <meta charset="utf-8">
    <!--<form method="post">-->

	<?php
        // files required for operation
        require "QuoteStore.php";
        require "ManageQuote.php";
        require "SanctionQuoteGUI.php";
        require "dbconnect.php";

        // create new instance of the classes
        $quoteStore = new QuoteStore;
        $controller = new ManageQuote;
        $interface = new SanctionQuoteGUI;

        $interface->displayQuote($controller, $quoteStore);
        $interface->addLineItems($quoteStore);
        $interface->editLineItems($quoteStore);
        
        if($_SERVER[REQUEST_METHOD] == "POST")
        {
            if(isset($_POST[submitLineItems]))
            {
                $quoteStore->addLineItems($_POST[quoteId], $_POST[addDescription], $_POST[addPrice]);
            }

            if(isset($_POST[editLineItems]))
            {
                $quoteStore->editLineItems($_POST[quoteId], $_POST[lineID], $_POST[editDescription], $_POST[editPrice]);
            }
        }
    ?>
<!--</form>-->
</body>
</HTML>