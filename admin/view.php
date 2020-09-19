<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>View Records</title>
<link rel="stylesheet" href="G:\Fall sem-2018-19-5\wamp\apache2\htdocs\Online_exam_New\admin\w3.css"></link>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>

<h1>View Records</h1>

<p><b>View All</b> | <a href="view-paginated.php">View Paginated</a></p>

<?php
echo "<link rel='stylesheet' href='https://www.w3schools.com/w3css/4/w3.css'>";
// connect to the database
include('connect-db.php');

// get the records from the database
if ($result = $mysqli->query("SELECT * FROM mst_user ORDER BY user_id"))
{
// display records if there are records to display
if ($result->num_rows > 0)
{
// display records in a table
echo "<table border='1' cellpadding='10' class='w3-table-all' class='w3-table w3-striped w3-border'>";

// set table headers
echo "<tr><th>USER-ID</th><th>LOGIN ID</th><th>PASSWORD</th><th>USERNAME</th><th>ADDRESS</th><th>CITY</th><th>PHONE NUM</th><th>EMAIL</th><th></th><th></th></tr>";

while ($row = $result->fetch_object())
{
// set up a row for each record
echo "<tr>";
echo "<td>" . $row->user_id . "</td>";
echo "<td>" . $row->login . "</td>";
echo "<td>" . $row->pass . "</td>";
echo "<td>" . $row->username . "</td>";
echo "<td>" . $row->address . "</td>";
echo "<td>" . $row->city . "</td>";
echo "<td>" . $row->phone . "</td>";
echo "<td>" . $row->email . "</td>";
echo "<td><a href='records.php?id=" . $row->user_id . "'>Edit</a></td>";
echo "<td><a href='delete.php?id=" . $row->user_id . "'>Delete</a></td>";
echo "</tr>";
}

echo "</table>";
}
// if there are no records in the database, display an alert message
else
{
echo "No results to display!";
}
}
// show an error if there is an issue with the database query
else
{
echo "Error: " . $mysqli->error;
}

// close database connection
$mysqli->close();

?>

<a href="records.php">Add New Record</a>
</body>
</html>