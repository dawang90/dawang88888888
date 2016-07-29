<!DOCTYPE html>
<html>
<body>
<?php
    $con = mysql_connect("localhost:3306","root","");
    if (!$con)
    {
        die('Could not connect: ' . mysql_error());
    }

    if(mysql_query("CREATE DATABASE my_db",$con)){
        echo "Database created";
    }else{
        echo "Error creating database" . mysql_error();
    }

    mysql_select_db("my_db",$con);

    $sql = "CREATE TABLE USERS(
      ID int NOT NULL AUTO_INCREMENT,
      PRIMARY KEY(ID),
      user varchar(15),
      password varchar(15),
      nickname varchar(15)
    )";

   mysql_query($sql,$con);

    mysql_close($con);
    // some code
?>
</body>
</html>