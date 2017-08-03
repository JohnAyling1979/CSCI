<?php
    class CreatePurchaseOrderGUI
    {
        var $controller;

        public function __construct()
        {
            $this->controller=new ManagePurchaseOrder;

        }
        public function chooseQuote()
        {
            $list=$this->controller->getSanctionedQuotes();
            echo "<title>SanctionedQuotes</title>";
            echo "</head>";
            echo "<body>";
            echo "Select a sactioned quote from the dropdown<br>";
            echo "<form method=POST>";
            echo "<select name='quoteId'>";
            foreach($list as $row)
                echo "<option value=$row[quoteId]>$row[quoteId]-$row[customerName]</option>";
            echo "</select><br>";
            echo "<input type='submit' name='picked' value='choose'>";
            echo "</form>";
        }

        public function displayQuote($quoteId)
        {
            $quote=$this->controller->getQuote($quoteId);
            echo "<title>Quote</title>";
            echo "</head>";
            echo "<body>";
            echo "Customer: ".$quote[customerName]."<br>";
            echo "Street: ".$quote[customerAddress]."<br>";
            echo "City: ".$quote[customerCity]."<br>";
            echo "Email: ".$quote[customerEmail]."<br>";
            echo "Sales Associate: ".$quote[salesAssociate]."<br>";
            echo "<hr>";
            echo "<table width=100%>";
            echo "<tr><th>Description</th><th>Price</th><th>Secert Note</th></tr>";
            $lines=$this->controller->getLineItems($quoteId);
            foreach($lines as $line)
            {
                echo "<tr><td>$line[description]</td><td>$$line[price]</td><td>$line[secretNote]</td></tr>";
            }
            echo "</table>";
            echo "Current Total: $".$quote[currentPrice];    
            echo "<hr>";
            echo "<form method=POST>";
            echo "<table>";
            echo "<input type='hidden' name='quoteId' value='$quoteId'>";
            echo "<tr><th>Final discount</th></tr>";
            echo "<tr><td>Dollor amount:</td><td><input type='text' name='amount'></td></tr>";
            echo "<tr><td>Percent amount:</td><td><input type='text' name='percent'></td></tr>";
            echo "</table>";
            echo "<input type='submit' name='update' value='Create PO'>";
            echo "</form>";        
        }

        public function createPurchaseOrder($quoteId,$amount,$percent)
        {
            $quote=$this->controller->getQuote($quoteId);

            $price=$quote[currentPrice];

            $price=$price-$amount;
            $price=$price-$price*$percent;
            
            $this->controller->createPurchaseOrder($quoteId,$price);

            echo "<title>Quote</title>";
            echo "</head>";
            echo "<body>";
            echo "Email has been sent<br>";
            echo "<a href='createPO.php'>Return</a>";
        }
    }
?>
