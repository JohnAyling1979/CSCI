<html>
	<head><title>Test of Gateway</title></head>
	<body>
		<form method=post>
			Order:<input type='text' name='order'><br>
			associate:<input type='text' name='ass'><br>
			custid:<input type='text' name='cust'><br>
			amount:<input type='text' name='amount'><br>
			<button type=submit name='press'>press</button>
		</form>
		<?php
			require "PurchaseOrderGateway.php";

		if(isset($_POST[press]))
		{
			$PO=new PurchaseOrderGateway;

			$data = array
			(
				'order' => $_POST[order], 
				'associate' => $_POST[ass],
				'custid' => $_POST[cust], 
				'amount' => $_POST[amount]
			);

			$result=$PO->getDateAndRate($data);
			echo "Date: ".$result->processDay."<br>";
			echo "Rate: ".$result->commission."<br>";
		}
		?>
	</body>
</html>
