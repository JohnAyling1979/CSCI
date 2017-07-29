<?php

    function connect($host,$DB,$user,$password)
    {
        $dsn="mysql:dbname=".$DB.";host=".$host;

        try
        {
            $db=new PDO($dsn,$user,$password);
        }
        catch(PDOException $e)
        {
            echo "Connection failed: Database can not be reached<br>".$e->getMessage();
        }
        return $db;
    }

    function protect($input)
    {
        $output=trim($input);
        $output=strip_tags($output);
        $output=htmlspecialchars($output);

        return $output;
    }
?>
