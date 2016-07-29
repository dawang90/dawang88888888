<!DOCTYPE html>
<html>
<body>
<?php
$con = mysql_connect("localhost:3306","root","");
// some code
if(!$con){
    die('Could not Connect:' .mysql_error());
}

mysql_select_db("my_db",$con);

$sql="INSERT INTO users(email, password, full_name)
  VALUES
  ('$_POST[email]', '$_POST[password]', '$_POST[full_name]')
";

if(!mysql_query($sql,$con)){
    die('Error: ' . mysql_error());
}

echo "注册成功";

mysql_close($con);
?>
</body>
</html>