        <div class="header">
            <h2>Update Employee Data</h2>
        </div>

        <div class="content">
            <h2 class="content-subhead">Employee Information</h2>
            <p>
				<?php
					$emp = $_SESSION['controller']->getEmployee($_POST['id']);
					$projList = $_SESSION['controller']->getProjects();
					print "<form method=POST action=index.php?page=updateEmployee>";
					print "<input type=hidden name='id' value='" . $emp->id . "'>";
					print "<table>";
					print "<tr><td>Name: </td><td><input type=text name=name value='" . $emp->name . "'></td></tr>";
					print "<tr><td>Address: </td><td><input type=text name=address value='" . $emp->address . "'></td></tr>";
					print "<tr><td>Salary: </td><td><input type=text name=salary value='" . $emp->salary . "'></td></tr>";
					print "<tr><td>Project: </td><td><select name=project>";
					foreach ($projList as $proj) {
						if ($proj->id == $emp->project) {
							print "<option selected>" . $proj->id . "</option>";
						} else {
							print "<option>" . $proj->id . "</option>";
						}
					}
					print "</select></td></tr>";
					print "<tr><td>Bank #: </td><td><input type=text name=routingnumber value='" . $emp->routingnumber . "'></td></tr>";
					print "<tr><td>Account #: </td><td><input type=text name=accountnumber value='" . $emp->accountnumber . "'></td></tr>";
					print "</table><p>";
					print "<button>Update</button>";
					print "</p></form>";
				?>
			</p>
			<?php include 'php/footer.php'; ?>
       </div>       
