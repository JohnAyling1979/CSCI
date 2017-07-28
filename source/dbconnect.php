<?php

    function connect($host,$user,$password)
    {
        $dsn="mysql:dbname=".$user.";host=".$host;

        try
        {
            $db=new PDO($dsn,$user,$password);
        }
        catch(PDOException $e)
        {
            echo "Connection failed: ".$e->getMessage();
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
