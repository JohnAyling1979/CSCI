<?php session_start();?>

<!-- SanctionQuoteGUI Driver Page -->

<!DOCTYPE html>
<HTML>
<head>
    <meta charset="utf-8">

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

        if($_SERVER[REQUEST_METHOD] == "POST")
        {
            if(isset($_POST[viewQuote]))
            {
                $interface->viewQuote($controller, $quoteStore);
                $interface->calculatePrice($_SESSION[quoteId]);
                $interface->addLineItems($quoteStore);
                $interface->editLineItems($quoteStore);
                $interface->removeLineItems($quoteStore);
                $interface->addSecretNote($quoteStore);
                $interface->editSecretNote($quoteStore);
                $interface->updateQuote($controller, $quoteStore);
            }

            if(isset($_POST[submitLineItems]))
            {
                $quoteStore->addLineItems($_SESSION[quoteId], $_POST[addDescription], $_POST[addPrice]);
                //$interface->viewQuote($controller, $quoteStore);
                //echo $_REQUEST['quoteId'];
            }

            if(isset($_POST[editLineItems]))
            {
                $quoteStore->editLineItems($_SESSION[quoteId], $_POST[lineId], $_POST[editDescription], $_POST[editPrice]);
                //echo $_REQUEST['quoteId'];
                //$interface->viewQuote($controller, $quoteStore); 
            }

            if(isset($_POST[removeLineItems]))
            {
                $quoteStore->removeLineItems($_POST[lineId]);
                //echo $_REQUEST['quoteId'];
                //$interface->viewQuote($controller, $quoteStore); 
            }

            if(isset($_POST[submitSecretNote]))
            {
                $quoteStore->addSecretNote($_POST[lineId], $_POST[addSecretNote]);
                //echo $_REQUEST['quoteId'];
                //$interface->viewQuote($controller, $quoteStore); 
            }

            if(isset($_POST[submitSecretNoteEdit]))
            {
                $quoteStore->editSecretNote($_SESSION[quoteId], $_POST[lineId], $_POST[editSecretNote]);
                //echo $_REQUEST['quoteId'];
                //$interface->viewQuote($controller, $quoteStore); 
            }

            if(isset($_POST[submitSanction]))
            {
                $quoteStore->updateQuote($_SESSION[quoteId]);
                //echo $_REQUEST['quoteId'];
                //$interface->viewQuote($controller, $quoteStore); 
            }
        }
    ?>
</body>
</HTML>