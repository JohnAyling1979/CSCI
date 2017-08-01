        <div class="header">
            <h2>Update Employee Data</h2>
        </div>

        <div class="content">
            <h2 class="content-subhead">Employee Information</h2>
            <p>
				<?php
					$emp = new Employee($_POST);
					print $_SESSION['controller']->updateSA($sa);
				?>
			</p>
			<?php include 'php/footer.php'; ?>
       </div>