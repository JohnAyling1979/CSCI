<h2>Delete sales associate</h2>

<h3> Select sales associate to be delete</h3>
	<p>
	<?php
	$empList = $_SESSION['controller']->findSA($_POST['search']);
	print "<table><tr><th>select</th><th>Name</th><th>Address</th></tr>";
	foreach ($saList as $sa)
	{
		print "<tr><td><form method=POST action=admin.php?page=confirmDelete>";
		print "<button name='saId' value='" . $sa->saId . "'>Delete</button></form></td>";
		print "<td>&nbsp;" . $sa->name . "</td>";
		print "<td>&nbsp;" . $sa->address . "</td></tr>";
	}
	print "</table>";
	?>
	</p>