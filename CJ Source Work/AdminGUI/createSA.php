<h2>Add Sales Associate</h2>
<p>
<?php

	echo '<h3>Fill out the info below to add a new sales associate</h3>';
	//Form to except entries
	echo '<form name="sa" id="sa" action=admin.php?page=updateSA method="post">';
	echo "<table>";
	//input boxes for user to enter First and last name
	//Formated using a table
	echo "<tr><td>";
	//insert Name
	echo "<label for='saname'>Name </label>";
	echo "</td><td>";
	echo "<input type='text' required name='sa[saname]' id='sa[saname]'><br>";
	echo "</td></tr><tr><td>";
	//insert Password
	echo "<label for='password'>Password </label>";
	echo "</td><td>";
	echo "<input type='password' required name='sa[password]' id='sa[password]'><br>";
	echo "</td></tr><tr><td>";
	//insert address
	echo "<label for='address'>Address </label>";
	echo "</td><td>";
	echo "<input type='text' required name='sa[address]' id='sa[address]'><br>";
	echo "</td></tr><tr><td>";
	echo "</table>";	
	//end of form to save info as variable on submit
	echo '<br><input type="submit" value="Insert"> <input type="reset" value="Clear"><br>';
	echo '<input type="hidden" name="which" value="sa">';
	echo "</form>";
?>
</p>