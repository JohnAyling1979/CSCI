<h2>Search Quote</h2>

<h3>Select a Sales Associate to search by</h3>

<?php
$projList = $_SESSION['controller']->getSA();            
print "<form method=POST action="admin.php?page=quoteList">";
print "<select name=associate>";
					foreach ($associate as $sa) {
						print "<option>" . $sa->name . "</option>";
					}
print "<button>Find</button>";
print "</form>";
?>