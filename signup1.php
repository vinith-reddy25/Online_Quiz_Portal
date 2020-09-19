<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>New user signup </title>
<link href="quiz.css" rel="stylesheet" type="text/css">
</head>

<body>
    <?php
   include("header.php");
	$lidErr = $passErr = $confirmpassErr = $nameErr = $phoneErr= $emailErr="";
	$existsErr="";
	$lid = $pass = $cpass= $name = $address = $city= $phone= $email ="";
	$count=0;
	$cn=mysqli_connect("localhost","root","") or die("Could not Connect My Sql".mysqli_error($cn));
	mysqli_select_db($cn,"quiz_new")or die("Could connect to Database".mysqli_error($cn));


	 if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$lid=$_POST["lid"];
		$pass=$_POST["pass"];
		$cpass=$_POST["cpass"];
		$name=$_POST["name"];
		$address=$_POST["address"];
		$city=$_POST["city"];
		$phone=$_POST["phone"];
		$email=$_POST["email"];
		
		$userid_pat="/^[a-z]+$/";
		$pass_pat="/^[a-zA-Z0-9.,@#%&^$*_+-]{8,20}$/";
		$name_pat="/^[a-z]+$/";
		$phone_pat="/^[0-9]{10}$/";
		$email_pat="/^[a-zA-Z0-9_.]+@[a-z]+[.]com$/";
		
		if(!preg_match($userid_pat,$lid)) 
		{
		$lidErr = "Invalid login id";
		$lid="";
		$count++;
		}
		if(!preg_match($pass_pat,$pass))
		{
			$passErr="*Password length should be between 8 to 20.";
			$pass="";
			$count++;
		}
		if($cpass!=$pass)
		{
			$confirmpassErr="password doesn't match";
			$cpass="";
			$count++;
		}
		if(!preg_match($name_pat,$name))
		{
			$nameErr="invalid name format";
			$name="";
			$count++;
		}
		if(!preg_match($phone_pat,$phone))
		{
			$phoneErr="phone num should be 10 digit only";
			$phone="";
			$count++;
		}
		if(!preg_match($email_pat,$email))
		{
			$emailErr="invalid email address";
			$email="";
			$count++;
		}
			$q="select * from mst_user where login='{$lid}'";
		$rs=mysqli_query($cn,$q)or die("could not excute the query".mysqli_error($cn));
		if (mysqli_num_rows($rs)>0)
		{
			$existsErr="Login Id Already Exists";
			$count++;
		}
		if(isset($_POST['submit']))
		   {
			   if($count==0)
			   {
				  if(!$cn)
				  {
					die("Connection failed:".mysqli_connect_error());
				  }
				  else
				  {
					$query="insert into mst_user(login,pass,username,address,city,phone,email) values('$lid','$pass','$name','$address','$city','$phone','$email')";
					if(mysqli_query($cn,$query))
					{
						header("Location:index.php");
					}
					else
					  {
						$existsErr="*user already exists";
					  }
				  }
			   }

		
		   }
    }
?>

<table width="100%" border="0">
   <tr>
     <td width="132" rowspan="2" valign="top"><span class="style8"><img src="images/connected_multiple_big.jpg" width="131" height="155"></span></td>
     <td width="468" height="57"><h1 align="center"><span class="style8">New User Signup</span></h1></td>
   </tr>
   <tr>
     <td><form method="post">
       <table width="301" border="0" align="left">
         <tr>
           <td><div align="left" class="style7">Login Id </div></td>
           <td><input type="text" name="lid" value="<?php echo $lid;?>" required>
               <span>* <?php echo $lidErr;?></span></td>
         </tr>
         <tr>
           <td class="style7">Password</td>
           <td><input type="password" name="pass" value="<?php echo $pass;?>" required>
			   <span>* <?php echo $passErr;?></span></td>
         </tr>
         <tr>
           <td class="style7">Confirm Password </td>
           <td><input type="password" name="cpass" value="<?php echo $cpass;?>" required>
			   <span> <?php echo $confirmpassErr;?></span></td>
         </tr>
         <tr>
           <td class="style7">Name</td>
           <td><input type="text" name="name" value="<?php echo $name;?>" required>
			   <span>* <?php echo $nameErr;?></span></td>
         </tr>
         <tr>
           <td valign="top" class="style7">Address</td>
           <td><input type="text" name="address" value="<?php echo $address;?>" required>
			   <span>* <?php echo $addressErr;?></span></textarea></td>
         </tr>
         <tr>
           <td valign="top" class="style7">City</td>
           <td><input type="text" name="city" value="<?php echo $city;?>" required>
			   <span>* <?php echo $cityErr;?></span></td>
         </tr>
         <tr>
           <td valign="top" class="style7">Phone</td>
           <td><input type="text" name="phone" value="<?php echo $phone;?>" required>
			   <span>* <?php echo $phoneErr;?></span></td>
         </tr>
         <tr>
           <td valign="top" class="style7">E-mail</td>
           <td><input type="text" name="email" value="<?php echo $email;?>" required>
			   <span>* <?php echo $emailErr;?></span></td>
         </tr>
		 <tr>
		    <td>
			<center><span style="color:red"><?php echo $existsErr;?></span></center>
			</td>
         <tr>
           <td>&nbsp;</td>
           <td><input type="submit" name="submit" value="Signup">
           </td>
         </tr>
       </table>
     </form></td>
   </tr>
   <tr>
   <td>
     <p style = "text-align:center;"> Already have an account? <a href="index.php" style="padding-left:10px;"> Login</a></p>
   </td>
   </tr>
 </table>
 <p>&nbsp; </p>
</body>
</html>
