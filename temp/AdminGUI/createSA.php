<h2>Add Sales Associate</h2>
<p>
<?php

	echo '<h3>Fill out the info below to add a new sales associate</h3>';
	//Form to except entries
	echo '<form action=admin.php?page=updateSA method="post">';
	echo "<table>";
	//input boxes for user to enter First and last name
	//Formated using a table
	echo "<tr><td>";
	//insert Name
	echo "Name";
	echo "</td><td>";
	echo "<input type='text' required name='name'><br>";
	echo "</td></tr><tr><td>";
	//insert Password
	echo "Password";
	echo "</td><td>";
	echo "<input type='password' required name='password'><br>";
	echo "</td></tr><tr><td>";
	//insert address
	echo "Address";
	echo "</td><td>";
	echo "<input type='text' required name='address'><br>";
	echo "</td></tr><tr><td>";
	echo "</table>";	
	//end of form to save info as variable on submit
	echo '<br><button>Update</button><br>';
	echo "</form>";
?>
</p>