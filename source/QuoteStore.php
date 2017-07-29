<?php
    //class used to communicate with the quote database
    class QuoteStore
    {
        //use to save a finalized quote to the database
        public function finalizeQuote()
        {
            $db=connect("courses","z981329","z981329","1979Jul29");
            $into="insert into Quote(customerName,customerAddress,customerCity,customerEmail,isFinalized,salesAssociate)
                   values('$_SESSION[customerName]','$_SESSION[customerAdd]','$_SESSION[customerCity]','$_POST[email]',1,'$_SESSION[user]')";
 
            if($db->exec($into)>0)
            {
                echo "Quote has been saved and finalized<br>";
                echo "<a href='http://students.cs.niu.edu/~z981329/CSCI467/createquote.php'>Return</a><br>";
                $quote=$db->lastInsertId();
                $n=0;
                $desc="desc".$n;
                $price="price".$n;
                $secret="secret".$n;
                while(isset($_POST[$desc]))
                {
                    $into="insert into LineItem(quoteId,description,price,secretNote)
                           values($quote,'$_POST[$desc]','$_POST[$price]','$_POST[$secret]')";
                    $db->exec($into);
                    $n=$n+1;
                    $desc="desc".$n;
                    $price="price".$n;
                    $secret="secret".$n;
                }
            }
        }
    }
?>
