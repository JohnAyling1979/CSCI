<h2>Search Quote</h2>

<h3>Select a Customer to search by</h3>

<?php
$projList = $_SESSION['controller']->getCustomer();            
print "<form method=POST action="admin.php?page=quoteList">";
print "<select name=customer>";
					foreach ($customer as $cust) {
						print "<option>" . $cust->name . "</option>";
					}
print "<button>Find</button>";
print "</form>";
?>