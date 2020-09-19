<?php
/*
Allows the user to both create new records and edit existing records
*/

// connect to the database
include("connect-db.php");

// creates the new/edit record form
// since this form is used multiple times in this file, I have made it a function that is easily reusable
function renderForm($login = '', $pass ='', $username ='', $address ='', $city ='', $phone ='', $email ='', $error = '', $id = '')
{ ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>
<?php if ($id != '') { echo "Edit Record"; } else { echo "New Record"; } ?>
</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>
<h1><?php if (id != '') { echo "Edit Record"; } else { echo "New Record"; } ?></h1>
<?php if ($error != '') {
echo "<div style='padding:4px; border:1px solid red; color:red'>" . $error
. "</div>";
} ?>

<form action="" method="post">
<div>
<?php if ($id != '') { ?>
<input type="hidden" name="id" value="<?php echo $id; ?>" />
<p>User-ID: <?php echo $id; ?></p>
<?php } ?>

<strong>Login ID: *</strong> <input type="text" name="login"
value="<?php echo $login; ?>"/><br/>
<strong>password: *</strong> <input type="text" name="pass"
value="<?php echo $pass; ?>"/><br/>
<strong>User-Name: *</strong> <input type="text" name="username"
value="<?php echo $username; ?>"/><br/>
<strong>Address: *</strong> <input type="text" name="address"
value="<?php echo $address; ?>"/><br/>
<strong>City: *</strong> <input type="text" name="city"
value="<?php echo $city; ?>"/><br/>
<strong>Phone number: *</strong> <input type="text" name="phone"
value="<?php echo $phone; ?>"/><br/>
<strong>Email-ID: *</strong> <input type="text" name="email"
value="<?php echo $email; ?>"/>
<p>* required</p>
<input type="submit" name="submit" value="Submit" />
</div>
</form>
</body>
</html>

<?php }



/*

EDIT RECORD

*/
// if the 'id' variable is set in the URL, we know that we need to edit a record
if (isset($_GET['id']))
{
// if the form's submit button is clicked, we need to process the form
if (isset($_POST['submit']))
{
// make sure the 'id' in the URL is valid
if (is_numeric($_POST['id']))
{
// get variables from the URL/form
$id = $_POST['id'];
$login = htmlentities($_POST['login'], ENT_QUOTES);
$pass = htmlentities($_POST['pass'], ENT_QUOTES);
$username = htmlentities($_POST['username'], ENT_QUOTES);
$address = htmlentities($_POST['address'], ENT_QUOTES);
$city = htmlentities($_POST['city'], ENT_QUOTES);
$phone = htmlentities($_POST['phone'], ENT_QUOTES);
$email = htmlentities($_POST['email'], ENT_QUOTES);

// check that firstname and lastname are both not empty
if ($login == '' || $pass == '' || $username =='' || $address =='' || $city =='' || $phone =='' || $email =='')
{
// if they are empty, show an error message and display the form
$error = 'ERROR: Please fill in all required fields!';
renderForm($login, $pass, $username, $address, $city, $phone, $email, $error, $id);
}
else
{
	
// if everything is fine, update the record in the database
if ($stmt = $mysqli->prepare("UPDATE mst_user SET login = ?, pass = ?, username = ?, address = ?, city = ?, phone = ?, email = ? WHERE user_id=?"))
{
$stmt->bind_param("ssi", $login, $pass, $username, $address, $city, $phone, $email, $id);
$stmt->execute();
$stmt->close();
}
// show an error message if the query has an error
else
{
echo "ERROR: could not prepare SQL statement.";
}

// redirect the user once the form is updated
header("Location: view.php");
}
}
// if the 'id' variable is not valid, show an error message
else
{
echo "Error!";
}
}
// if the form hasn't been submitted yet, get the info from the database and show the form
else
{
// make sure the 'id' value is valid
if (is_numeric($_GET['id']) && $_GET['id'] > 0)
{
// get 'id' from URL
$id = $_GET['id'];

// get the recod from the database
if($stmt = $mysqli->prepare("SELECT * FROM mst_user WHERE user_id=?"))
{
$stmt->bind_param("i", $id);
$stmt->execute();

$stmt->bind_result($id, $login, $pass, $username, $address, $city, $phone, $email);
$stmt->fetch();

// show the form
renderForm($login, $pass, $username, $address, $city, $phone, $email, NULL, $id);

$stmt->close();
}
// show an error if the query has an error
else
{
echo "Error: could not prepare SQL statement";
}
}
// if the 'id' value is not valid, redirect the user back to the view.php page
else
{
header("Location: view.php");
}
}
}



/*

NEW RECORD

*/
// if the 'id' variable is not set in the URL, we must be creating a new record
else
{
// if the form's submit button is clicked, we need to process the form
if (isset($_POST['submit']))
{
// get the form data
$login = htmlentities($_POST['login'], ENT_QUOTES);
$pass = htmlentities($_POST['pass'], ENT_QUOTES);
$username = htmlentities($_POST['username'], ENT_QUOTES);
$address = htmlentities($_POST['address'], ENT_QUOTES);
$city = htmlentities($_POST['city'], ENT_QUOTES);
$phone = htmlentities($_POST['phone'], ENT_QUOTES);
$email = htmlentities($_POST['email'], ENT_QUOTES);

// check that firstname and lastname are both not empty
if ($login == '' || $pass == '' || $username =='' || $address =='' || $city =='' || $phone =='' || $email =='')
{
// if they are empty, show an error message and display the form
$error = 'ERROR: Please fill in all required fields!';
renderForm($login, $pass, $username, $address, $city, $phone, $email, $error);
}
else
{
// insert the new record into the database

if ($stmt = $mysqli->prepare("INSERT mst_user (login, pass, username, address, city, phone, email) VALUES (?, ?, ?, ?, ?, ?, ?)"))
{
$stmt->bind_param("ss", $login, $pass, $username, $address, $city, $phone, $email);
$stmt->execute();
$stmt->close();
}
// show an error if the query has an error
else
{
echo "ERROR: Could not prepare SQL statement.";
}

// redirec the user
header("Location: view.php");
}

}
// if the form hasn't been submitted yet, show the form
else
{
renderForm();
}
}

// close the mysqli connection
$mysqli->close();
?>