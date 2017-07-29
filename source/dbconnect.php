<?php
    /*******************************************************************
        FUNCTION:   connect()
        ARGUMENTS:  $host: host name
                    $DB: database name
                    $user: user name
                    $password: password
        RETURNS:    a PDO object
        USAGE:      to create a connection to a database
    *******************************************************************/
    function connect($host,$DB,$user,$password)
    {
        //creates the dsn for the PDO
        $dsn="mysql:dbname=".$DB.";host=".$host;

        //trys the connection
        try
        {
            $db=new PDO($dsn,$user,$password);
        }
        //if there are errors display error and exit
        catch(PDOException $e)
        {
            echo "Connection failed: Database can not be reached<br>".$e->getMessage();
            die();
        }

        //returns PDO object
        return $db;
    }

    /*******************************************************************
        FUNCTION:   protect()
        ARGUMENTS:  $input: input string to clean up
        RETURNS:    a clean string
        USAGE:      removes bad characters from an input string
    *******************************************************************/
    function protect($input)
    {
        //clean up
        $output=trim($input);
        $output=strip_tags($output);
        $output=htmlspecialchars($output);

        //return clean string
        return $output;
    }
?>
