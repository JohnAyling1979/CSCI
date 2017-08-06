<?php
    class SanctionGUI
    {
        var $controller;

        public function __construct()
        {
            $this->controller=new ManageQuote;
        }

        public function index()
        {
            $list=$this->controller->getFinalized();
            echo "<title>Finalized</title>";
            echo "</head>";
            echo "<body>";
            echo "<form method=POST>";
            echo "<select name=quoteId required>";
            foreach($list as $row)
                echo "<option value=$row[quoteId]>$row[quoteId] - $row[customerName]</option>";
            echo "<input type='submit' name=picked value=Enter>";
            echo "</form>";
        }

        public function displayQuote($quoteId)
        {
            $quote=$this->controller->getQuote($quoteId);
            $lines=$this->controller->getLineItems($quoteId);

            echo "<title>Quote information</title>";
            echo "</head>";
            echo "<body>";
            echo "<h1>Quote Information</h1>";
            echo "Quote #:$quote[quoteId]<br>";
            echo "Customer:$quote[customerName]<br>";
            echo "Street:$quote[customerAddress]<br>";
            echo "City:$quote[customerCity]<br>";
            echo "Email:$quote[customerEmail]<br>";
            echo "Sales Asscociate:$quote[salesAssociate]<br>";
            echo "Current Price:$quote[currentPrice]<br>";
            echo "<hr>";
            echo "\t\t<button onclick='addLine()'>Add Line</button>\r\n";
            echo "<form method=POST>";
            echo "<input type=hidden name=quoteId value='$quote[quoteId]'>";
            echo "<table width=100%>";
            echo "<tr><th>Description</th><th>Price</th><th>Secret Note</th></tr>";
            $n=0;
            foreach($lines as $row)
            {
                $desc="desc".$n;
                $price="price".$n;
                $note="note".$n;
                echo "<tr><td><input type='text' name='$desc' value='$row[description]'></td>";
                echo "<td><input type='text' name='$price' value='$row[price]'></td>";
                echo "<td><input type='text' name='$note' value='$row[secretNote]'></td></tr>";
                $n++;
            }
            echo "\t\t\t\t<tr><td id='line1'></td><td id='line2'></td><td id='line3'></td></tr>\r\n";
            echo "</table>";
            echo "<input type=submit name=update value='submit changes'>";
            echo "</form>";
            echo "<hr>";
            echo "<form method=POST>";
            echo "<table>";
            echo "<input type='hidden' name='quoteId' value='$quote[quoteId]'>";
            echo "<tr><th>Final discount</th></tr>";
            echo "<tr><td><input type='radio' name='type' value='dollar' checked>Dollar amount:</td><td>$<input type='text' name='dollar'></td></tr>";
            echo "<tr><td><input type='radio' name='type' value='percent'>Percent amount:</td><td><input type='text' name='percent'>%</td></tr>";
            echo "</table>";
            echo "<input type='submit' name='discount' value='Apply'>";
            echo "</form>";        
?>
<!--javascript to add line items to the screen -->
<script>
    //starting row number
    var n=<?php echo $n;?>;

    /****************************************************************
       FUNCTION:   addLine

       ARGUMENTS:  none

       RETURNS:    none

       USAGE:      adds a row to the screen for a new line item
    ****************************************************************/
    function addLine()
    {
        //arrays for each input
        var desc={};
        desc[n]=document.createElement("input");
        var dl=document.createElement("br");

        var price={};
        price[n]=document.createElement("input");
        var pl=document.createElement("br");

        var secret={};
        secret[n]=document.createElement("input");
	    var sl=document.createElement("br");

        //attributes for each element
        desc[n].type="text";
        desc[n].id=n;
        desc[n].name="desc"+n;

        price[n].type="text";
        price[n].id=n;
        price[n].name="price"+n;


        secret[n].type="text";
        secret[n].id=n;
        secret[n].name="note"+n;

        //append the line to the table
        document.getElementById("line1").appendChild(desc[n]);
    	document.getElementById("line1").appendChild(dl);

        document.getElementById("line2").appendChild(price[n]);
        document.getElementById("line2").appendChild(pl);

        document.getElementById("line3").appendChild(secret[n]);
        document.getElementById("line3").appendChild(sl);

        //increase row count
        n++;
    }
</script>
<?php
        }

        public function updateQuote($quoteId)
        {
            $this->controller->updateQuote($quoteId);
            $this->displayQuote($quoteId);

        }

        public function discount($quoteId,$type,$dollar,$percent)
        {
            $price=$this->controller->discount($quoteId,$type,$dollar,$percent);
            echo "<title>Final Price</title>";
            echo "</head>";
            echo "<body>";
            echo "<h1>Final Price</h1>";
            echo "$".number_format($price,2);
            echo "<form method=POST>";
            echo "<input type=hidden name=quoteId value=$quoteId>";
            echo "<input type='submit' name='yes' value='Sanction'>";
            echo "<input type='submit' name='no' value='Unresolved'>";
            echo "</form>";
        }

        public function saction($quoteId)
        {
            $this->controller->saction($quoteId);
            echo "<title>Quote Sactioned</title>";
            echo "</head>";
            echo "<body>";
            echo "Email has been sent<br>";
            $this->end();
        }

        public function end()
        {
            echo "<a href='sanction.php'>Return</a>";
        }
    }
?>
