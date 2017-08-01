<?php session_start();?>

<!-- SanctionQuoteGUI Driver Page -->

<!DOCTYPE html>
<HTML>
<head>
    <meta charset="utf-8">

    <script type="text/javascript">
        onload = function(){ document.forms['sanctionQuote.php'].reset()}
    </script>

    <form action="sanctionQuote.php" method="POST">

	<?php
        // files required for operation
        require "QuoteStore.php";
        require "ManageQuote.php";
        require "SanctionQuoteGUI.php";
        require "dbconnect.php";

        // create new instance of the classes
        $quoteList = new QuoteStore;
        $controller = new ManageQuote;
        $interface = new SanctionQuoteGUI;

        $interface->displayQuote($controller, $quoteList);
        $interface->addLineItems($quoteList);
    ?>
</form>
</body>
</HTML>