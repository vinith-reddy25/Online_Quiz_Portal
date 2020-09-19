<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>User Signup</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="quiz.css" rel="stylesheet" type="text/css">
</head>

<body>
<?php
include("header.php");
extract($_POST);
include("database.php");
$rs=mysqli_query("select * from mst_teacher where login='$lid'");
if (mysqli_num_rows($rs)>0)
{
	echo "<br><br><br><div class=head1>Login Id Already Exists</div>";
	exit;
}
$query="insert into mst_teacher(login,pass,username,address,city,phone,email) values('$lid','$pass','$name','$address','$city','$phone','$email')";
$rs=mysqli_query($cn,$query)or die("Could Not Perform the Query".mysqli_error($cn));
echo "<br><br><br><div class=head1>Your Login ID  $lid Created Sucessfully</div>";
echo "<br><div class=head1>Please Login using your Login ID to add Quiz</div>";
echo "<br><div class=head1><a href=index1.php>Login</a></div>";


?>
</body>
</html>

