<?php 
$file = 'newpage.html';
// Open the file to get existing content
$current = file_get_contents($file);
// Append a new person to the file
$current .= "<!doctype html><html>
<head><meta charset='utf-8'>
<title>new file</title>
</head><body><h3>New HTML file</h3>
</body></html>
";
// Write the contents back to the file
file_put_contents($file, $current);
?>