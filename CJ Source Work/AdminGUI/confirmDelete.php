<h2>Delete sales associate</h2>

<h3>sales associate Information</h3>
<p>
<?php
$sa = $_SESSION['controller']->getSA($_POST['saId']);
print "<form method=POST action=admin.php?page=deleteSA>";
print "<input type=text readonly name='saId' value='" . $sa->saId . "'>";
print "<input type=text readonly name=Name value='" . $sa->name . "'><br>";
print "<input type=text readonly name=address value='" . $sa->address . "'><br>";
print "<button>Confirm Delete</button>";
print "</form>";
?>
</p>