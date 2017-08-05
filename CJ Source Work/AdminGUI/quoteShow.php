<?php
	$quotesByID = $controller->getFinalizedQuote($quoteStore);
    // display a dropdown box with a default selection
    print ('<form method=post>
			Select a finalized Quote 
            <select name="quoteId">
            <option value="" disabled selected>Quote by ID and Customer Name</option>
    ');
    
	// diplay quotes by ID in the drop down box
	foreach ($quotesByID as $row)
	{
		echo "<option value='".$row["quoteId"]. "'>" .$row["quoteId"]. " - " .$row["customerName"]."</option>";
	}
        
    // display submit button
    print ('</select>
            <input type="submit" name="viewQuote" value="Submit">
            </form>
            <br><br>
    ');
?>