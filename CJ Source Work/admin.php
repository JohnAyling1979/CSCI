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
//require "QuoteStore.php";
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
            $interface->editSA($_POST[sa]);
        }
		//Edit SA
        if(isset($_POST['editUpdate']))
        {
            $interface->updateSA($_POST[name],$_POST[password],$_POST[address],$_POST[commission],$_POST[saId]);
        }
		//creat SA
        if(isset($_POST['screat']))
        {
            $interface->updateSA($_POST[name],$_POST[password],$_POST[address],$_POST[commission],$_POST[saId]);
        }
		//DeleteSearch
        if(isset($_POST['Dsearch']))
        {
            $interface->deleteList($_POST[name]);
        }
		//DeleteFind
        if(isset($_POST['Dfind']))
        {
		$interface->submitDelete($_POST[saId]);
        }
		//Delete SA
        if(isset($_POST['sdelete']))
        {
            $interface->deleteSA();
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