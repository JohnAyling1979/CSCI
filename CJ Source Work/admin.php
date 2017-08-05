<!DOCTYPE html>
<!--
Driver page for the admin interface
-->
<html>
<head>

<?php
//needed files
require "AdminManage.php";
require "SAstore.php";
require "QuoteStore.php";
require "AdminGUI.php";

//creates the instance of the class if not set
    if(!isset($interface))
        $interface=new AdminGUI;

//when a post is submited
    if($_SERVER[REQUEST_METHOD]=="POST")
    {
        //Manage SA
        if(isset($_POST['associate']))
        {
            $interface->manageSA();
        }
        //edit SA
        if(isset($_POST['edit']))
        {
            $interface->editSearch();
        }
        //Creat SA
        if(isset($_POST['create']))
        {
            $interface->creatSA();
        }
		//Delete SA
        if(isset($_POST['dSA']))
        {
            $interface->deleteSearch();
        }
		//editSearch
        if(isset($_POST['eSearch']))
        {
            $interface->editList($_POST[name]);
        }
		//editFind
        if(isset($_POST['eFind']))
        {
            $interface->editSA($_POST[saName]);
        }
		//Edit SA
        if(isset($_POST['editUpdate']))
        {
echo $_POST[saId]."<br>";
echo $_POST[name]."<br>";
echo $_POST[password]."<br>";
echo $_POST[address]."<br>";
echo $_POST[commission]."<br>";
//            $interface->updateSA($_POST[saId],$_POST[name],$_POST[password],$_POST[address],$_POST[commission]);
        }
		//creat SA
        if(isset($_POST['screat']))
        {
            $interface->updateSA($_POST[saId],$_POST[name],$_POST[password],$_POST[address],$_POST[commission]);
        }
		//DeleteSearch
        if(isset($_POST['Dsearch']))
        {
            $interface->deleteList($_POST[name]);
        }
		//DeleteFind
        if(isset($_POST['Dfind']))
        {
		$interface->submitDelete($_POST[Dsa]);
        }
		//Delete SA
        if(isset($_POST['sdelete']))
        {
		$interface->deleteSA($_POST[Dsa]);
        }
		//View Quots
        if(isset($_POST['quote']))
        {
            $interface->quoteOption();
        }
		//View quots by status
        if(isset($_POST['status']))
        {
            $interface->Qstatus();
        }
		//View quots by date
        if(isset($_POST['date']))
        {
            $interface->Qdate();
        }
		//View quots by associate
        if(isset($_POST['QuoteAssociate']))
        {
            $interface->Qassociate();
        }
		//View quots by customer
        if(isset($_POST['customer']))
        {
            $interface->Qcustomer();
        }
		//List quots that match status
        if(isset($_POST['statusSUB']))
        {
            $interface->QStatusList($_POST[Stype]);
        }
		//List quots by customer
        if(isset($_POST['customerSUB']))
        {
            $interface->QCustList($_POST[cust]);
        }
		//List quots by SA
        if(isset($_POST['associateSUB']))
        {
            $interface->QAssoList($_POST[assoc]);
        }
		//List quots by Date
        if(isset($_POST['dateSUB']))
        {
            $interface->QDateList($_POST[start],$_POST[end]);
		}
		//View Quots
        if(isset($_POST['VIEWQUOTE']))
        {
			$interface->QuoteView($_POST[quoteId]);
		}
		//View Quots
        if(isset($_POST['DELEATNOW']))
        {
            $interface->Deleteing($_POST[name]);
		}
	}
    //begining interface
    else
    {   
        $interface->index();
    }
?>
 </body>
</html>