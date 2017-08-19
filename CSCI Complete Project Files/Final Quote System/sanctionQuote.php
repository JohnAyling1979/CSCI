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

        // create new instance of the classes
         $interface=new SanctionQuoteGUI;

        // display the quote selection interface
        $interface->displayQuote(); 

        // if a quote is selected, display the quote and editing functions
        if($_SERVER[REQUEST_METHOD] == "POST")
        {
            if(isset($_POST[viewQuote]))
            {
                // save the user selection to a session variable
                $_SESSION["quoteId"] = $_POST["quoteId"];
                $interface->viewQuote();
                $interface->calculatePrice($_SESSION[quoteId]);
                $interface->addLineItems();
                $interface->editLineItems();
                $interface->removeLineItems();
                $interface->addSecretNote();
                $interface->editSecretNote();
                $interface->calculateDiscounts();
                $interface->calculateFinalPrice($_SESSION[quoteId]);
                $interface->updateQuote();

            } // end if

            // On Submit: Send the information to the function for processing
            if(isset($_POST[submit]))
            {
                if ($_POST[type] == "Add Line Items")
                {
                    $interface->callAddLineItem($_SESSION[quoteId],$_POST[addDescription],$_POST[addPrice]);
                }

                if ($_POST[type] == "Edit Line Items")
                {
                    $interface->callEditLineItem($_SESSION[quoteId],$_POST[lineId],$_POST[editDescription],$_POST[editPrice]);
                }

                if ($_POST[type] == "Remove Line Items")
                {
                    $interface->callRemoveLineItem($_SESSION[quoteId],$_POST[lineId]);
                }

                if ($_POST[type] == "Add Secret Note")
                {
                    $interface->callAddSecretNote($_POST[lineId],$_POST[secretNote]);
                }

                if ($_POST[type] == "Edit Secret Note")
                {
                    $interface->callEditSecretNote($_POST[lineId],$_POST[secretNote]);
                }

                if ($_POST[type] == "Apply Discount")
                {
                    $interface->callCalculateDiscount($_SESSION[quoteId], $_POST[amount],$_POST[percentage]);
                }

                $interface->viewQuote();
                $interface->calculatePrice($_SESSION[quoteId]);
                $interface->addLineItems();
                $interface->editLineItems();
                $interface->removeLineItems();
                $interface->addSecretNote();
                $interface->editSecretNote();
                $interface->calculateDiscounts();
                $interface->calculateFinalPrice($_SESSION[quoteId]);
                $interface->updateQuote();
                
            }          
        
            if (isset($_POST[end]))
            {
                $interface->callUpdateQuote($_SESSION[quoteId]);
            }

        } // end if
    ?>
</body>
</HTML>

<script type="text/javascript">
    function emailSent()
    {
        alert("A confirmation email has been sent to the customer")
    }
</script>
