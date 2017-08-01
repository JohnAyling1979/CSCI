<h2>Delete sales associate</h2>

<h2>sales associate Information</h2>
<p>
<?php
$emp = $_SESSION['controller']->getSA($_POST['id']);
print "<form method=POST action=admin.php?page=deleteSA>";
print "<input type=text readonly name='saId' value='" . $sa->saId . "'>";
print "<input type=text readonly name=Name value='" . $sa->Name . "'><br>";
print "<input type=text readonly name=address value='" . $sa->address . "'><br>";
print "<button>Confirm Delete</button>";
print "</form>";
?>
</p>