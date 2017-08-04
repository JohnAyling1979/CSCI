<?php
include "AdminManage.php";
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<title>Administir System</title>
</head>
<?php
if (!isset($_SESSION['controller'])) 
{
	$_SESSION['controller'] = new AdminManage;
}
?>
<body>
<center><h1>Administer System</h1></center>
<p  align="center">
 [ <a href="?page=manageSA">Manage Sales Associate</a> ]
 [ <a href="?page=quoteOption">View Quote</a> ]
<p>

<?php
//Open to home.php untill page is selected
if(!isset($_GET['page']))
{
    $file = 'home.php';
}
//Set path once clicked
else
{
    $file = $_GET['page'] . '.php';
}
// Set Folder path
$filepath = dirname(__FILE__) . '/AdminGUI/' . $file;

//open php
include($filepath);
?>
</body>
</html>
