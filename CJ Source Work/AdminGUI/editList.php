<h2>Edit Employee Data</h2>

<h2>Select Employee to Edit</h2>
<p>
<?php
$saList = $_SESSION['controller']->findSA($_POST['search']);
print "<table><tr><th>select</th><th>Name</th><th>Address</th></tr>";
foreach ($saList as $sa) 
{
	print "<tr><td><form method=POST action=index.php?page=editSA>";
	print "<button name='saId' value='" . $sa->saId . "'>Edit</button></form></td>";
	print "<td>&nbsp;" . $sa->name . "</td>";
	print "<td>&nbsp;" . $sa->address . "</td></tr>";
}
print "</table>";
?>
</p>