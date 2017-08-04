<h2>Update Sales Associate</h2>

<h3>Sales Associate Information</h3>
<p>
	<?php
	$sa = new Associate($_POST);
	print $_SESSION['controller']->updateSA($sa);
	?>
</p>