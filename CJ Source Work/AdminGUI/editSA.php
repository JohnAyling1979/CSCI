<h2>Update Sales Associate</h2>

<h3>Sales Associate Information</h3>
 <p>
	<?php
	$emp = $_SESSION['controller']->getSA($_POST['saId']);
	echo "<form method=POST action=admin.php?page=updateSA>";
	//ID as key hidden
	echo "<input type=hidden name='saId' value='" . $sa->asId . "'>";
	echo "<table>";
	//insert Name
	echo "<tr><td>";
	echo "Name";
	echo "</td><td>";
	echo "<input type=text name=name value='" . $sa->name . "'><br>";
	echo "</td></tr><tr><td>";
	//insert Password
	echo "Password";
	echo "</td><td>";
	echo "<input type=password name=password value='" . $sa->password . "'><br>";
	echo "</td></tr><tr><td>";
	//insert address
	echo "Address";
	echo "</td><td>";
	echo "<input type=text name=address value='" . $sa->address . "'><br>";
	echo "</td></tr><tr><td>";
	//insert commission
	echo "Commission";
	echo "</td><td>";
	echo "<input type=text name=commission value='" . $sa->commission . "'><br>";
	echo "</td></tr><tr><td>";
	echo "</table>";
	echo "<button>Update</button>";
	echo "</form>";
	?>
</p>